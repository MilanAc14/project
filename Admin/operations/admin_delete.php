
<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: /adminlogin/admin_login.php");
    exit;
}

include '../components/_dbconnect.php';

if (isset($_GET['admin_id'])) {
    $admin_id = $_GET['admin_id'];

    // You should add validation and security checks here to prevent SQL injection

    $sql = "DELETE FROM `admin_info` WHERE admin_id = '$admin_id'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['deletion_success'] = true;
        header("location: ../admin_info.php");
        exit;
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "Admin ID not provided.";
}
?>
