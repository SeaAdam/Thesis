<?php
include 'includes/dbconn.php';


header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM registration_table WHERE ID = '$id'";
    $query = $conn->query($sql);
    $row = $query->fetch_assoc();

    if ($row) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'No data found']);
    }
} else {
    echo json_encode(['error' => 'ID not set']);
}
?>
