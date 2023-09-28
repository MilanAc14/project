<?php 
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
  $loggedin= true;
}
else{
  $loggedin = false;
}

// navigation bar starts here

echo'<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="./user/home.php">shoes</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        category
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="./categories/mens.php">mens</a></li>
                        <li><a class="dropdown-item" href="#">womens</a></li>

                        <li><a class="dropdown-item" href="#">kids</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reviews.php">Reviews</a>
                </li>

            </ul>
            <form class="d-flex" role="search">
                <input class="form-control me-3" type="search" placeholder="Search items" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>';

            if(!$loggedin){
                //display login and sigup button if user is not logged in 

           echo' <ul class="navbar-nav me-3 ms-3">
                <li class="nav-item  navbar-nav me-3 ms-3">
                    <a class="nav-link" href="/project/loginsystem/login.php">login</a>
                </li>
                <li class="nav-item navbar-nav me-3 ms-3">
                    <a class="nav-link" href="/project/loginsystem/signup.php">signup</a>
                </li>';
            }
            if($loggedin){
                //display the name of user if logged in 
                echo $_SESSION['username'];
                echo ' <li class="nav-item navbar-nav me-3 ms-3">
                    <a class="nav-link" href="/project/loginsystem/logout.php">logout</a>
                </li>';
                };
                echo'<li class="nav-item navbar-nav me-3 ms-3">
                    <a class="nav-link" href="#">Cart</a>
                </li>
            </ul>

        </div>
    </div>
</nav>';
?>