<?php
include 'notification_functions.php';

if (isset($_GET['transaction_no'])) {
    markNotificationAsReadAdmin($_GET['transaction_no']);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>