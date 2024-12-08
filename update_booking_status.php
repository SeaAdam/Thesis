<?php
include 'includes/dbconn.php';

if (isset($_POST['bookingId']) && isset($_POST['action'])) {
    $bookingId = $_POST['bookingId'];
    $action = $_POST['action'];

    if ($action === 'accept') {
        $status = 'accepted';
    } elseif ($action === 'reject') {
        $status = 'rejected';
    } else {
        echo "Invalid action!";
        exit;
    }

    // Update the booking status
    $query = "UPDATE bookings_table SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo "Database prepare failed";
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
