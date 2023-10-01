<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: adminlogin/admin_login.php");
    exit;
}

// Include the database connection
require 'components/_dbconnect.php';

// Check if deletion was successful
if (isset($_SESSION['deletion_success']) && $_SESSION['deletion_success'] === true) {
   echo' <script>
    alert("Review deleted successfully!");
    </script>';
    
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
    <?php require 'components/_header.php';?>

    <div class="container">
        <table class="table table-light table-bordered">
            <thead>
                <tr>
                    <th scope="col">Review ID</th>
                    <th scope="col">Content</th>
                    <th scope="col">User Name </th>
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
                        echo "<td>" . $row['review_id'] . "</td>";
                        echo "<td>" . $row['review_content'] . "</td>";
                        echo "<td>" . $row['full_name'] . "</td>";
                        echo "<td>" . $row['submission_date'] . "</td>";
                        echo "<td><a href='operations/review_delete.php?review_id=" . $row['review_id'] . "' class='btn btn-danger'>Delete</a></td>";
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
