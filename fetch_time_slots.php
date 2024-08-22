<?php
header('Content-Type: application/json');

include 'includes/dbconn.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

if (!isset($_GET['schedule_id']) || empty($_GET['schedule_id'])) {
    echo json_encode(['error' => 'Invalid schedule_id']);
    exit;
}

$schedule_id = $_GET['schedule_id'];

if ($schedule_id > 0) {
    // Fetch time slots based on the schedule_id and include the ID
    $sql = "SELECT ID, start_time, end_time FROM time_slots WHERE schedule_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $schedule_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $time_slots = [];
    while ($row = $result->fetch_assoc()) {
        $time_slots[] = [
            'id' => $row['ID'],
            'start_time' => $row['start_time'],
            'end_time' => $row['end_time']
        ];
    }

    // Output the time slots in JSON format
    echo json_encode($time_slots);

    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid schedule_id']);
}

$conn->close();
?>
