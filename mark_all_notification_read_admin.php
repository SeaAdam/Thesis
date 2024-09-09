<?php
include 'notification_functions.php';

markAllAsReadAdmin();
echo json_encode(['success' => true]);
?>