<?php
include 'notification_functions.php';

if (isset($_GET['transaction_id'])) {
    markNotificationAsReadClient($_GET['transaction_id']);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>