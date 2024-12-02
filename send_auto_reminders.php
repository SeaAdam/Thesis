<?php
require 'includes/dbconn.php';
require 'autoloader.php'; // Ensure the path to autoload.php is correct

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

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

// Query to fetch reminders that haven't been sent yet and where reminder time has passed
$sql = "SELECT ar.id, ar.client_booking_id, ar.reminder_time, cb.account_id
        FROM appointment_reminders ar
        JOIN client_booking cb ON ar.client_booking_id = cb.id
        WHERE ar.sent = 0 AND ar.reminder_time <= NOW()";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($reminder = $result->fetch_assoc()) {
        // Get client's email address
        $sql = "SELECT email_address FROM clients_info WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $reminder['account_id']);
        $stmt->execute();
        $userResult = $stmt->get_result();
        $user = $userResult->fetch_assoc();
        $userEmail = $user['email_address'];

        if ($userEmail && filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $subject = "Reminder: Appointment Reminder";
            $message = "This is a reminder for your appointment with ID " . $reminder['client_booking_id'];

            // Send email notification
            if (sendEmailNotification($userEmail, $subject, $message)) {
                // Update appointment_reminders table to mark reminder as sent
                $sql = "UPDATE appointment_reminders SET sent = 1 WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $reminder['id']);
                $stmt->execute();
            } else {
                error_log('Failed to send reminder for booking ID ' . $reminder['client_booking_id']);
            }
        } else {
            error_log('Invalid email address for booking ID ' . $reminder['client_booking_id']);
        }
    }
    echo 'Reminders sent successfully';
} else {
    echo 'No reminders to send.';
}

$conn->close();
?>