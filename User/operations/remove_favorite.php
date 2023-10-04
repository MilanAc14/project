<?php
session_start();
require '../components/_dbconnect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../loginsystem/login.php");
    exit();
}

if (isset($_POST['remove_favorites'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];

    // Delete the product from the user's favorites
    $delete_sql = "DELETE FROM favorites WHERE user_id = $user_id AND product_id = $product_id";

    if (mysqli_query($conn, $delete_sql)) {
        // Successfully removed from favorites
        header("Location: ../favorites.php");
        exit();
    } else {
        // Handle deletion error
        echo "Error: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>
