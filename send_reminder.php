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

if (isset($_GET['id'])) {
    $reminderId = $_GET['id'];

    // Fetch reminder and associated client details
    $sql = "SELECT ar.client_booking_id, cb.account_id, ar.reminder_time
            FROM appointment_reminders ar
            JOIN client_booking cb ON ar.client_booking_id = cb.id
            WHERE ar.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $reminderId);
    $stmt->execute();
    $result = $stmt->get_result();
    $reminder = $result->fetch_assoc();

    if ($reminder) {
        // Check if the reminder_time has passed
        $currentTime = date('Y-m-d H:i:s');
        if ($reminder['reminder_time'] <= $currentTime) {
            // Get client's email address
            $sql = "SELECT email_address FROM clients_info WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $reminder['account_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $userEmail = $user['email_address'];

            if ($userEmail && filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
                $subject = "Reminder: Appointment Reminder";
                $message = "This is a reminder for your appointment with ID " . $reminder['client_booking_id'];

                // Send email notification
                if (sendEmailNotification($userEmail, $subject, $message)) {
                    // Update appointment_reminders table to mark reminder as sent
                    $sql = "UPDATE appointment_reminders SET sent = 1 WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('i', $reminderId);
                    $stmt->execute();

                    // Show SweetAlert to inform the admin
                    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
                    echo '<script>
                            Swal.fire({
                                title: "Reminder Sent",
                                text: "The reminder has been sent successfully!",
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then(function() {
                                window.location.href = "reminders.php"; // Redirect to the appropriate page
                            });
                          </script>';
                } else {
                    echo 'Failed to send reminder';
                }
            } else {
                echo 'Invalid email address';
            }
        } else {
            echo 'Reminder time has not yet passed';
        }
    } else {
        echo 'Reminder not found';
    }
}

$conn->close();
?>
