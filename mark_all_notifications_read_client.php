<?php
include 'notification_functions.php';

markAllAsReadClient();
echo json_encode(['success' => true]);
?>