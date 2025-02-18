<?php
include 'includes/dbconn.php';

if (isset($_GET['date']) && isset($_GET['service_id'])) {
    $dateId = $_GET['date'];
    $serviceId = $_GET['service_id'];

    // Fetch time slots for the selected service that are not already booked
    $sql = "SELECT ts.ID, ts.time_slot
            FROM appointment_system.time_slots ts
            WHERE ts.ID NOT IN (
                SELECT t.time_slot_id
                FROM appointment_system.transactions t
                WHERE t.schedule_id = ? AND t.service_id = ? AND t.status NOT IN ('Rejected', 'Cancelled')
            )";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $dateId, $serviceId);
    $stmt->execute();
    $result = $stmt->get_result();

    $options = "<option value=''>Select a time slot</option>";
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='{$row['ID']}'>{$row['time_slot']}</option>";
    }

    echo $options;
    $stmt->close();
    $conn->close();
}
?>
