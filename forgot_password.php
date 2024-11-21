<?php
session_start();
include 'includes/dbconn.php';
include 'notification_functions.php'; // Include your notification function

$response = array('status' => '', 'message' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);

    // Retrieve the user's email from user_2fa database
    $query = "
        SELECT u2fa.email 
        FROM user_2fa u2fa
        INNER JOIN registration_table rt ON u2fa.userID = rt.ID
        WHERE rt.Username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'];

        // Generate a unique token
        $token = bin2hex(random_bytes(32));
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Save the token to the password_resets table
        $insertQuery = "INSERT INTO password_resets (email, token, expiry) VALUES (?, ?, ?)
                        ON DUPLICATE KEY UPDATE token = VALUES(token), expiry = VALUES(expiry)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sss", $email, $token, $expiry);
        $stmt->execute();

        // Create the reset link
        $resetLink = "http://localhost/thesis/reset_password.php?token=" . $token;

        // Prepare the email content
        $subject = "Password Reset Request";
        $message = "
            <html>
            <head>
                <title>Password Reset</title>
            </head>
            <body>
                <p>Hello,</p>
                <p>You requested to reset your password. Click the link below to reset it:</p>
                <a href='$resetLink'>Reset Password</a>
                <p>This link will expire in 1 hour.</p>
            </body>
            </html>
        ";

        // Call the sendEmailNotification function to send the email
        if (sendEmailNotification($email, $subject, $message)) {
            $response['status'] = 'success';
            $response['message'] = 'A password reset link has been sent to your email.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to send reset email. Please try again.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Username not found or no 2FA email associated.';
    }

    $stmt->close();
    $conn->close();
    echo json_encode($response);
    exit();
}
?>
