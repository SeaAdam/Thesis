<?php
include 'includes/dbconn.php';

// Delete all logs from the table
$sql = "DELETE FROM booking_logs";
if ($conn->query($sql)) {
    // Send a success response
    http_response_code(200);
    echo json_encode(['status' => 'success', 'message' => 'Logs deleted successfully.']);
} else {
    // Send an error response
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete logs.']);
}
?>
