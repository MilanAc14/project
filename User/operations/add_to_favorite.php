<?php
session_start();
require '../components/_dbconnect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../loginsystem/login.php");
    exit();
}

if (isset($_POST['add_to_favorites'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];

    // Check if the product is already in the favorites
    $check_sql = "SELECT * FROM favorites WHERE user_id = $user_id AND product_id = $product_id";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) === 0) {
        // Insert the product into favorites if it's not already there
        $insert_sql = "INSERT INTO favorites (user_id, product_id) VALUES ($user_id, $product_id)";
        if (mysqli_query($conn, $insert_sql)) {
            // Successfully added to favorites
            header("Location: ../favorites.php");
            exit();
        } else {
            // Handle insertion error
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // Product is already in favorites
        header("Location: ../favorites.php");
        exit();
    }
}

// Close the database connection
mysqli_close($conn);
?>
