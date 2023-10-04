<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location:adminlogin/admin_login.php");
    exit;
}
require 'components/_dbconnect.php';

// Fetch total sales
$total_sales_query = "SELECT SUM(total_amount) AS total_sales FROM orders";
$total_sales_result = mysqli_query($conn, $total_sales_query);
$total_sales = mysqli_fetch_assoc($total_sales_result)['total_sales'];

// Fetch product sales data
$product_sales_query = "SELECT product_id, SUM(quantity) AS sold_quantity FROM ordered_items GROUP BY product_id";
$product_sales_result = mysqli_query($conn, $product_sales_query);
$product_sales = [];

while ($row = mysqli_fetch_assoc($product_sales_result)) {
    $product_sales[$row['product_id']] = $row['sold_quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <!-- navigation bar -->
    <?php require 'components/_header.php'?>

    <div class="container">
        <div class=" fw-bold fs-1 badge bg-success col-6  rounded-pill ">Dashboard</div>

        <div class=" mt-5 row">
            <div class=" col-md-6">
                <h2>Total Sales</h2>
                <p>Total Sales Amount: <?php echo $total_sales; ?> rupees</p>
            </div>
            <div class="col-md-6">
                <h2>Product Sales</h2>
                <table class="table table-responsive table-bordered">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Sold Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($product_sales as $product_id => $sold_quantity) {
                            // Retrieve product details based on product_id
                            $product_query = "SELECT product_name FROM products WHERE product_id = $product_id";
                            $product_result = mysqli_query($conn, $product_query);
                            $product_name = mysqli_fetch_assoc($product_result)['product_name'];

                            echo "<tr>
                                    <td>$product_name</td>
                                    <td>$sold_quantity</td>
                                </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

  <!-- Bootstrap core javascript-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>
