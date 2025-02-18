<?php
include 'includes/dbconn.php';

// Fetch future schedules
$sql = "SELECT ID, Slots_Date FROM appointment_system.schedule_record_table WHERE Slots_Date >= CURDATE()";
$result = $conn->query($sql);

$options = "<option value=''>Select a date</option>";
while ($row = $result->fetch_assoc()) {
    $options .= "<option value='{$row['ID']}'>{$row['Slots_Date']}</option>";
}

echo $options;
$conn->close();
?>
