<?php


$loggedin = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true;
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$user_id= isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';


echo '<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php">shoes</a>
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
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Category
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="categories/mens.php">Mens</a></li>
                        <li><a class="dropdown-item" href="categories/womens.php">Womens</a></li>
                        <li><a class="dropdown-item" href="categories/kids.php">Kids</a></li>
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

if (!$loggedin) {
    echo '<ul class="navbar-nav me-3 ms-3">
                <li class="nav-item navbar-nav me-3 ms-3">
                    <a class="nav-link" href="loginsystem/login.php">Login</a>
                </li>
                <li class="nav-item navbar-nav me-3 ms-3">
                    <a class="nav-link" href="loginsystem/signup.php">Signup</a>
                </li>
            </ul>';
} else {
    echo '<ul class="navbar-nav me-3 ms-3">
                <li class="nav-item navbar-nav me-3 ms-3">
                    <span class="nav-link">Welcome, ' . $username . '</span>
                </li>
                <li class="nav-item navbar-nav me-3 ms-3">
                    <a class="nav-link" href="loginsystem/logout.php">Logout</a>
                </li>
            </ul>';
}

echo ' <li class="nav-item navbar-nav me-3 ms-3">
            <a class="nav-link" href="favorites.php">favourites</a>
        </li>
        <li class="nav-item navbar-nav me-3 ms-3">
                    <a class="nav-link" href="cart.php">Cart</a>
                </li>
            </ul>
        </div>
    </div>
</nav>';
?>
