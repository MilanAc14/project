<?php
session_start();
require '../components/_dbconnect.php';

// Define the product category you want to retrieve (in this case, category 1 for mens)
$productCategory = 1;

// Fetch products with category 1 (mens) from the database
$sql = "SELECT * FROM products WHERE product_category = $productCategory";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Mens Section</title>
    <!-- Link to your custom CSS file -->
    <link rel="stylesheet" href="../css/product.css">
    <!-- Google Fonts link -->
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Roboto+Condensed:wght@300;400&family=Roboto+Serif:opsz,wght@8..144,100;8..144,400&family=Smokum&display=swap" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <!-- Navigation bar -->
    <?php require '../components/_header.php'?>

    <div class="con mt-4">
        <h1 class="tittle mb-4">Men Section</h1>
        <div class="box">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class=" box-inside">
                            <div class="card mb-5 picture">
                                <img src="../../admin/' . $row['product_image'] . '" alt="' . $row['product_name'] . '" class="card-img-top" style="height:300px;">
                                <div class="card-body">
                                    <h5 class="p_title">' . $row['product_name'] . '</h5>
                                    <p class="card-text">Price: ' . $row['product_price'] . ' rupees</p>
                                    <p class="card-text">Available sizes: ' . $row['product_size'] . ' </p>
                                   
                                    <p class="product-description">Description:' . $row['product_description'] . '</p>
                                    <div class="d-flex">
                                    <form method="post" action="../cart.php">
                                    <input type="hidden" name="product_id" value=" '.$row['product_id'].'">
                                    <label for="size">Select Size:</label>
                                    <select name="size" id="size">
                                        <option value="35">35</option>
                                        <option value="36">36</option>
                                        <option value="37">37</option>
                                        <option value="38">38</option>
                                        <option value="39">39</option>
                                        <option value="40">40</option>
                                        <option value="41">41</option>
                                        <option value="42">42</option>
                                        <option value="43">43</option>
                                    </select>
                                    <button type="submit" name="add_to_cart" class="btn btn-primary me-3">Add to Cart</button>
                                </form>
                                    <form method="post" action="../operations/add_to_favorite.php">
                                    <input type="hidden" name="product_id" value="' . $row['product_id'] . '">
                                    <button type="submit" name="add_to_favorites" class="btn btn-secondary">Add to Favorites</button>
                                </form>
                                </div>
                                </div>
                            </div>
                        </div>';
                }
            } else {
                echo '<div class="col-md-12">
                        <p class="alert alert-info">No products found in category 3.</p>
                    </div>';
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
        </div>
    </div>
   <!-- Footer section -->
   <?php require '../components/_footer.php'?>
    <!-- Bootstrap core JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>
<form method="post" action="../cart.php">
    <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
    <label for="size">Select Size:</label>
    <select name="size" id="size">
        <option value="Small">Small</option>
        <option value="Medium">Medium</option>
        <option value="Large">Large</option>
    </select>
    <button type="submit" name="add_to_cart" class="btn btn-primary me-3">Add to Cart</button>
</form>
