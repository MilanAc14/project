<?php
session_start();
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



// Query to retrieve products data
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>   
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>product List </title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
    <?php require 'components/_header.php'; 
     // Display the delete success message if set 
     echo $deleteSuccessMessage;
     echo $editSuccessMessage;
    ?>

    <h1 class="display-4">Products List</h1>
    <table class="table me-5 ms-3 table-bordered">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Available Sizes</th>
                <th>Description</th>
                <th>Images</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td style="width: 5px;"><?= $row['product_id'] ?></td>
                    <td><?= $row['product_name'] ?></td>
                    <td style="width: 5px;"><?= $row['product_category'] ?></td>
                    <td><?= $row['product_price'] ?></td>
                    <td style="width: 15px;"><?= $row['product_size'] ?></td>
                    <td style="width:250px ;"><?= $row['product_description'] ?></td>
                    <td style="width:200px ;">
                    <?php
                            $image_paths = explode(',', $row['product_image']);
                            foreach ($image_paths as $image_path) {
                                echo '<img src="' . $image_path . '" alt="Product Image" width="300px">';
                            }
                            ?>
                    </td>
                    <td style="width: 150px;">
                        <!-- Add edit and delete buttons with appropriate links -->
                        <a href="operations/edit_product.php?product_id=<?= $row['product_id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                        <a href="operations/delete_product.php?product_id=<?= $row['product_id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <!-- Bootstrap core javascript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>
</body>
</html>
