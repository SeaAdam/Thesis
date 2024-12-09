<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'includes/dbconn.php';

header('Content-Type: application/json');

session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['serviceIds']) && isset($_POST['schedule'])) {
    $serviceIds = json_decode($_POST['serviceIds']);
    $schedule = $_POST['schedule'];

    if (empty($serviceIds) || empty($schedule)) {
        echo json_encode(['success' => false, 'error' => 'Invalid input data']);
        exit;
    }

    $serviceIdsJson = json_encode($serviceIds);
    $status = 'pending';  // Default status is 'pending'


    // Check if there are any pending bookings
    $checkQuery = "SELECT id FROM bookings_table WHERE status = 'pending'";
    $stmt = $conn->prepare($checkQuery);
    $stmt->execute();
    $stmt->store_result();

    // If there's any pending booking, prevent the new booking
    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'error' => 'There is already a pending booking.']);
        $stmt->close();
        $conn->close();
        exit;
    }

    // Prepare the query to insert into bookings table
    $query = "INSERT INTO bookings_table (user_id, service_ids, schedule, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(['success' => false, 'error' => 'Database prepare failed']);
        exit;
    }

    $stmt->bind_param("ssss", $user_id, $serviceIdsJson, $schedule, $status);

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
