<?php
session_start();
require 'components/_dbconnect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: loginsystem/login.php"); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch favorite products for the logged-in user
$sql = "SELECT p.* FROM products as p
        INNER JOIN favorites as f ON p.product_id = f.product_id
        WHERE f.user_id = $user_id";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorite Products</title>
    <!-- Link to your custom CSS file -->
    
     <link rel="stylesheet" href="css/product.css">
    <link rel="stylesheet" href="../css/product.css">
    <link rel="stylesheet" href="css/footer.css">
    <!-- Google Fonts link -->
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Roboto+Condensed:wght@300;400&family=Roboto+Serif:opsz,wght@8..144,100;8..144,400&family=Smokum&display=swap" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <!-- Navigation bar -->
    <?php require 'components/_header.php'?>

    <div class="con mt-4">
        <h1 class="tittle mb-4">Favorite Products</h1>
        <div class="box">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class=" box-inside">
                            <div class="card mb-5 picture">
                                <img src="../admin/' . $row['product_image'] . '" alt="' . $row['product_name'] . '" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="p_title">' . $row['product_name'] . '</h5>
                                    <p class="card-text">Price: ' . $row['product_price'] . ' rupees</p>
                                    <p class="product-description">Description:' . $row['product_description'] . '</p>
                                    <div class="d-flex">
                                    <form method="post" action="cart.php">
                                        <input type="hidden" name="product_id" value="' . $row['product_id'] . '">
                                        <button type="submit" name="add_to_cart" class="btn btn-primary me-3">Add to Cart</button>
                                    </form>
                                    
                                    <form method="post" action="operations/remove_favorite.php">
                                    <input type="hidden" name="product_id" value="' . $row['product_id'] . '">
                                    <button type="submit" name="remove_favorites" class="btn btn-danger">Remove from Favorites</button>
                                </form>
                                </div>
                                </div>
                            </div>
                        </div>';
                }
            } else {
                echo '<div class="col-md-12">
                        <p class="alert alert-info">No favorite products found for your account.</p>
                    </div>';
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
        </div>
    </div>

    <!-- Footer section -->
    <?php require 'components/_footer.php'?>

    <!-- Bootstrap core JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>
