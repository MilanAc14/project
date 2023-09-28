<?php
session_start();

$showAlert = false;

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: /loginsystem/login.php");
    exit;
}

// Include the database connection
require 'components/_dbconnect.php';

// Handle review submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $review_title = $_POST['review_title'];
    $review_content = $_POST['review_content'];

    // Get the user's ID from the session
    $user_name = $_SESSION['username']; // Assuming you store the user ID in the session

    // Fetch the user's full name from the "user's_info" table
    $sql = "SELECT user_id, full_name FROM `user's_info` WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_name);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $user_info = $result->fetch_assoc();
            $full_name = $user_info['full_name'];
            $user_id = $user_info['user_id'];
            // Insert the review into the database
            $sql = "INSERT INTO reviews (user_id, full_name, review_title, review_content, submission_date) VALUES (?, ?, ?, ?, NOW())";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isss", $user_id, $full_name, $review_title, $review_content);

            if ($stmt->execute()) {
                $showAlert = true;
                // Redirect to prevent form resubmission on page refresh
                header("location: reviews.php");
                exit;
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "User not found.";
            exit;
        }
    } else {
        echo "Statement execution failed: " . $stmt->error;
        exit;
    }
}

// Fetch existing reviews from the database
$reviews = array();

$sql = "SELECT * FROM reviews ORDER BY submission_date DESC"; // Modify this query according to your database schema
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reviews</title>
    <!-- css file  -->
    <link rel="stylesheet" href="css/footer.css">
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
                <strong>Review Posted Successfully!!</strong> 
                </div> 
                <button type="button" class="btn-close " data-bs-dismiss="alert"  aria-label="Close"></button>
                </div> ';
        }
        ?>
    <!-- Display Existing Reviews -->
    <div class="container mt-5">
        <h2>Existing Reviews</h2>
        <ul class="list-group">
            <?php foreach ($reviews as $review): ?>
                <li class="list-group-item">
                    <h4><?php echo $review['review_title']; ?></h4>
                    <p><?php echo $review['review_content']; ?></p>
                    <small>Posted by: <?php echo $review['full_name']; ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Review Form -->
    <div class="container mt-5">
        <h2>Write a Review</h2>
       
        <form action="reviews.php" method="POST">
            <div class="form-group">
                <label for="review_title">Review Title:</label>
                <input type="text" class="form-control" id="review_title" name="review_title" required>
            </div>
            <div class="form-group">
                <label for="review_content">Review Content:</label>
                <textarea class="form-control" id="review_content" name="review_content" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>
    </div>

    <!-- footer section -->
    <?php require 'components/_footer.php'; ?>

    <!-- Bootstrap core JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>
