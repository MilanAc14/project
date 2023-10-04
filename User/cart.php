<?php
session_start();
require 'components/_dbconnect.php'; // Include your database connection script

// Check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
} else {
    $user_id = null;
}

// Check if the logout flag is set to true and clear the cart if needed
if (isset($_SESSION['logout']) && $_SESSION['logout'] == true) {
    // Clear the cart for the logged-in user
    if (isset($_SESSION['cart'])) {
        unset($_SESSION['cart']);
    }

    // Remove the logout flag
    unset($_SESSION['logout']);
}

// Initialize an empty array to store the product details in the cart
$cart_products = [];

// Check if the product ID and size are provided in the POST request
if (isset($_POST['product_id'], $_POST['size'])) {
    $product_id = $_POST['product_id'];
    $size = $_POST['size']; // Get the selected size from the form

    // If the user is logged in, store the cart data in the database
    if ($user_id !== null) {
        // Check if the product with the same size is already in the user's cart
        $check_cart_query = "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id' AND size = '$size'";
        $check_cart_result = mysqli_query($conn, $check_cart_query);

        if ($check_cart_result && mysqli_num_rows($check_cart_result) > 0) {
            // If the product is already in the cart with the same size, update the quantity
            $row = mysqli_fetch_assoc($check_cart_result);
            $new_quantity = $row['quantity'] + 1;
            $update_cart_query = "UPDATE cart SET quantity = '$new_quantity' WHERE cart_id = '" . $row['cart_id'] . "'";
            mysqli_query($conn, $update_cart_query);
        } else {
            // If the product is not in the cart or has a different size, insert it
            $insert_cart_query = "INSERT INTO cart (user_id, product_id, size, quantity) VALUES ('$user_id', '$product_id', '$size', 1)";
            mysqli_query($conn, $insert_cart_query);
        }
    } else {
        // If the user is not logged in, store the cart data in a session
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        // Include the size in the session cart
        $_SESSION['cart'][] = [
            'product_id' => $product_id,
            'size' => $size,
        ];
    }
}

// Handle removing items from the cart
if (isset($_POST['remove_product_id'])) {
    $remove_product_id = $_POST['remove_product_id'];

    // If the user is logged in, remove the product from the database
    if ($user_id !== null) {
        $remove_cart_query = "DELETE FROM cart WHERE user_id = '$user_id' AND cart_id = '$remove_product_id'";
        mysqli_query($conn, $remove_cart_query);
    } else {
        // If the user is not logged in, remove the product from the session cart
        if (isset($_SESSION['cart'])) {
            $key = array_search($remove_product_id, array_column($_SESSION['cart'], 'product_id'));
            if ($key !== false) {
                unset($_SESSION['cart'][$key]);
            }
        }
    }
}

// Fetch cart items and product details for both logged-in and non-logged-in users
$cart_query = "SELECT cart.cart_id, products.product_id, products.product_image, products.product_name, products.product_price, cart.size, cart.quantity
               FROM cart
               INNER JOIN products ON cart.product_id = products.product_id";

// Add a WHERE clause to filter by user ID if the user is logged in
if ($user_id !== null) {
    $cart_query .= " WHERE cart.user_id = '$user_id'";
}

$cart_result = mysqli_query($conn, $cart_query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="css/footer.css">
    <!-- Google Fonts link -->
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Roboto+Condensed:wght@300;400&family=Roboto+Serif:opsz,wght@8..144,100;8..144,400&family=Smokum&display=swap" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <!-- Navigation bar -->
    <?php require 'components/_header.php'?>

    <div class="container mt-5 mb-5">
        <div class="card" style="width: 100%;">
            <span class="fs-1 text-center badge bg-light text-dark">Your Cart</span>

            <?php
            // Display the cart items in a table
            $total_amount = 0; // Initialize total amount

// Display the cart items in a table
if ($cart_result && mysqli_num_rows($cart_result) > 0) {
    echo '<div class="table-responsive mt-2">
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th class="text-center">Image</th>
                        <th>Product Name</th>
                        <th>Price (rupees)</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';

    while ($product = mysqli_fetch_assoc($cart_result)) {
        echo '<tr>
                <td class="text-center">
                    <img src="../admin/' . $product['product_image'] . '" class="img-thumbnail" alt="' . $product['product_name'] . '" style="width: 175px; height: 150px;">
                </td>
                <td>' . $product['product_name'] . '</td>
                <td>' . $product['product_price'] . '</td>
                <td>' . $product['size'] . '</td>
                <td>' . $product['quantity'] . '</td>
                <td>
                    <form method="post" action="operations/remove_product.php">
                        <input type="hidden" name="remove_product_id" value="' . $product['cart_id'] . '">
                        <button type="submit" class="btn btn-danger">Remove</button>
                    </form>
                </td>
            </tr>';
        
        // Calculate total amount
        $total_amount += ($product['product_price'] * $product['quantity']);
    }

    echo '</tbody>
        </table>
    </div>';
    
    // Display the total amount and checkout button
    echo '<span class="d-grid gap-3 col-10 mx-auto badge rounded-pill bg-dark fs-4 pt-2 pb-2 mb-3">Total Amount: ' . $total_amount . ' rupees</span>';
    
    // Display the checkout button, which will check the login status using JavaScript
    echo '
    <div class="d-grid gap-3 col-4 mx-auto">
        <button type="button" id="checkoutButton" style="height: 70px" class="text-uppercase fs-3 btn btn-primary mb-5">Checkout</button>
    </div>';
} else {
    // Display a message when the cart is empty
    echo '<p>Your cart is empty.</p>';
}

            ?>
        </div>
    </div>

    <!-- JavaScript to check login status and redirect to the appropriate page -->
    <script>
        document.getElementById('checkoutButton').addEventListener('click', function () {
            <?php
            if ($user_id === null) {
                // Redirect to the login page if the user is not logged in
                echo 'window.location.href = "loginsystem/login.php";';
            } else {
                // Redirect to the checkout page if the user is logged in
                echo 'window.location.href = "operations/checkout.php";';
            }
            ?>
        });
    </script>

    <!-- Footer section -->
    <?php require 'components/_footer.php'?>

    <!-- Bootstrap core JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>
