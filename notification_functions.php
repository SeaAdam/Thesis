<?php

function updateBookingStatus($transaction_id, $status)
{
    include 'includes/dbconn.php';

    $update_sql = "UPDATE transactions SET status = ? WHERE ID = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param('si', $status, $transaction_id);
    $update_stmt->execute();

    $notification_sql = "INSERT INTO notifications (transaction_id, status) VALUES (?, ?)";
    $notification_stmt = $conn->prepare($notification_sql);
    $notification_stmt->bind_param('is', $transaction_id, $status);
    $notification_stmt->execute();

    $update_stmt->close();
    $notification_stmt->close();
    $conn->close();
}


function fetchNotifications() {
    include 'includes/dbconn.php';

    // Fetch all notifications, unread first
    $sql = "SELECT transaction_id, status, created_at, read_status FROM notifications ORDER BY read_status ASC, created_at DESC LIMIT 10";
    $result = $conn->query($sql);

    $notifications = [];
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }

    $conn->close();
    return $notifications;
}


function countUnreadNotifications()
{
    include 'includes/dbconn.php';

    $sql = "SELECT COUNT(*) AS unread_count FROM notifications WHERE read_status = 0";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $unread_count = $row['unread_count'];

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