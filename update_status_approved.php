<?php
session_start();
include 'includes/dbconn.php';
include 'notification_functions.php';

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

            // Fetch the email from user_2fa table
            $sql = "SELECT email FROM user_2fa WHERE userID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $userEmail = $user['email'];

            if (!$userEmail || !filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email address.");
            }

            // Insert a notification into the notifications table
            $notificationSql = "INSERT INTO notifications (user_id, transaction_id, status, message, created_at) 
                                VALUES (?, ?, ?, ?, NOW())";
            $notificationStmt = $conn->prepare($notificationSql);
            $message = "Your appointment with ID $transactionId has been $status.";
            $notificationStmt->bind_param('iiss', $userId, $transactionId, $status, $message);
            $notificationStmt->execute();

            // Send email notification
            $emailSubject = "Appointment Status Updated";
            $emailMessage = "Your appointment with ID $transactionId has been $status.";
            if (sendEmailNotification($userEmail, $emailSubject, $emailMessage)) {
                error_log("Email sent successfully to $userEmail");
            } else {
                error_log("Failed to send email notification to $userEmail");
                throw new Exception("Error sending email notification.");
            }

            if ($status === 'Completed' || $status === 'Rejected') {
                
                $sql = "SELECT schedule_id FROM appointment_system.transactions WHERE ID = ?";
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
        error_log("Exception: " . $e->getMessage());
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'No ID or status provided';
}

$conn->close();

?>