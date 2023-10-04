<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location:adminlogin/admin_login.php");
    exit;
}
include 'components/_dbconnect.php';

$showAlert = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $product_name = isset($_POST["product_name"]) ? $_POST["product_name"] : "";
    $product_category = isset($_POST["product_category"]) ? $_POST["product_category"] : "";

    // Handling uploaded image files
    $image_paths = [];
    if (!empty($_FILES["produt_image"]["name"][0])) {
        $target_dir = "uploads/"; // Create this directory to store uploaded images
        foreach ($_FILES["produt_image"]["tmp_name"] as $key => $tmp_name) {
            $file_name = basename($_FILES["produt_image"]["name"][$key]);
            $target_path = $target_dir . $file_name;
            move_uploaded_file($tmp_name, $target_path);
            $image_paths[] = $target_path;
        }
    }
    $product_price = $_POST["product_price"];
    $available_size = $_POST["product_size"];
    $product_description = $_POST["product_description"];

    $sql = "INSERT INTO products (product_name, product_category, product_image, product_price, product_size, product_description) 
            VALUES ('$product_name', '$product_category', '" . implode(",", $image_paths) . "', '$product_price', '$available_size', '$product_description')";
    
    if (mysqli_query($conn, $sql)) {
        $showAlert = true;
    } else {
        $showError = "Unable to upload your product";
    }

    mysqli_close($conn);

    // After successful data insertion, redirect to the product list page
    header("location: product_list.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>products</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <!-- navigation bar -->
    <?php require 'components/_header.php'?>
    <!-- Place this success message container at the top of your home.php file -->
<div id="success-message-container" class="container mt-3"></div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        <?php
        if (isset($_SESSION['success_message'])) {
            echo 'showAlert("Success!", "' . $_SESSION['success_message'] . '", "success");';
            unset($_SESSION['success_message']); // Clear the success message after displaying it
        }
        ?>

        // Function to display an alert message at the top
        function showAlert(title, message, type) {
            const successMessageContainer = document.getElementById("success-message-container");

            const alertDiv = document.createElement("div");
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.innerHTML = `
                <strong>${title}</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;

            // Prepend the alert to the success message container
            successMessageContainer.insertBefore(alertDiv, successMessageContainer.firstChild);

            // Automatically remove the alert after 5 seconds (adjust the delay as needed)
            setTimeout(function() {
                alertDiv.remove();
            }, 5000);
        }
    });
</script>


    <?php
    if ($showAlert) {
        echo ' <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </symbol>
                </svg>
                <div class="alert alert-success d-flex align-items-center" role="alert">
                 <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"></use></svg>
                <div>
                <strong>Success!</strong> Your product is uploaded successfully!!
                </div> 
                <button type="button" class="btn-close b" data-bs-dismiss="alert"  aria-label="Close"></button>
                </div> ';
    }

   
    ?>
    <h1 class="display-2">Upload  Product</h1>
    <div class="container">
        <form action="" name="product" method="post" class="mt-2" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name"
                    placeholder="enter a name of a product" autofocus>
            </div>
            <div class="mb-3">
                <label for="produt_category" class="form-label"> Choose a Product category</label>
                <select name="product_category" class="form-select form-select mb-3" aria-label=".form-select example">
                    <option value="1" selected>Men</option>
                    <option value="2">Women</option>
                    <option value="3">Kids</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="produt_image" class="form-label"> Upload a product image</label>
                <input type="file" class="form-control" id="image" name="produt_image[]" multiple accept="image/*,video/*">
            </div>
            <div class="mb-3">
                <label for="product_price" class="form-label">Product Price</label>
                <input type="text" class="form-control" id="product_price" name="product_price"
                    placeholder="enter a price in rupees" autofocus>
            </div>
            <div class="mb-3">
                <label for="available size" class="form-label"> Available Sizes</label>
                <input type="text" class="form-control" id="product_size" name="product_size" autofocus>
            </div>
            <div class="mb-3">
                <label for="produt_Description" class="form-label"> write a product description</label>
                <textarea rows="4" cols="76" class="form-control" name="product_description"></textarea>
            </div>

            <button type="submit" name="submit" class="btn btn-primary my-3">Submit</button>
        </form>

    </div>
    <h1 class="display-2">Add Categories and Slider Images</h1>
    <div class="container">
        <form action="process_categories_slider.php" name="categories_slider" method="post" class="mt-2" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="category_name" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter category name" autofocus required>
            </div>
            <div class="mb-3">
                <label for="category_description" class="form-label">Category Description</label>
                <textarea rows="4" cols="76" class="form-control" id="category_description" name="category_description" placeholder="Enter category description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="slider_image" class="form-label">Slider Image</label>
                <input type="file" class="form-control" id="slider_image" name="slider_image" accept="image/*">
            </div>
            <button type="submit" name="submit" class="btn btn-primary my-3">Submit</button>
        </form>
    </div>
    

      <!-- Bootstrap core javascript-->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>
