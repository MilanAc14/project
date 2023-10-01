<?php
$showAlert = false;
$showError = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){

    include '../components/_dbconnect.php';

    $fullname = $_POST["fullName"];
    $email = $_POST["email"];
    $username=$_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["Cpassword"];
    

    // Check whether this e-mail exists
    $existSql = "SELECT * FROM `users_info` WHERE email = '$email'";
    $result = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($result);
    if($numExistRows > 0){
        
        $showError = "e-mail already exist";
    }
    else{
       
        if(($password == $cpassword)){
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users_info` ( `full_name`, `email`,`username`, `password`, `date`) VALUES ( '$fullname' , '$email' ,'$username', '$hash' ,current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if ($result){
                $showAlert = true;
            }
        }
        else{
            $showError = "Passwords do not match";
        }
    }
}
    
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>sign up</title>
    <!-- css link -->
    <link rel="stylesheet" href="../css/login.css" />
     <!-- css file  -->
     <link rel="stylesheet" href="../css/footer.css">

    <!-- google font link -->
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Roboto+Condensed:wght@300;400&family=Roboto+Serif:opsz,wght@8..144,100;8..144,400&family=Smokum&display=swap');
    </style>
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <?php require '../components/_header.php'?>


    <?php
    
         if($showAlert){
          echo ' <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </symbol>
                </svg>
                <div class="alert alert-success d-flex align-items-center" role="alert">
                 <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div>
                <strong>Success!</strong> Your account is now created and you can login
                </div> 
                <button type="button" class="btn-close " data-bs-dismiss="alert"  aria-label="Close"></button>
                </div> ';
        }
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


<!-- registeration form starts here -->
    <div class="l_con mt-2">
        <form action="" name="signUp" method="post" class="mt-2">
            <h1 class="f_title">register</h1>
            <p>please fill in the information below</p>
            <div class="fg" id="name-group">
                <input class="in" type="text" name="fullName" placeholder="Full Name " autofocus required />

                <span class="message"> </span>
            </div>

            <div class="fg" id="email-group">
                <input class="in" type="email" name="email" placeholder="Email" autofocus required />
                <div id="emailHelp" class="form-text fs-6 text-start">We'll never share your email with anyone else.
                </div>
                <span class="message"> </span>
            </div>
            <div class="fg" id="username-group">
                <input class="in" type="text" name="username" placeholder="Username" autofocus required />
                <span class="message"> </span>
            </div>

            <div class="fg" id="password-group">
                <input class="in" type="password" name="password" placeholder="Password" required />
                <span class="message"></span>
            </div>
            <div class="fg" id="confirmPassword-group">
                <input class="in" type="password" name="Cpassword" placeholder="Confirm Password" required />
                <div id="emailHelp" class="form-text fs-6 text-start">Make sure to type same password</div>
                <span class="message"></span>
            </div>

            <button class="button mt-4" id="submit1" name="login">Create My Account</button>
            <div>
                <p class="mt-3">
                    Already have an account? <a href="login.php" class="link">Login</a>
                </p>
            </div>
        </form>
    </div>

  <!-- footer section  -->
    <?php require '../components/_footer.php'?>

    <!-- Bootstrap core javascript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>