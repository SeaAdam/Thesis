<?php
include 'notification_functions.php';

markAllAsRead();
echo json_encode(['success' => true]);
?>