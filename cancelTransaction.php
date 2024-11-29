<?php
// Include database connection
require_once 'includes/dbconn.php'; // Replace with your actual DB connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get transaction ID from POST request
    $transactionId = $_POST['transaction_id'] ?? null;

    if ($transactionId) {
        // Check if the transaction exists and its status is 'Pending'
        $sqlCheck = "SELECT status FROM client_booking WHERE id = ?";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bind_param('i', $transactionId);
        $stmtCheck->execute();
        $stmtCheck->bind_result($status);
        $stmtCheck->fetch();
        $stmtCheck->close();

        if ($status === 'Pending') {
            // Update the status to 'Canceled'
            $sqlUpdate = "UPDATE client_booking SET status = 'Rejected' WHERE id = ?";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            $stmtUpdate->bind_param('i', $transactionId);

            if ($stmtUpdate->execute()) {
                echo 'success'; // Indicate success to the AJAX call
            } else {
                echo 'error'; // Indicate failure to the AJAX call
            }
            $stmtUpdate->close();
        } else {
            echo 'not_pending'; // Transaction is not pending
        }
    } else {
        echo 'invalid_request'; // No transaction ID provided
    }
} else {
    echo 'invalid_method'; // Invalid request method
}

$conn->close();
?>