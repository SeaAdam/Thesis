<?php
// Include the database connection
include 'includes/dbconn.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['name'];
    $profession = $_POST['profession'];
    $review = $_POST['review'];
    $rating = $_POST['rating'];

    // Validate data (simple example, add more validation as needed)
    if (!empty($name) && !empty($profession) && !empty($review) && !empty($rating)) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO reviews (name, profession, review, rating, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssi", $name, $profession, $review, $rating);

        // Execute query
        if ($stmt->execute()) {
            echo 'Review submitted successfully';
        } else {
            echo 'Error: ' . $conn->error;
        }
    } else {
        echo 'All fields are required!';
    }
    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
