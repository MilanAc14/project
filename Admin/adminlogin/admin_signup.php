<?php

$showError = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){

    require '../components/_dbconnect.php';

    $fullname = $_POST["full_name"];
    $email = $_POST["email"];
    $username = $_POST["user_name"];
    $password = $_POST["password"];
    $cpassword = $_POST["confirm_password"];
    

    // Check whether this e-mail exists
    $existSql = "SELECT * FROM `admin_info` WHERE user_name = '$username'";
    $result = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($result);
    if($numExistRows > 0){
        
        $showError = "username already exist";
    }
    else{
       
        if(($password == $cpassword)){
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `admin_info` (`full_name`, `email`, `user_name`, `password`, `timestamp`) VALUES ('$fullname', '$email', '$username', '$hash', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo '<script>
                        var showAlert = true;
                        setTimeout(function(){
                            if (showAlert) {
                                alert("Registration successful!");
                                showAlert = false;
                                window.location.href = "admin_login.php";
                            }
                        }, 3000); // 3000 milliseconds = 3 seconds
                      </script>';
            }
        }
        else{
            $showError = "Passwords do not match";
        }
    }
    // Close the database connection here
mysqli_close($conn);
}
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signup</title>
      <!-- css  -->
      <link rel="stylesheet" href="../css/login.css" />
    <link rel="stylesheet" href="../css/util.css" />

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body class="bg-dark">
    <?php
    
     if($showError){
                echo '<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </symbol>
                </svg>
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>
                <strong>Error!</strong> '. $showError.'
                </div>
                <button type="button" class="btn-close "  data-bs-dismiss="alert"  aria-label="Close"></button>
            </div> ';
             }
    ?>
    <!-- login form  -->
    <div class="mt-5 l_con my-5">
        <h1 class=" mt-2 mb-2 f_title">Signup</h1>
        <form action="" name="signUp" method="post" class="mt-2">
            <div class="mb-3 text-start fw-bold">
                <label for="full_name" class="text-uppercase form-label">full Name</label>
                <input type="text" class="in" id="full_name" name="full_name" placeholder="Full Name">
            </div>
            <div class="mb-3 text-start fw-bold">
                <label for="email" class="text-uppercase form-label">E-mail</label>
                <input type="email" class="in" id="email" name="email"placeholder="Email">
            </div>
            <div class="mb-3 text-start fw-bold">
                <label for="user_name" class="text-uppercase form-label">UserName</label>
                <input type="text" class="in" id="user_name" name="user_name" placeholder="Username">
            </div>
            <div class="mb-3 text-start fw-bold">
                <label for="password" class=" text-uppercase form-label">Password</label>
                <input type="password" class="in" id="password" name="password" placeholder="Password">
            </div>
            <div class="mb-3 text-start fw-bold">
                <label for="confirm_password" class="text-uppercase form-label"> Confirm Password</label>
                <input type="password" class="in" id="confirm_password" name="confirm_password" placeholder="Confirm password">
            </div>
            <button type="submit" class="button button-primary">Submit</button>
            <div>
                <p class="mt-3">
                    Already have an account? <a href="admin_login.php" class="link">Login</a>
                </p>
            </div>
        </form>
    </div>

    <!-- Bootstrap core javascript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>