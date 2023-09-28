<?php
// by default setting login and error false
$login = false;
$showError = false;
//checking if the method is post 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //if method is post connect to database
    include '../components/_dbconnect.php';

    $username = $_POST["user_name"];
    $password = $_POST["password"];

    //query to fetch user data 
    $sql = "Select * from `admin_info` where user_name='$username'";
    $result = mysqli_query($conn, $sql);
    //checking number of rows of the username although it will be one if exists otherwise 0 as no duplicate entry is alowed and username is set unique

    $num = mysqli_num_rows($result);
    if ($num == 1){
        //if email exist fetch data and verify password and start the session 
        while($row=mysqli_fetch_assoc($result)){
            if (password_verify($password, $row['password'])){ 
                $login = true;
                session_start();
        
                $_SESSION['loggedin'] =true;
                $_SESSION['user_name'] = $username;
            
                header("location:/Admin/home.php");
            } 
          
            else{
                $showError = "Invalid password ";
            }
        }
        
    } 
    else{
        $showError = "Invalid username ";
    }
}
    
?>

<!DOCTYPE html>
<html lang="en">

   <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
   </head>

   <body>
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
    <div class="container">
        <h1 class="display-2">Login</h1>
        <form action="" name="login" method="post" class="mt-2">
            <div class="mb-3">
                <label for="user_name" class="form-label">UserName</label>
                <input type="text" class="form-control" id="user_name" name="user_name">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <div>
                <p class="mt-3">
                    Don't have an account yet? <a href="admin_signup.php" class="form-label">Create one</a>
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