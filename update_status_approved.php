<?php
include 'includes/dbconn.php';

if (isset($_POST['id']) && isset($_POST['status'])) {
    $transactionId = $_POST['id'];
    $status = $_POST['status'];

    // Update the transaction status and set the current date and time for date_seen
    $sql = "UPDATE appointment_system.transactions 
            SET status = ?, date_seen = NOW() 
            WHERE ID = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $status, $transactionId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo 'Success';
    } else {
        echo 'No changes made';
    }

    $stmt->close();
} else {
    echo 'No ID or status provided';
}

$conn->close();
?>
