<?php
include 'includes/dbconn.php';
function logAction($userId, $action, $details = '') {
    global $conn;
    
    $stmt = $conn->prepare("INSERT INTO action_logs (user_id, action, details) VALUES (?, ?, ?)");
    $stmt->bind_param('iss', $userId, $action, $details);
    
    if (!$stmt->execute()) {
        die('Error logging action: ' . $stmt->error);
    }
    
    $stmt->close();
}
?>