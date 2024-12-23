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

function fetchNotificationsAdmin()
{
    include 'includes/dbconn.php';

    // Fetch notifications for the specific user, unread first
    $sql = "SELECT transaction_no, message, created_at, status FROM admin_notification ORDER BY status ASC, created_at DESC LIMIT 10";
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

function fetchNotificationsClient($clientID)
{
    include 'includes/dbconn.php';

    // Fetch notifications for the specific user, unread first
    $sql = "SELECT transaction_id, status, created_at, read_status FROM client_notification WHERE client_id = ? ORDER BY read_status ASC, created_at DESC LIMIT 10";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $clientID);
    $stmt->execute();
    $result = $stmt->get_result();

    $notificationsClient= [];
    while ($row = $result->fetch_assoc()) {
        $notificationsClient[] = $row;
    }

    $stmt->close();
    $conn->close();
    return $notificationsClient;
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

function countUnreadNotificationsAdmin()
{
    include 'includes/dbconn.php';

    $sql = "SELECT COUNT(*) AS unread_count FROM admin_notification WHERE status = 0";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $unread_count = $row['unread_count'];

    $stmt->close();
    $conn->close();
    return $unread_count;
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

function countUnreadNotificationsClient($clientID)
{
    include 'includes/dbconn.php';

    $sql = "SELECT COUNT(*) AS unread_count FROM client_notification WHERE client_id = ? AND read_status = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $clientID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $unread_count = $row['unread_count'];

    $stmt->close();
    $conn->close();
    return $unread_count;
}

function markNotificationAsReadAdmin($transaction_no)
{
    include 'includes/dbconn.php';

    $sql = "UPDATE admin_notification SET status = 1 WHERE transaction_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $transaction_no);
    $stmt->execute();

    $stmt->close();
    $conn->close();
}

function markAllAsReadAdmin()
{
    include 'includes/dbconn.php';

    $sql = "UPDATE admin_notification SET status = 1";
    $conn->query($sql);

    $conn->close();
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

function markNotificationAsReadClient($clientBookingID)
{
    include 'includes/dbconn.php';

    $sql = "UPDATE client_notification SET read_status = 1 WHERE transaction_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $clientBookingID);
    $stmt->execute();

    $stmt->close();
    $conn->close();
}

function markAllAsReadClient()
{
    include 'includes/dbconn.php';

    $sql = "UPDATE client_notification SET read_status = 1";
    $conn->query($sql);

    $conn->close();
}
?>