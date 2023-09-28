<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: /adminlogin/admin_login.php");
    exit;
}
$showAlert=false;
// Include the database connection
require 'components/_dbconnect.php';

// Check if deletion was successful
if (isset($_SESSION['deletion_success']) && $_SESSION['deletion_success'] === true) {
    $showAlert=true;
    // Unset the session variable to prevent the message from showing on page refresh
    unset($_SESSION['deletion_success']);
}

// Fetch review details from the database
$sql = "SELECT * FROM `reviews`";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews Info</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <!-- navigation bar -->
    <?php require 'components/_header.php';
    if($showAlert){
        echo ' <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
               <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                   <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
               </symbol>
               </svg>
               <div class="alert alert-success d-flex align-items-center" role="alert">
                   <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
               <div>
               <strong>Review deleted Successfully !!</strong> 
               <button type="button" class="btn-close b" data-bs-dismiss="alert"  aria-label="Close"></button>
               </div> ';
           }
    ?>

    <div class="container">
        <table class="table table-light table-bordered">
            <thead>
                <tr>
                    <th scope="col">Review ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Content</th>
                    <th scope="col">User</th>
                    <th scope="col">Submission Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- use loop to iterate review details from the database -->
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row['review_title'] . "</td>";
                        echo "<td>" . $row['review_content'] . "</td>";
                        echo "<td>" . $row['full_name'] . "</td>";
                        echo "<td>" . $row['submission_date'] . "</td>";
                        echo "<td><a href='operations/review_delete.php?user_id=" . $row['user_id'] . "' class='btn btn-danger'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No review data found.</td></tr>";
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
