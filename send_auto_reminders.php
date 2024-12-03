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

function logToDatabase($message, $conn)
{
    $sql = "INSERT INTO booking_logs (message) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $message);
    $stmt->execute();
    $stmt->close();
}

// Query to fetch appointment reminders for client-specific reminders that haven't been sent yet and where reminder time has passed
$sql = "SELECT ar.id, ar.client_booking_id, ar.reminder_time, cb.account_id
        FROM appointment_reminders ar
        JOIN client_booking cb ON ar.client_booking_id = cb.id
        WHERE ar.sent = 0 AND ar.reminder_time <= NOW()";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($reminder = $result->fetch_assoc()) {
        // Get client's email address for appointment reminders
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

            // Send email notification for appointment reminder
            if (sendEmailNotification($userEmail, $subject, $message)) {
                // Update appointment_reminders table to mark reminder as sent
                $sql = "UPDATE appointment_reminders SET sent = 1 WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $reminder['id']);
                $stmt->execute();

                // Log success
                logToDatabase("Successfully sent reminder for booking ID " . $reminder['client_booking_id'], $conn);
            } else {
                // Log failure
                logToDatabase("Failed to send reminder for booking ID " . $reminder['client_booking_id'], $conn);
            }
        } else {
            // Log invalid email for appointment reminder
            logToDatabase("Invalid email address for booking ID " . $reminder['client_booking_id'], $conn);
        }
    }
    echo 'Appointment reminders sent successfully';
} else {
    echo 'No appointment reminders to send.';
}

// Now handle user-specific reminders (the section for user reminders using the user_2fa table)
$sql = "SELECT id, user_id, reminder_time 
        FROM user_appointment_reminders 
        WHERE sent = 0 AND reminder_time <= NOW()";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($reminder = $result->fetch_assoc()) {
        // Get user's email address for user-specific reminders
        $sql = "SELECT email FROM user_2fa WHERE userID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $reminder['user_id']);  // Use 'user_id' from the reminder table
        $stmt->execute();
        $userResult = $stmt->get_result();
        $user = $userResult->fetch_assoc();
        $userEmail = $user['email'];

        if ($userEmail && filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $subject = "Reminder: Your Upcoming Appointment";
            $message = "This is a reminder for your upcoming appointment with ID " . $reminder['id'];

            // Send email notification for user reminder
            if (sendEmailNotification($userEmail, $subject, $message)) {
                // Update user_appointment_reminders table to mark reminder as sent
                $sql = "UPDATE user_appointment_reminders SET sent = 1 WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $reminder['id']);
                $stmt->execute();

                // Log success
                logToDatabase("Successfully sent user reminder for appointment ID " . $reminder['id'], $conn);
            } else {
                // Log failure
                logToDatabase("Failed to send user reminder for appointment ID " . $reminder['id'], $conn);
            }
        } else {
            // Log invalid email for user reminder
            logToDatabase("Invalid email address for user reminder for appointment ID " . $reminder['id'], $conn);
        }
    }
    echo 'User reminders sent successfully';
} else {
    echo 'No user reminders to send.';
}

$conn->close();
?>