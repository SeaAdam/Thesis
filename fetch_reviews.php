<?php

include 'includes/dbconn.php';


$sql = "SELECT * FROM reviews ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        $rating = $row['rating'];
        echo '<div class="review-item">';
        echo '<h5>' . $row['name'] . ' - ' . $row['profession'] . '</h5>';
        echo '<p>' . $row['review'] . '</p>';
        echo '<div class="stars">';
        

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
