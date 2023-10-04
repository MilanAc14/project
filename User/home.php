<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Page</title>
    <link rel="stylesheet" href="css/footer.css">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <!-- Navigation bar -->
    <?php require 'components/_header.php'?>

    <!-- Include database connection -->
    <?php include 'components/_dbconnect.php'?>

    <!-- Carousel starts here -->
   
    <div id="slider" class=" mb-3 carousel carousel-dark slide">
        <div class="carousel-indicators">
            <?php
            // Retrieve data from the "categories" table
            $sql = "SELECT * FROM categories";
            $result = mysqli_query($conn, $sql);
            $slideIndex = 0;

            // indicators for each slide
            while ($row = mysqli_fetch_assoc($result)) {
                $isActive = $slideIndex === 0 ? 'active' : '';
                echo '<button type="button" data-bs-target="#slider" data-bs-slide-to="' . $slideIndex . '" class="' . $isActive . '" aria-current="true" aria-label="Slide ' . ($slideIndex + 1) . '"></button>';
                $slideIndex++;
            }
            ?>
        </div>
        <div class="carousel-inner">
            <?php
            //  result pointer and slide index
            mysqli_data_seek($result, 0);
            $slideIndex = 0;

            //  carousel items with data from the database
            while ($row = mysqli_fetch_assoc($result)) {
                $isActive = $slideIndex === 0 ? 'active' : '';
                echo '<div class="carousel-item ' . $isActive . '" data-bs-interval="10000">';
                echo '<img src="../admin/' . $row['slider_image'] . '" class="d-block w-100" alt="' . $row['category_name'] . '" style="max-height: 500px; width: auto;">';
                echo '<div class="carousel-caption d-none d-md-block">';
                echo '<h5>' . $row['category_name'] . '</h5>';
                echo '<p>' . $row['category_description'] . '</p>';
                
                // "Shop Now" button for each category
                $categoryLink = "categories/" . strtolower($row['category_name']) . ".php";
                echo '<a href="' . $categoryLink . '" class="btn btn-primary">Shop Now</a>';
                
                echo '</div>';
                echo '</div>';
                $slideIndex++;
            }
            ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#slider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#slider" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
   

        <!-- Footer section -->
        <?php require 'components/_footer.php'?>

    <!-- Bootstrap core JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>
