<?php
session_start();
require '../components/_dbconnect.php'; // Include your database connection script

// Check if the product_id key exists in the POST data
if (isset($_POST['remove_product_id'])) {
    $product_id = $_POST['remove_product_id'];

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        // Check if the user_id key exists in the session
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        if ($user_id !== null) {
            // If the user is logged in, check the product quantity in the database
            $check_cart_query = "SELECT * FROM cart WHERE user_id = '$user_id' AND cart_id = '$product_id'";
            $check_cart_result = mysqli_query($conn, $check_cart_query);

            if ($check_cart_result && mysqli_num_rows($check_cart_result) > 0) {
                $row = mysqli_fetch_assoc($check_cart_result);
                $current_quantity = $row['quantity'];

                if ($current_quantity > 1) {
                    // Decrease the product quantity by 1
                    $new_quantity = $current_quantity - 1;
                    $update_cart_query = "UPDATE cart SET quantity = '$new_quantity' WHERE cart_id = '$product_id'";
                    mysqli_query($conn, $update_cart_query);
                } else {
                    // Remove the item from the cart if the quantity is 1
                    $remove_cart_query = "DELETE FROM cart WHERE user_id = '$user_id' AND cart_id = '$product_id'";
                    mysqli_query($conn, $remove_cart_query);
                }
            }
        }
    } else {
        // If the user is not logged in, check the product quantity in the session cart
        if (isset($_SESSION['cart'])) {
            // Convert the product_id to an integer for comparison
            $product_id = (int)$product_id;

            foreach ($_SESSION['cart'] as $key => $item) {
                $item_product_id = (int)$item['product_id'];

                if ($item_product_id === $product_id) {
                    $current_quantity = $item['quantity'];

                    if ($current_quantity > 1) {
                        // Decrease the product quantity by 1
                        $_SESSION['cart'][$key]['quantity'] = $current_quantity - 1;
                    } else {
                        // Remove the item from the session cart if the quantity is 1
                        unset($_SESSION['cart'][$key]);
                    }

                    // Exit the loop after finding the item
                    break;
                }
            }
        }
    }

    // Redirect back to the cart.php page
    header("Location: ../cart.php");
    exit(); // Ensure script execution stops after redirection
} else {
    // Product ID not provided.
    echo 'Product ID not provided.';
}
?>
