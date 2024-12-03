<?php
include 'includes/dbconn.php';


$sql = "DELETE FROM action_logs";
if ($conn->query($sql)) {

    http_response_code(200);
    echo json_encode(['status' => 'success', 'message' => 'Logs deleted successfully.']);
} else {

    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete logs.']);
}
?>
