<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'includes/dbconn.php';

header('Content-Type: application/json');

// Check if user_id and other fields are provided
if (isset($_POST['user_id'], $_POST['serviceIds'], $_POST['schedule'])) {
    $user_id = $_POST['user_id'];
    $serviceIds = json_decode($_POST['serviceIds']);
    $schedule = $_POST['schedule'];



    // Validate inputs
    if (empty($user_id) || empty($serviceIds) || empty($schedule)) {
        echo json_encode(['success' => false, 'error' => 'Invalid input data']);
        exit;
    }

    // Validate user_id exists in registration_table
    $checkUserQuery = "SELECT ID FROM registration_table WHERE ID = ?";
    $stmt = $conn->prepare($checkUserQuery);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        echo json_encode(['success' => false, 'error' => 'Invalid user ID. The user does not exist.']);
        $stmt->close();
        $conn->close();
        exit;
    }
    $stmt->close();


    // Check if there are any pending bookings for the selected user
    $checkQuery = "SELECT id FROM bookings_table WHERE status = 'pending' AND user_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'error' => 'There is already a pending booking for this user.']);
        $stmt->close();
        $conn->close();
        exit;
    }
    $stmt->close();

    // Insert the booking into the database
    $status = 'pending'; // Default status is 'pending'
    $serviceIdsJson = json_encode($serviceIds);

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