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