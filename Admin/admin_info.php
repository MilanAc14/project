<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: /adminlogin/admin_login.php");
    exit;
}

include 'components/_dbconnect.php';

// Check if deletion was successful
if (isset($_SESSION['deletion_success']) && $_SESSION['deletion_success'] === true) {
    echo ' <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </symbol>
                    </svg>
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                    <div>
                    <strong> Deletion Successful !! </strong> 
                    </div> 
                    <button type="button" class="btn-close b" data-bs-dismiss="alert"  aria-label="Close"></button>
                    </div> ';
                
                
    // Unset the session variable to prevent the message from showing on page refresh
    unset($_SESSION['deletion_success']);
}
// fetch admin data query 
$sql = "SELECT * FROM admin_info";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin INFO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <?php require 'components/_header.php'?>

    <div class="container">
        <table class="table table-light table-bordered">
            <thead>
                <tr>
                    <th scope="col">Admin ID</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['admin_id'] . "</td>";
                        echo "<td>" . $row['full_name'] . "</td>";
                        echo "<td>" . $row['user_name'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['timestamp'] . "</td>";
                        echo "<td><a href='operations/admin_delete.php?admin_id=" . $row['admin_id'] . "' class='btn btn-danger'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No admin data found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>
