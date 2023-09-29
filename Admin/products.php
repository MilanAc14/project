<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: /adminlogin/admin_login.php");
    exit;
}
include 'components/_dbconnect.php';
// Check if a delete success message session variable is set
$deleteSuccessMessage = "";
if (isset($_SESSION['delete_success']) && $_SESSION['delete_success'] === true) {
    $deleteSuccessMessage = ' <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
    </symbol>
    </svg>
    <div class="alert alert-success d-flex align-items-center" role="alert">
     <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"></use></svg>
    <div>
    <strong>Success!</strong> Your product is deleted successfully!!
    </div> 
    <button type="button" class="btn-close b" data-bs-dismiss="alert"  aria-label="Close"></button>
    </div> ';
    unset($_SESSION['delete_success']); // Unset the session variable to clear the message
}

        // Check if an edit success message session variable is set
        $editSuccessMessage = "";
        if (isset($_SESSION['edit_success']) && $_SESSION['edit_success'] === true) {
            $editSuccessMessage = ' <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
              <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </symbol>
            </svg>
            <div class="alert alert-success d-flex align-items-center" role="alert">
             <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"></use></svg>
            <div>
            <strong>Success!</strong> Your product is edited successfully!!
            </div> 
            <button type="button" class="btn-close b" data-bs-dismiss="alert"  aria-label="Close"></button>
            </div> ';
            unset($_SESSION['edit_success']); // Unset the session variable to clear the message
        }
       

$showAlert=false;
    // Check if the form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    
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
        $product_description = $_POST["product_description"];
        
        // Insert the form values into the database
        $sql= "INSERT INTO products (product_name, product_category, product_image, product_price, product_description) 
                         VALUES ('$product_name', '$product_category', '" . implode(",", $image_paths) . "', '$product_price', '$product_description')";
         $result = mysqli_query($conn, $sql);
         if (mysqli_affected_rows($conn) > 0) {
            $showAlert = true;
        }
    else{
        $showError = "unable to upload your product";
    }
        
        // Close the database connection
        mysqli_close($conn);
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

    <?php
    
         if($showAlert){
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

        // Display the delete success message if set 
         echo $deleteSuccessMessage;
         echo $editSuccessMessage;
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
                <select name="product_category"> class="form-select form-select mb-3" aria-label=".form-select example" 
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
                <label for="produt_Description" class="form-label"> write a product description</label>
                <textarea rows="4" cols="76" class="form-control" name="product_description" ></textarea>
                </div>

            <button type="submit" class="btn btn-primary my-3">Submit</button>
        </form>
    </div>
<?php
 include 'components/_dbconnect.php';

    // Query to retrieve products data
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
?>


    <div class="container mt-5">
        <h1 class="display-4">Products List</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Images</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?= $row['product_id'] ?></td>
                        <td><?= $row['product_name'] ?></td>
                        <td><?= $row['product_category'] ?></td>
                        <td><?= $row['product_price'] ?></td>
                        <td><?= $row['product_description'] ?></td>
                        <td>
                            <?php
                            $image_paths = explode(',', $row['product_image']);
                            foreach ($image_paths as $image_path) {
                                echo '<img src="' . $image_path . '" alt="Product Image" width="100">';
                            }
                            ?>
                        </td>
                        <td>
                            <a href="operations/edit_product.php?product_id=<?= $row['product_id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="operations/delete_product.php?product_id=<?= $row['product_id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <!-- Bootstrap core javascript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>
</html>