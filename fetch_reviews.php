<?php
// Include the database connection
include 'includes/dbconn.php';

// Fetch reviews from the database
$sql = "SELECT * FROM reviews ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Loop through reviews and display them
    while ($row = $result->fetch_assoc()) {
        $rating = $row['rating'];
        echo '<div class="review-item">';
        echo '<h5>' . $row['name'] . ' - ' . $row['profession'] . '</h5>';
        echo '<p>' . $row['review'] . '</p>';
        echo '<div class="stars">';
        
        // Display stars based on rating
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                echo '<span class="star">&#9733;</span>';
            } else {
                echo '<span class="star">&#9734;</span>';
            }
        }
        echo '</div>';
        echo '</div>';
    }
} else {
    echo 'No reviews yet.';
}

$conn->close();
?>
