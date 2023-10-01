<?php
session_start();
require 'components/_dbconnect.php'; // Include your database connection script
// Check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  
    $user_id = $_SESSION['user_id'];
} else {
   
    $user_id = null;
}

// Initialize an empty array to store the product details in the cart
$cart_products = [];

// Check if the product ID is provided in the POST request
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Check if the product is already in the cart for this user
    $existing_quantity = 0;

    // If the user is logged in, check the database for their cart
    if ($user_id !== null) {
        $existing_query = "SELECT quantity FROM cart WHERE user_id = '$user_id' AND product_id = $product_id";
        $existing_result = mysqli_query($conn, $existing_query);

        if ($existing_result && mysqli_num_rows($existing_result) > 0) {
            $existing_row = mysqli_fetch_assoc($existing_result);
            $existing_quantity = $existing_row['quantity'];
        }
    }

    // Update the quantity if the product is already in the cart; otherwise, add it
    if ($existing_quantity > 0) {
        $new_quantity = $existing_quantity + 1;
        $update_query = "UPDATE cart SET quantity = $new_quantity WHERE user_id = '$user_id' AND product_id = $product_id";
        mysqli_query($conn, $update_query);
    } else {
        // If the user is not logged in, store the cart data in a session or cookie
        if ($user_id === null) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            $_SESSION['cart'][] = $product_id;
        } else {
            // If the user is logged in, update the database cart
            $insert_query = "INSERT INTO cart (user_id, product_id) VALUES ('$user_id', $product_id)";
            mysqli_query($conn, $insert_query);
        }
    }
}

// Fetch cart items and product details
$cart_query = "SELECT cart.product_id, products.product_name, products.product_price, cart.quantity
               FROM cart
               INNER JOIN products ON cart.product_id = products.product_id";

// Add a WHERE clause to filter by user ID if the user is logged in
if ($user_id !== null) {
    $cart_query .= " WHERE cart.user_id = '$user_id'";
}

$cart_result = mysqli_query($conn, $cart_query);

$cart_products = [];
$total_amount = 0;

if ($cart_result && mysqli_num_rows($cart_result) > 0) {
    while ($row = mysqli_fetch_assoc($cart_result)) {
        $cart_products[] = $row;
        $total_amount += $row['product_price'] * $row['quantity'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
</head>

<body>
    <h1>Your Cart</h1>

    <?php
    // Display the cart items
    if (!empty($cart_products)) {
        foreach ($cart_products as $product) {
            echo '<div class="product-details">';
            echo '<h3>' . $product['product_name'] . '</h3>';
            echo '<p>Price: ' . $product['product_price'] . ' rupees</p>';
            echo '<p>Quantity: ' . $product['quantity'] . '</p>';
            // Add more details as needed
            echo '</div>';
        }

        // Display the total amount and checkout button
        echo '<p>Total Amount: ' . $total_amount . ' rupees</p>';

        if ($user_id === null) {
            // If the user is not logged in, display a login message or button
            echo '<p>Please <a href="login.php">log in</a> to complete your purchase.</p>';
        } else {
            // If the user is logged in, display a checkout button
            echo '<button type="button"><a href="operations/checkout.php">Checkout</a></button>';

        }
    } else {
        echo '<p>Your cart is empty.</p>';
    }
    ?>

</body>

</html>
