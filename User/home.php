
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>home page</title>
    <!-- css file  -->
    <style>
    .carousel-inner img {
        max-width: 100vw;
        max-height: 100vh;
        display: block;
        margin: 0 auto;
        overflow: hidden;
    }
    </style>
    <link rel="stylesheet" href="css/footer.css">
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <!-- navigation bar -->
    <?php require 'components/_header.php'?>
    <!-- database connection  -->
    <?php include 'components/_dbconnect.php'?>
    <!-- crousel starts here -->
    <div id="slider" class="carousel carousel-dark slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#slider" data-bs-slide-to="0" class="active" aria-current="true"
                aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#slider" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#slider" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="10000">
                <img src="photos/uplash.avif" class="d-block w-100" alt="shoes1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>First slide label</h5>
                    <p>Some representative placeholder content for the first slide.</p>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="2000">
                <img src="photos/slider 1.avif" class="d-block w-100" alt="shoes2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Some representative placeholder content for the second slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="photos/slider 3.avif" class="d-block w-100" alt="shoes3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Third slide label</h5>
                    <p>Some representative placeholder content for the third slide.</p>
                </div>
            </div>
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
    <!-- categories we offer-->
    <!-- Fetch all the categories and use a loop to iterate through categories -->
    <?php 
         $sql = "SELECT * FROM `categories`"; 
         $result = mysqli_query($conn, $sql);
         while($row = mysqli_fetch_assoc($result)){
          $category_id = $row['categories_id'];
          $category_name = $row['categories_name'];
          $category_description = $row['categories_description'];
          echo '<div class="col-md-4 my-2">
                  <div class="card" style="width: 18rem;">
                      <img src="https://source.unsplash.com/random/900×700/?' .$category_name. ',shoes" class="card-img-top" alt="image for this category">
                      <div class="card-body">
                          <h5 class="card-title"><a href="#">' . $category_name . '</a></h5>
                          <p class="card-text">' . substr($category_description, 0, 90). '... </p>
                          <a href="#" class="btn btn-primary">SHOP NOW</a>
                      </div>
                  </div>
                </div>';
         } 
         ?>




    <!-- footer section  -->
    <?php require 'components/_footer.php'?>
    <!-- Bootstrap core javascript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>






</body>

</html>