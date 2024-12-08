<?php
include 'includes/dbconn.php';

if (isset($_GET['schedule_id'])) {
    $scheduleId = $_GET['schedule_id'];
    
    // Query to fetch services available for the selected schedule
    $sql = "SELECT * FROM services_table WHERE schedule_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $scheduleId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $services = [];
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }

    // Return the services as JSON
    echo json_encode(['services' => $services]);
} else {
    echo json_encode(['services' => []]);
}
?>
