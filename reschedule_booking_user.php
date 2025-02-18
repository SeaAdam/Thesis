<?php
include 'includes/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transactionId = $_POST['transaction_id'];
    $newDate = $_POST['newDate'];
    $newTimeSlot = $_POST['newTimeSlot'];

    $sql = "UPDATE appointment_system.transactions 
            SET schedule_id = ?, time_slot_id = ?, status = 'Pending' 
            WHERE ID = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $newDate, $newTimeSlot, $transactionId);

    if ($stmt->execute()) {
        echo "Appointment rescheduled successfully!";
    } else {
        echo "Error: Unable to reschedule appointment.";
    }

    $stmt->close();
    $conn->close();
}
?>
