<?php
require 'includes/dbconn.php'; // Database connection

// Get the reminder ID from the POST data
$data = json_decode(file_get_contents('php://input'), true);
$reminder_id = $data['reminder_id'];

// Update the reminder status to 'sent'
$sql = "UPDATE appointment_reminders SET sent = 1 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $reminder_id);

$response = ['status' => 'error'];

if ($stmt->execute()) {
    $response['status'] = 'success';
}

$stmt->close();
$conn->close();

// Send JSON response
echo json_encode($response);
?>
