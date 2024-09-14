<?php
session_start();
include 'includes/dbconn.php';

if (isset($_POST['id']) && isset($_POST['status'])) {
    $clientBookingID = $_POST['id'];
    $status = $_POST['status'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Update the transaction status and set the current date and time for date_seen
        $sql = "UPDATE appointment_system.client_booking
                SET status = ?, date_seen = NOW() 
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $status, $clientBookingID);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            
            $sql = "SELECT account_id FROM appointment_system.client_booking WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $clientBookingID);
            $stmt->execute();
            $result = $stmt->get_result();
            $transaction = $result->fetch_assoc();
            $clientID = $transaction['account_id'];

            // THIS IS WHERE I LEFT GET NOTIFICATION IN CLIENTDASHBOARD !!
            $notificationSql = "INSERT INTO client_notification (client_id, transaction_id, status, message, created_at) 
                                VALUES (?, ?, ?, ?, NOW())";
            $notificationStmt = $conn->prepare($notificationSql);
            $message = "Your appointment with ID $clientBookingID has been $status.";
            $notificationStmt->bind_param('iiss', $clientID, $clientBookingID, $status, $message);
            $notificationStmt->execute();

            $conn->commit();
            echo 'Success';
        } else {
            echo 'No changes made';
        }

        $stmt->close();
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