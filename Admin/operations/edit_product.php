<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: /adminlogin/admin_login.php");
    exit;
}

include '../components/_dbconnect.php';

// Check if the product ID is provided in the URL
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Query to retrieve product details based on ID
    $sql = "SELECT * FROM products WHERE product_id = $product_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $product_name = $row['product_name'];
        $product_category = $row['product_category'];
        $product_price = $row['product_price'];
        $product_description = $row['product_description'];
        $product_images = explode(',', $row['product_image']);
    } else {
        // Product not found
        header("location: ../product_list.php");
        exit;
    }
} else {
    // Product ID not provided in the URL
    header("location: ../product_list.php");
    exit;
}

// Handle form submission to update the product
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_product_name = isset($_POST["product_name"]) ? $_POST["product_name"] : "";
    $new_product_category = isset($_POST["product_category"]) ? $_POST["product_category"] : "";
    $new_product_price = $_POST["product_price"];
    $new_product_description = $_POST["product_description"];

    // Update the product details in the database
    $update_sql = "UPDATE products SET 
                   product_name = '$new_product_name',
                   product_category = '$new_product_category',
                   product_price = '$new_product_price',
                   product_description = '$new_product_description'
                   WHERE product_id = $product_id";

    if (mysqli_query($conn, $update_sql)) {
        // Product updated successfully
        $_SESSION['edit_success'] = true; // Set a session variable for success
        header("location: ../product_list.php");
        exit;
    } else {
        // Error updating product
        $error_message = "Error updating the product. Please try again.";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <!-- Navigation bar -->
    <?php require '../components/_header.php' ?>

    <div class="container mt-5">
        <h1 class="display-4">Edit Product</h1>
        <?php if (isset($error_message)) : ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php endif; ?>
        
        <form action="" method="post">
            <div class="mb-3">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name"
                    value="<?= $product_name ?>" required>
            </div>
            <div class="mb-3">
                <label for="product_category" class="form-label">Choose a Product Category</label>
                <select name="product_category" class="form-select" aria-label=".form-select example">
                    <option value="1" <?= ($product_category == 1) ? "selected" : "" ?>>Men</option>
                    <option value="2" <?= ($product_category == 2) ? "selected" : "" ?>>Women</option>
                    <option value="3" <?= ($product_category == 3) ? "selected" : "" ?>>Kids</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="product_price" class="form-label">Product Price</label>
                <input type="text" class="form-control" id="product_price" name="product_price"
                    value="<?= $product_price ?>" required>
            </div>
            <div class="mb-3">
                <label for="product_description" class="form-label">Write a Product Description</label>
                <textarea class="form-control" id="product_description" name="product_description"
                    rows="4"><?= $product_description ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>
