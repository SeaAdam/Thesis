<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'includes/dbconn.php';

header('Content-Type: application/json');

if (isset($_POST['serviceIds']) && isset($_POST['schedule'])) {
    $serviceIds = json_decode($_POST['serviceIds']);
    $schedule = $_POST['schedule'];

    if (empty($serviceIds) || empty($schedule)) {
        echo json_encode(['success' => false, 'error' => 'Invalid input data']);
        exit;
    }

    $serviceIdsJson = json_encode($serviceIds);
    $status = 'pending';  // Default status is 'pending'

    // Prepare the query to insert into bookings table
    $query = "INSERT INTO bookings_table (service_ids, schedule, status) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        echo json_encode(['success' => false, 'error' => 'Database prepare failed']);
        exit;
    }

    $stmt->bind_param("sss", $serviceIdsJson, $schedule, $status);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input data']);
}

$conn->close();
?>
