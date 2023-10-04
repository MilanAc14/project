<?php
session_start();
require '../components/_dbconnect.php';
$delevery_charges= 100;

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // User is not logged in, redirect to the login page
    header("Location: ../loginsystem/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_query = "SELECT * FROM users_info WHERE user_id = '$user_id'";
$user_result = mysqli_query($conn, $user_query);

if ($user_result && mysqli_num_rows($user_result) > 0) {
    $user_data = mysqli_fetch_assoc($user_result);
} else {
    // Handle the case where user details are not found
}

// Fetch cart items and product details
$cart_query = "SELECT cart.product_id, products.product_name, products.product_price, cart.quantity
               FROM cart
               INNER JOIN products ON cart.product_id = products.product_id
               WHERE cart.user_id = '$user_id'";

$cart_result = mysqli_query($conn, $cart_query);

$cart_products = [];
$total_amount = 0;

if ($cart_result && mysqli_num_rows($cart_result) > 0) {
    while ($row = mysqli_fetch_assoc($cart_result)) {
        $cart_products[] = $row;
        $total_amount += $row['product_price'] * $row['quantity'];
    }
}

if (isset($_POST['place_order'])) {
    // Process the order and insert order details into the database
    $delivery_address = mysqli_real_escape_string($conn, $_POST['delivery_address']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);

    // Insert the order into the orders table
    $insert_order_query = "INSERT INTO orders (user_id, total_amount, delivery_address, payment_method, contact_number)
                           VALUES ('$user_id', '$total_amount', '$delivery_address', '$payment_method', '$contact_number')";
    mysqli_query($conn, $insert_order_query);

    // Get the last inserted order_id
    $order_id = mysqli_insert_id($conn);

    // Insert the product details into the ordered_items table
    foreach ($cart_products as $product) {
        $product_id = $product['product_id'];
        $quantity = $product['quantity'];

        $insert_ordered_item_query = "INSERT INTO ordered_items (order_id, product_id, quantity)
                                     VALUES ('$order_id', '$product_id', '$quantity')";
        mysqli_query($conn, $insert_ordered_item_query);
    }

    // Clear the user's cart from the database
    $clear_cart_query = "DELETE FROM cart WHERE user_id = '$user_id'";
    mysqli_query($conn, $clear_cart_query);

    // Clear the cart session
    $_SESSION['cart'] = [];

    // Redirect to a thank you page
    header("Location: ../thank_you.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
      
    <link rel="stylesheet" href="../css/footer.css">
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
</head>

<body>
     <!-- navigation bar -->
     <?php require '../components/_header.php'?>
    <div class="container">
    <span class="fs-1 text-uppercase text-center mt-2 mb-5 badge bg-light text-dark">Order Confirmation </span>

    <?php
    if (!empty($cart_products)) {
        // Display cart items and user information
        echo '<h2>Your Cart:</h2>';
        foreach ($cart_products as $product) {
            echo '<div class="product-details">
            <h3>' . $product['product_name'] . '</h3>
            <p>Price: ' . $product['product_price'] . ' rupees</p>
            <p>Quantity: ' . $product['quantity'] . '</p>
            
            </div>';
        }
        echo' <span class="fs-5 text-left mb-3">Delivery charges:'.$delevery_charges.'  rupees </span>';
    echo '<span class=" d-grid gap-3  col-10 mx-auto badge rounded-pill bg-dark fs-4 pt-2 pb-2 mt-3 mb-3">Total Amount: ' . $total_amount + $delevery_charges. ' rupees</span>';
        // Display user information
        echo ' <div class="card mb-5 mt-5">
        <h2>User Information:</h2>
        <p>Name: ' . $user_data['username'] . '</p>
        <p>Email: ' . $user_data['email'] .'

      
        <form method="post">
        <label for="delivery_address">Delivery Address:</label>
        <input type="text" id="delivery_address" name="delivery_address" required><br>

        <label for="payment_method">Payment Method:</label>
        <select id="payment_method" name="payment_method" required>
        <option value="Cash On Delivery">Cash On delivery</option>
        </select><br>

        <label for="contact_number">Contact Number:</label>
        <input type="text" id="contact_number" name="contact_number" required><br>

       
        
        <div class="d-grid gap-3  col-4 mx-auto">
        <input type="submit" class=" text-uppercase fs-3 btn btn-primary mb-5 " name="place_order" value="Place Order"> 
        </div>
    </form>
    </div>';
    } else {
        echo '<p>Your cart is empty.</p>';
    }
    ?>
    </div>

 <!-- footer section  -->
 <?php require '../components/_footer.php'?>
    <!-- Bootstrap core javascript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>
