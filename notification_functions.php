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

// function fetchNotifications() {
//     include 'includes/dbconn.php';

//     $sql = "SELECT transaction_id, status, created_at FROM notifications ORDER BY created_at DESC LIMIT 10";
//     $result = $conn->query($sql);

//     $notifications = [];
//     while ($row = $result->fetch_assoc()) {
//         $notifications[] = $row;
//     }

//     $conn->close();
//     return $notifications;
// }
function fetchNotifications()
{
    include 'includes/dbconn.php';

    // Fetch unread notifications
    $sql = "SELECT id, transaction_id, status, created_at FROM notifications 
            WHERE read_status = 0 
            ORDER BY created_at DESC 
            LIMIT 10";
    $result = $conn->query($sql);

    $notifications = [];
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }

    // Fetch count of unread notifications
    $countSql = "SELECT COUNT(*) as unread_count FROM notifications WHERE read_status = 0";
    $countResult = $conn->query($countSql);
    $countRow = $countResult->fetch_assoc();
    $unreadCount = $countRow['unread_count'];

    $conn->close();
    return ['notifications' => $notifications, 'unread_count' => $unreadCount];
}


?>