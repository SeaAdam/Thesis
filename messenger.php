<?php
require 'autoloader.php'; // Ensure the path to autoload.php is correct

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

// Function to send an email notification
function sendEmailNotification($to, $subject, $message)
{
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'brainmasterdc@gmail.com'; // SMTP username
        $mail->Password = 'xmpu aewf sozv wibb'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom('brainmasterdc@gmail.com', 'Brain Master Diagnostic Center');
        $mail->addAddress($to); // Add a recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        return true;
    } catch (PHPMailerException $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

// Function to send a message to Facebook Messenger
function sendMessengerNotification($psid, $message)
{
    $accessToken = "EAAXKEe3j2YABO37wFBdltbZAE4vDX1R9D0iazzoIjcoOKiXL4M6TjM9saIqgvq4mW3iW3G9QI1P24MXhCrZB17YGG7vepD7Y6uMIIlNgkv6QY5OfmhCPhUAAJoMWshTstcsqrn37Avb6080oHoZAjashmD32VUKMvD800oHGrGqwDZBmDJln7RjHvPJaaXLQq5fwOSLHoQx4rrbM4gZDZD"; // Replace with your Page Access Token

    $messageData = [
        'recipient' => ['id' => $psid],
        'message' => ['text' => $message],
    ];

    $url = "https://graph.facebook.com/v15.0/me/messages?access_token=" . $accessToken;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $responseDecoded = json_decode($response, true);
    if (isset($responseDecoded['error'])) {
        error_log("Facebook Messenger Error: {$responseDecoded['error']['message']}");
        return false;
    }
    return true;
}

// Combined function to send either an email or a Facebook Messenger message
function sendNotification($to, $subject, $message, $channel = 'email', $psid = null)
{
    if ($channel === 'email') {
        return sendEmailNotification($to, $subject, $message);
    } elseif ($channel === 'messenger' && $psid) {
        return sendMessengerNotification($psid, $message);
    } else {
        error_log("Invalid notification channel or missing PSID for Messenger.");
        return false;
    }
}

// Example usage
$to = 'shinearligop@gmail.com'; // Email address to send notification to
$psid = 'USER_PSID'; // Replace with the actual PSID of the recipient
$subject = 'Test Notification';
$message = 'Hello, this is a test notification.';

// Send email
if (sendNotification($to, $subject, $message, 'email')) {
    echo "Email sent successfully!";
} else {
    echo "Failed to send email.";
}

// Send Messenger message
if (sendNotification(null, null, $message, 'messenger', $psid)) {
    echo "Messenger message sent successfully!";
} else {
    echo "Failed to send Messenger message.";
}
