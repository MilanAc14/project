<?php
require '../components/_dbconnect.php';

// Define the product category you want to retrieve (in this case, category 3)
$productCategory = 2;

// Fetch products with category 3 from the database
$sql = "SELECT * FROM products WHERE product_category = $productCategory";
$result = mysqli_query($conn, $sql);

// Handle Add to Cart and Add to Favorites actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_to_cart"])) {
        $productId = $_POST["product_id"];
        // Handle adding the product to the cart (you should implement your cart logic here).
        // Example session-based cart storage:
        $_SESSION["cart"][$productId] = 1; // Quantity can be adjusted as needed.
    } elseif (isset($_POST["add_to_favorites"])) {
        $productId = $_POST["product_id"];
        // Handle adding the product to favorites (you should implement your favorites logic here).
        // Example session-based favorites storage:
        $_SESSION["favorites"][$productId] = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Category 3</title>
    <link rel="stylesheet" href="../css/footer.css">
    <!-- Link to your custom CSS file -->
    <link rel="stylesheet" href="../css/product.css">
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <!-- Navigation bar -->
    <?php require '../components/_header.php'?>

    <h1 class="tittle mt-4 mb-4">Products - Category 3</h1>
    <div class="con">
        <?php
        if (mysqli_num_rows($result) > 0) {
            $productsPerRow = 3; // Define the number of products per row
            $productCount = 0;

            while ($row = mysqli_fetch_assoc($result)) {
                if ($productCount % $productsPerRow == 0) {
                    // Start a new row
                    echo '<div class="row">';
                }

                echo '<div class="card col-md-4 mb-3" style="max-width: 400px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="../../admin/' . $row['product_image'] . '" alt="' . $row['product_name'] . '" class="img-fluid">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="p_title mt-4">' . $row['product_name'] . '</h5>
                                    <p class="card-text">Category: ' . $row['product_category'] . '</p>
                                    <p class="card-text">Price: ' . $row['product_price'] . ' rupees</p>
                                    <p class="card-text">Description: ' . $row['product_description'] . '</p>
                                    <form method="post">
                                        <input type="hidden" name="product_id" value="' . $row['product_id'] . '">
                                        <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
                                        <button type="submit" name="add_to_favorites" class="btn btn-secondary">Add to Favorites</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>';

                $productCount++;

                if ($productCount % $productsPerRow == 0) {
                    // Close the row
                    echo '</div>';
                }
            }

            // Close the last row if it's not complete
            if ($productCount % $productsPerRow != 0) {
                echo '</div>';
            }
        } else {
            echo '<p>No products found in category 3.</p>';
        }
        ?>
    </div>
    <!-- Footer section -->
    <?php require '../components/_footer.php'?>
    <!-- Bootstrap core JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>
