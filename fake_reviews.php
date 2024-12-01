<?php
// Include the database connection
include 'includes/dbconn.php';

// Fetch reviews from the database
$sql = "SELECT * FROM reviews ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Add SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .star {
            font-size: 1.5em;
            cursor: pointer;
            color: gray;
        }

        .star.selected {
            color: gold;
        }

        .stars {
            display: inline-block;
        }

        .review-item {
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        .review-item h5 {
            font-size: 1.2em;
        }
    </style>
</head>

<body>
    <h2>Submit a Review</h2>

    <!-- Review Form -->
    <form id="reviewForm" method="POST">
        <div>
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="profession">Your Profession:</label>
            <input type="text" id="profession" name="profession" required>
        </div>
        <div>
            <label for="review">Your Review:</label>
            <textarea id="review" name="review" rows="4" required></textarea>
        </div>
        <div>
            <label for="rating">Your Rating:</label>
            <div id="rating-stars">
                <span class="star" data-rating="1">&#9733;</span>
                <span class="star" data-rating="2">&#9733;</span>
                <span class="star" data-rating="3">&#9733;</span>
                <span class="star" data-rating="4">&#9733;</span>
                <span class="star" data-rating="5">&#9733;</span>
            </div>
            <input type="hidden" id="rating" name="rating" value="0">
        </div>
        <button type="submit">Submit Review</button>
    </form>

    <h2>Reviews</h2>
    <div id="reviews-container">
        <?php
        // Display reviews
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
        ?>
    </div>

    <!-- JavaScript for Handling Rating -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // JavaScript to handle star rating selection
        let rating = 0;
        const stars = document.querySelectorAll('.star');

        stars.forEach(star => {
            star.addEventListener('click', function () {
                rating = this.getAttribute('data-rating');
                // Highlight the stars up to the selected rating
                stars.forEach(star => star.style.color = 'gray');
                for (let i = 0; i < rating; i++) {
                    stars[i].style.color = 'gold';
                }
                // Set the hidden rating field value
                document.getElementById('rating').value = rating;
            });
        });

        // AJAX to submit the review without reloading the page
        $('#reviewForm').submit(function (e) {
            e.preventDefault(); // Prevent the form from submitting normally

            $.ajax({
                type: 'POST',
                url: 'submit_review.php',
                data: $(this).serialize(),
                success: function (response) {
                    // Display a SweetAlert success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Review Submitted!',
                        text: 'Thank you for your feedback.',
                        confirmButtonText: 'Close'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // After confirming the success message, reload the page
                            location.reload(); // This will reload the page
                        }
                    });
                },
                error: function () {
                    alert('Something went wrong. Please try again.');
                }
            });
        });
    </script>
</body>

</html>