<?php
include 'includes/dbconn.php';

$sql = "SELECT * FROM action_logs ORDER BY timestamp DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

while ($log = $result->fetch_assoc()) {
    echo "User ID: " . $log['user_id'] . "<br>";
    echo "Action: " . $log['action'] . "<br>";
    echo "Details: " . $log['details'] . "<br>";
    echo "Timestamp: " . $log['timestamp'] . "<br><hr>";
}
?>