<?php
include 'includes/dbconn.php';

if (isset($_POST['bookingId']) && isset($_POST['action'])) {
    $bookingId = $_POST['bookingId'];
    $action = $_POST['action'];

    // Determine the status based on the action
    if ($action === 'accept') {
        $status = 'Accepted';
    } elseif ($action === 'reject') {
        $status = 'Rejected';
    } elseif ($action === 'complete') {
        $status = 'Completed';
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid action!']);
        exit;
    }

    // Update the booking status
    $query = "UPDATE bookings_table SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(['success' => false, 'error' => 'Database prepare failed']);
        exit;
    }

    $stmt->bind_param("si", $status, $bookingId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Booking status updated']);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
}

$conn->close();
?>
