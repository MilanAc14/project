<?php
session_start();

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: adminlogin/admin_login.php");
    exit;
}

include 'components/_dbconnect.php';

$showAlert = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $category_name = isset($_POST["category_name"]) ? $_POST["category_name"] : "";
    $category_description = isset($_POST["category_description"]) ? $_POST["category_description"] : "";

    // Handling uploaded slider image
    if (!empty($_FILES["slider_image"]["name"])) {
        $target_dir = "uploads/slider/"; // Specify the directory where slider images should be stored
        $file_name = basename($_FILES["slider_image"]["name"]);
        $target_path = $target_dir . $file_name;
        move_uploaded_file($_FILES["slider_image"]["tmp_name"], $target_path);
    } else {
        // Handle the case where no image was uploaded (you may want to display an error message)
    }

    // Prepare and execute the SQL query using prepared statements
    $sql = "INSERT INTO categories (`category_name`, `category_description`, `slider_image`, `time`) 
            VALUES (?, ?, ?, current_timestamp())";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sss", $category_name, $category_description, $target_path);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success_message'] = "Successfully added slider image.";
        } else {
            $showError = "Unable to add the category and slider image.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $showError = "SQL statement preparation failed.";
    }

    mysqli_close($conn);

    // After successful data insertion, redirect to the homepage or wherever needed
    header("location: home.php"); // Replace with the actual homepage URL
    exit;
}
?>
