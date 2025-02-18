<?php
include 'includes/dbconn.php';

if (isset($_GET['date']) && isset($_GET['service_id'])) {
    $scheduleId = $_GET['date'];  // Schedule ID (selected date)
    $serviceId = $_GET['service_id'];  // Selected service ID

    // Fetch available time slots for the selected service and schedule (date)
    $sql = "SELECT ts.ID, ts.time_slot
            FROM appointment_system.time_slots ts
            WHERE ts.schedule_id = ? 
            AND ts.service_id = ? 
            AND ts.isBooked = 0";  // Only fetch available (not booked) time slots

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $scheduleId, $serviceId);
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
