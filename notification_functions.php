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
        $mail->Username = 'adamerodagat@gmail.com'; // SMTP username
        $mail->Password = 'gnxh erjw yxfo jtdr'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom('adamerodagat@gmail.com', 'adameroemailer');
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

function updateBookingStatus($transaction_id, $status, $user_id)
{
    include 'includes/dbconn.php';

    $update_sql = "UPDATE transactions SET status = ? WHERE ID = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param('si', $status, $transaction_id);
    $update_stmt->execute();

    $notification_sql = "INSERT INTO notifications (transaction_id, status, user_id) VALUES (?, ?, ?)";
    $notification_stmt = $conn->prepare($notification_sql);
    $notification_stmt->bind_param('isi', $transaction_id, $status, $user_id);
    $notification_stmt->execute();

    $update_stmt->close();
    $notification_stmt->close();
    $conn->close();
}

function fetchNotificationsAdmin() //THIS IS WHERE I LEFT
{
    include 'includes/dbconn.php';

    // Fetch notifications for the specific user, unread first
    $sql = "SELECT transaction_no, message, created_at FROM admin_notification";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $notificationsAdmin = [];
    while ($row = $result->fetch_assoc()) {
        $notificationsAdmin[] = $row;
    }

    $stmt->close();
    $conn->close();
    return $notificationsAdmin;
}

function fetchNotifications($user_id)
{
    include 'includes/dbconn.php';

    // Fetch notifications for the specific user, unread first
    $sql = "SELECT transaction_id, status, created_at, read_status FROM notifications WHERE user_id = ? ORDER BY read_status ASC, created_at DESC LIMIT 10";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $notifications = [];
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }

    $stmt->close();
    $conn->close();
    return $notifications;
}


function countUnreadNotifications($user_id)
{
    include 'includes/dbconn.php';

    $sql = "SELECT COUNT(*) AS unread_count FROM notifications WHERE user_id = ? AND read_status = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $unread_count = $row['unread_count'];

    $stmt->close();
    $conn->close();
    return $unread_count;
}

function markNotificationAsRead($transaction_id)
{
    include 'includes/dbconn.php';

    $sql = "UPDATE notifications SET read_status = 1 WHERE transaction_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $transaction_id);
    $stmt->execute();

    $stmt->close();
    $conn->close();
}

function markAllAsRead()
{
    include 'includes/dbconn.php';

    $sql = "UPDATE notifications SET read_status = 1";
    $conn->query($sql);

    $conn->close();
}
?>