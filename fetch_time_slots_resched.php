<?php
include 'includes/dbconn.php';

if (isset($_GET['date'])) {
    $dateId = $_GET['date'];

    $sql = "SELECT ID, time_slot FROM appointment_system.time_slots WHERE ID NOT IN (
                SELECT time_slot_id FROM appointment_system.transactions WHERE schedule_id = ? AND status NOT IN ('Rejected', 'Cancelled')
            )";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $dateId);
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
