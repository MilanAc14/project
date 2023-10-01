<?php
session_start();
require '../components/_dbconnect.php';

// Check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $user_id = $_SESSION['user_id'];
} else {
    header("Location: ../loginsystem/login.php"); // Redirect to login page if not logged in
    exit();
}

// Check if the cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: ../cart.php"); 
    exit();
}

// Fetch user's cart items and details
$cart_items = $_SESSION['cart'];

// Calculate the total amount based on the cart items and their quantities
$total_amount = 0;
foreach ($cart_items as $product_id) {
    // Retrieve product details from the database (you may need to fetch more details)
    $product_query = "SELECT product_price FROM products WHERE product_id = $product_id";
    $product_result = mysqli_query($conn, $product_query);

    if ($product_result && mysqli_num_rows($product_result) > 0) {
        $product_row = mysqli_fetch_assoc($product_result);
        $product_price = $product_row['product_price'];

        // Calculate the total amount
        $total_amount += $product_price;
    }
}

// Handle the payment and order confirmation (you can implement your payment gateway logic here)
// For this example, we will assume a simple order confirmation without payment processing

// Insert the order into the orders table
$order_insert_query = "INSERT INTO orders (user_id, total_amount) VALUES ('$user_id', $total_amount)";
mysqli_query($conn, $order_insert_query);

// Get the order ID (you may need to fetch the last inserted ID)
$order_id = mysqli_insert_id($conn);

// Insert each item from the cart into the order_items table
foreach ($cart_items as $product_id) {
    $order_item_insert_query = "INSERT INTO order_items (order_id, product_id, quantity) VALUES ($order_id, $product_id, 1)";
    mysqli_query($conn, $order_item_insert_query);
}

// Clear the user's cart (since the items are now in the order)
unset($_SESSION['cart']);

// Display a confirmation message
?>
