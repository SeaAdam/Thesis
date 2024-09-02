<?php
include 'includes/dbconn.php';

if (isset($_POST['notification_id'])) {
    $notificationId = $_POST['notification_id'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Update read_status to 1 (read)
        $sql = "UPDATE notifications SET read_status = 1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $notificationId);
        $stmt->execute();

        $conn->commit();
        echo 'Success';
    } catch (Exception $e) {
        $conn->rollback();
        echo 'Error: ' . $e->getMessage();
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'No notification ID provided';
}
