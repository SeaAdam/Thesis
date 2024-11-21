<?php
include 'includes/dbconn.php';

if (isset($_POST['transaction_id'])) {
    $transaction_id = $_POST['transaction_id'];

    // Update the status of the transaction to 'Cancelled'
    $sql = "UPDATE appointment_system.transactions SET status = 'Cancelled' WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $transaction_id);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'error';
}
?>