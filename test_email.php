<?php
session_start();
include 'includes/dbconn.php';
include 'notification_functions.php';

// Debugging: Output the session data to verify contents
echo '<pre>' . print_r($_SESSION, true) . '</pre>';

// Check if userID is set in the session
if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];

    // Prepare query to fetch email based on userID
    $query = "SELECT email FROM user_2fa WHERE userID = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $userID); // Bind the userID parameter

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $userEmail = $row['email']; // Fetch the email

                // Prepare email details
                $testSubject = 'Test Email';
                $testMessage = 'This is a test email from PHPMailer.';

                // Call the function and check if the email was sent successfully
                if (sendEmailNotification($userEmail, $testSubject, $testMessage)) {
                    echo 'Test email sent successfully.';
                } else {
                    echo 'Failed to send test email.';
                }
            } else {
                echo 'No email found for user ID.';
            }
        } else {
            echo 'Error executing query.';
        }
        $stmt->close();
    } else {
        echo 'Error preparing the query.';
    }
} else {
    echo 'User ID not found in session.';
}

$conn->close();
?>
