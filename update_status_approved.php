<?php
include 'includes/dbconn.php';

if (isset($_POST['id']) && isset($_POST['status'])) {
    $transactionId = $_POST['id'];
    $status = $_POST['status'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Update the transaction status and set the current date and time for date_seen
        $sql = "UPDATE appointment_system.transactions 
                SET status = ?, date_seen = NOW() 
                WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $status, $transactionId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Fetch user_id for the notification
            $sql = "SELECT user_id FROM appointment_system.transactions WHERE ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $transactionId);
            $stmt->execute();
            $result = $stmt->get_result();
            $transaction = $result->fetch_assoc();
            $userId = $transaction['user_id'];

            // Insert a notification into the notifications table
            $notificationSql = "INSERT INTO notifications (user_id, transaction_id, status, message, created_at) 
                                VALUES (?, ?, ?, ?, NOW())";
            $notificationStmt = $conn->prepare($notificationSql);
            $message = "Your appointment with ID $transactionId has been $status.";
            $notificationStmt->bind_param('iiss', $userId, $transactionId, $status, $message);
            $notificationStmt->execute();

            if ($status === 'Completed' || $status === 'Rejected') {
                // Fetch the schedule_id and time_slot_id related to this transaction
                $sql = "SELECT schedule_id, time_slot_id FROM appointment_system.transactions WHERE ID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $transactionId);
                $stmt->execute();
                $result = $stmt->get_result();
                $transaction = $result->fetch_assoc();

                if ($transaction) {
                    $scheduleId = $transaction['schedule_id'];

                    // Increment the slots for the corresponding schedule
                    $sql = "UPDATE schedule_record_table 
                            SET Slots = Slots + 1 
                            WHERE ID = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('i', $scheduleId);
                    $stmt->execute();
                }
            }

            $conn->commit();
            echo 'Success';
        } else {
            echo 'No changes made';
        }

        $stmt->close();
        $notificationStmt->close();
    } catch (Exception $e) {
        $conn->rollback();
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'No ID or status provided';
}

$conn->close();


?>