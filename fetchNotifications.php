<?php
include 'notification_functions.php';

$notificationsData = fetchNotifications();
$unread_count = $notificationsData['unread_count'];

header('Content-Type: application/json');
echo json_encode(['unread_count' => $unread_count]);
?>