<?php
include 'includes/dbconn.php';

header('Content-Type: application/json');

// Check if necessary data is sent in the POST request
if (isset($_POST['serviceIds']) && isset($_POST['schedule']) && isset($_POST['userId'])) {
    $serviceIds = json_decode($_POST['serviceIds']);
    $schedule = $_POST['schedule'];
    $userId = $_POST['userId'];  // This is now userId (the logged-in user making the booking)

    if (empty($serviceIds) || empty($schedule) || empty($userId)) {
        echo json_encode(['success' => false, 'error' => 'Invalid input data']);
        exit;
    }

    $serviceIdsJson = json_encode($serviceIds);
    $status = 'pending';  // Default status is 'pending'

    // Check if there are any pending bookings for the current user
    $checkQuery = "SELECT id FROM bookings_table WHERE status = 'pending' AND user_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $userId);  // Bind the user_id
    $stmt->execute();
    $stmt->store_result();

    // If there's any pending booking, prevent the new booking
    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'error' => 'You already have a pending booking.']);
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

    // Bind parameters and execute the query
    $stmt->bind_param("ssss", $userId, $serviceIdsJson, $schedule, $status);

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
