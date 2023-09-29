<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: /adminlogin/admin_login.php");
    exit;
}

include '../components/_dbconnect.php';

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Query to delete the product from the database
    $delete_sql = "DELETE FROM products WHERE product_id = $product_id";

    if (mysqli_query($conn, $delete_sql)) {
        // Product deleted successfully
        $_SESSION['delete_success'] = true; // Set a session variable
        header("location: ../products.php");
        exit;
    } else {
        // Error deleting product
        $error_message = "Error deleting the product. Please try again.";
    }
} else {
    // Product ID not provided in the URL
    header("location: ../products.php");
    exit;
}
?>
