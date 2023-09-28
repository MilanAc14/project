<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: /adminlogin/admin_login.php");
    exit;
}

include '../components/_dbconnect.php';

// Define the product category you want to retrieve (in this case, category 3)
$productCategory = 1;

// Fetch products with category 3 from the database
$sql = "SELECT * FROM products WHERE product_category = $productCategory";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Category 3</title>
    <link rel="stylesheet" href="../css/footer.css">
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <!-- Navigation bar -->
    <?php require '../components/_header.php'?>

    <h1 class="display-2">Products - Category 3</h1>
    <div class="container">
        <?php
        // Check if there are products in category 3
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Display product information
                echo '<div class="card mb-3" style="max-width: 400px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="project/Admin/'. $row['product_image'] . '" alt="' . $row['product_name'] . '" class="img-fluid">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">' . $row['product_name'] . '</h5>
                                    <p class="card-text">Category: ' . $row['product_category'] . '</p>
                                    <p class="card-text">Price: ' . $row['product_price'] . ' rupees</p>
                                    <p class="card-text">Description: ' . $row['product_description'] . '</p>
                                </div>
                            </div>
                        </div>
                    </div>';
            }
        } else {
            echo '<p>No products found in category 3.</p>';
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
    </div>
   <!-- footer section  -->
   <?php require '../components/_footer.php'?>
    <!-- Bootstrap core javascript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>
