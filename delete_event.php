<?php

include 'includes/dbconn.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $eventId = $data['id'];

    // Delete event from the database
    $mysqli = new mysqli($servername, $username, $password, $dbname);
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $query = $mysqli->prepare("DELETE FROM events_table WHERE ID = ?");
    $query->bind_param("i", $eventId);
    $success = $query->execute();
    $mysqli->close();

    // Return success status
    echo json_encode(['success' => $success]);
}
?>
