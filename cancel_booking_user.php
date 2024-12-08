<?php
include 'includes/dbconn.php';

if (isset($_POST['transaction_id'])) {
    $transactionId = $_POST['transaction_id'];

    // Start a transaction to ensure consistency
    $conn->begin_transaction();

    // Fetch the schedule_id for the transaction
    $sql = "SELECT service_id, time_slot_id FROM appointment_system.transactions WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $transactionId);
    $stmt->execute();
    $result = $stmt->get_result();
    $transaction = $result->fetch_assoc();

    if ($transaction) {
        $serviceType = $transaction['service_id'];
        $timeSlotId = $transaction['time_slot_id']; 

        // Reset the time slot availability to '0' (booked)
        $sql = "UPDATE appointment_system.time_slots
          SET isBooked = 0
          WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $timeSlotId);
        $stmt->execute();

        // Increment the slots for the corresponding schedule
        $sql = "UPDATE appointment_system.services_table
                SET slots_count = slots_count + 1 
                WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $serviceType);
        $stmt->execute();

        // Update the status of the transaction to 'Cancelled'
        $sql = "UPDATE appointment_system.transactions 
                SET status = 'Cancelled' 
                WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $transactionId);
        $stmt->execute();

        $conn->commit();
        echo 'Success';
    } else {
        echo 'Transaction not found';
    }
} else {
    echo 'No transaction ID provided';
}

$conn->close();
?>