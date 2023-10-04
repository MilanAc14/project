<?php
session_start();
require 'components/_dbconnect.php'; // Include your database connection script

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // User is not logged in, redirect to the login page
    header("Location: loginsystem/login.php");
    exit;
}

// Fetch user information
$user_id = $_SESSION['user_id'];
$user_query = "SELECT * FROM users_info WHERE user_id = '$user_id'";
$user_result = mysqli_query($conn, $user_query);

if ($user_result && mysqli_num_rows($user_result) > 0) {
    $user_data = mysqli_fetch_assoc($user_result);
} else {
    // Handle the case where user details are not found
}

// Fetch order details
$order_query = "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY order_id DESC LIMIT 1";
$order_result = mysqli_query($conn, $order_query);

if ($order_result && mysqli_num_rows($order_result) > 0) {
    $order_data = mysqli_fetch_assoc($order_result);
} else {
    echo 'Sorry !! your order is not placed please check your details and make sure to login';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link rel="stylesheet" href="css/footer.css">
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
       <!-- navigation bar -->
       <?php require 'components/_header.php'?>
    <!-- Display a thank you message -->
    <div class="container mt-5">
        <div class="alert alert-success text-center" role="alert">
            <h2>Thank You for Your Order</h2>
            <p>Your order has been placed successfully. Order details have been sent to your email.</p>
        </div>
    </div>

    <!-- Display order details if available -->
    <?php if (!empty($order_data)) { ?>
        <div class="container mt-3">
            <h3>Your Order Details</h3>
            <p>Order ID: <?php echo $order_data['order_id']; ?></p>
            <p>Total Amount: <?php echo $order_data['total_amount']; ?> rupees</p>
            <p>Delivery Address: <?php echo $order_data['delivery_address']; ?></p>
            <p>Payment Method: <?php echo $order_data['payment_method']; ?></p>
            <p>Contact Number: <?php echo $order_data['contact_number']; ?></p>
        </div>
    <?php } ?>

    <!-- Footer section -->
    <?php require 'components/_footer.php' ?>
    <!-- Bootstrap core javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>
