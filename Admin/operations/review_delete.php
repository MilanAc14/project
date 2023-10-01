<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: /adminlogin/admin_login.php");
    exit;
}

// Include the database connection
require '../components/_dbconnect.php';

if (isset($_GET['review_id'])) {
    $review_id = $_GET['review_id'];

    // Delete the review from the database
    $sql = "DELETE FROM reviews WHERE review_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $review_id);

    if ($stmt->execute()) {
        // Set a session variable to indicate successful deletion
        $_SESSION['deletion_success'] = true;
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Close the database connection
$conn->close();

// Redirect back to the reviews info page
header("location: ../reviews_info.php");
exit;
?>
