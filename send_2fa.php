<?php
session_start();
include 'includes/dbconn.php'; // Ensure dbconn.php includes proper error handling for connection failures
include 'notification_functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize user input
    $userEmail = trim($_POST['userEmail']);

    // Validate email format
    if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    // Generate and store a 2FA code
    $twofaCode = rand(100000, 999999); // Generate a 6-digit code
    $_SESSION['twofaCode'] = (string)$twofaCode; // Store as string
    $_SESSION['email'] = $userEmail;

    // Check if user ID is set in session
    if (isset($_SESSION['user_id'])) {
        $userID = $_SESSION['user_id'];

        // Check if there is already an entry for this user
        $checkQuery = "SELECT * FROM user_2fa WHERE userID = ?";
        if ($checkStmt = $conn->prepare($checkQuery)) {
            $checkStmt->bind_param("i", $userID);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows > 0) {
                // Update existing entry
                $query = "UPDATE user_2fa SET email = ? WHERE userID = ?";
                if ($stmt = $conn->prepare($query)) {
                    $stmt->bind_param("si", $userEmail, $userID);
                }
            } else {
                // Insert new entry
                $query = "INSERT INTO user_2fa (userID, email) VALUES (?, ?)";
                if ($stmt = $conn->prepare($query)) {
                    $stmt->bind_param("is", $userID, $userEmail);
                }
            }

            if ($stmt->execute()) {
                // Log success message
                error_log("Successfully " . ($checkResult->num_rows > 0 ? "updated" : "inserted") . " email for userID $userID in the database.");

                // Prepare email details
                $subject = 'Your 2FA Code';
                $message = 'Your 2FA code is: <strong>' . $twofaCode . '</strong>';

                // Send the 2FA code via email
                if (sendEmailNotification($userEmail, $subject, $message)) {
                    // Redirect to enter email page
                    header("Location: enter_email.php");
                    exit();
                } else {
                    // Log error if email sending fails
                    error_log("Failed to send email to $userEmail.");
                    echo "Message could not be sent. Please try again.";
                }
            } else {
                // Log MySQL error
                error_log("Failed to " . ($checkResult->num_rows > 0 ? "update" : "insert") . " email into the database: " . $stmt->error);
                echo "Failed to save email in the database.";
            }

            $stmt->close();
            $checkStmt->close();
        } else {
            // Log error if query preparation fails
            error_log("Failed to prepare the check database statement: " . $conn->error);
            echo "Failed to prepare the database statement.";
        }
    } else {
        echo "User ID not found in session.";
    }
    
    $conn->close();
}



?>