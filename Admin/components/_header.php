<?php 
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
  $loggedin= true;
}
else{
  $loggedin = false;
}

//  navigation bar 
        echo'<nav class="navbar navbar-expand-lg bg-body-tertiary">
          <div class="container-fluid">
            <a class="navbar-brand" href="home.php">Admin  Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="dashboard.php">dashboard</a>
                </li>
                  <li class="nav-item">
                  <a class="nav-link" href="products.php">Products</a>
                </li>
                  <li class="nav-item">
                  <a class="nav-link" href="admin_info.php">admin</a>
                </li>
                  <li class="nav-item">
                  <a class="nav-link" href="users_info.php">Users INFO</a>
                </li>
                  <li class="nav-item">
                  <a class="nav-link" href="reviews_info.php">Reviews</a>
                </li>
              </ul>
              <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class=" me-2 btn btn-outline-success" type="submit">Search</button>
              </form>';
  
            if($loggedin){
              //display the name of admin username if logged in 
              echo $_SESSION['user_name'];
              echo ' <li class="nav-item navbar-nav me-3 ms-3">
                  <a class="nav-link" href="adminlogin/admin_logout.php">logout</a>
              </li>';
              };
              echo'
          </ul>

      </div>
  </div>
</nav>';
        ?>