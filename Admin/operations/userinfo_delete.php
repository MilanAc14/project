
<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: /adminlogin/admin_login.php");
    exit;
}

include '../components/_dbconnect.php';

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // You should add validation and security checks here to prevent SQL injection

    $sql = "DELETE FROM `users_info` WHERE user_id = '$user_id'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['deletion_success'] = true;
        header("location: ../users_info.php");
        exit;
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo " User ID not provided.";
}
?>
