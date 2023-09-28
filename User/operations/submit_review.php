<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: /loginsystem/login.php");
    exit;
}

// Include the database connection
require '../components/_dbconnect.php';

// Get data from the review form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id']; // User ID
    $full_name = $_POST['full_name']; // User's full name
    $review_title = $_POST['review_title']; // Review title
    $review_content = $_POST['review_content']; // Review content

    // Insert the review into the database
    $sql = "INSERT INTO reviews (user_id, full_name, review_title, review_content, submission_date) VALUES (?, ?, ?, ?, NOW())";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $user_id, $full_name, $review_title, $review_content);
    
    if ($stmt->execute()) {
        // Review successfully submitted
        
        header("location: ../reviews.php"); // Redirect to the reviews page
        exit;
    } else {
        // Error handling if the review submission fails
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

$conn->close(); // Close the database connection
?>
