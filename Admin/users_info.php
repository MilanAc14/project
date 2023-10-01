<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: adminlogin/admin_login.php");
    exit;
}
// database connection
include 'components/_dbconnect.php';
// Check if deletion was successful
if (isset($_SESSION['deletion_success']) && $_SESSION['deletion_success'] === true) {
    echo' <script>
    alert("User deleted successfully!");
    </script>';
                          
    // Unset the session variable to prevent the message from showing on page refresh
    unset($_SESSION['deletion_success']);
}

// Fetch user details from the database
$sql = "SELECT * FROM `users_info`";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uers's INFO</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <!-- navigation bar -->
    <?php require 'components/_header.php'?>


        <div class="container">
        <table class="table table-light table-bordered">
            <thead>
                <tr>
                    <th scope="col">User's ID</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Username</th>
                    <th scope="col">Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- use loop to iterate user's detail from database -->
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row['full_name'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "<td><a href='operations/userinfo_delete.php?user_id=" . $row['user_id'] . "' class='btn btn-danger'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No user data found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    


    <!-- Bootstrap core javascript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>