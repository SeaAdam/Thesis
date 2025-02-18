<?php
include 'includes/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transactionId = $_POST['transaction_id'];
    $newDate = $_POST['newDate'];

    // Start a transaction to ensure data consistency
    $conn->begin_transaction();

    // Fetch the current time_slot_id and service_id for the transaction
    $sql = "SELECT time_slot_id, service_id FROM appointment_system.transactions WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $transactionId);
    $stmt->execute();
    $result = $stmt->get_result();
    $transaction = $result->fetch_assoc();

    if ($transaction) {
        $oldTimeSlotId = $transaction['time_slot_id'];
        $serviceType = $transaction['service_id'];

        if ($oldTimeSlotId != 0) {
            // Reset the previous time slot's availability
            $sql = "UPDATE appointment_system.time_slots SET isBooked = 0 WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $oldTimeSlotId);
            $stmt->execute();
        }

        // Increment the slots count for the corresponding service
        $sql = "UPDATE appointment_system.services_table
                SET slots_count = slots_count + 1 
                WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $serviceType);
        $stmt->execute();

        // Update the transaction: Set new schedule, reset time_slot_id to 0, and change status
        $sql = "UPDATE appointment_system.transactions 
                SET schedule_id = ?, time_slot_id = 0, status = 'Rescheduled' 
                WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $newDate, $transactionId);
        $stmt->execute();

        $conn->commit();
        echo "Appointment rescheduled successfully!";
    } else {
        echo "Error: Transaction not found.";
    }

    $stmt->close();
    $conn->close();
}
?>