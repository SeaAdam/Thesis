<?php
include 'includes/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transactionId = $_POST['transaction_id'];
    $newDate = $_POST['newDate'];

    // Update the status to "Rescheduled" and change the schedule_id (new date)
    $sql = "UPDATE appointment_system.transactions 
            SET schedule_id = ?, status = 'Rescheduled' 
            WHERE ID = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $newDate, $transactionId);

    if ($stmt->execute()) {
        echo "Appointment rescheduled successfully!";
    } else {
        echo "Error: Unable to reschedule appointment.";
    }

    $stmt->close();
    $conn->close();
}
?>
