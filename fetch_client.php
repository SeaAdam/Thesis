<?php

include 'includes/dbconn.php';

if (isset($_POST['id'])) {
    $ID = $_POST['id'];
    $sql = "SELECT * FROM clients_info WHERE id= '$ID'";
    $query = $conn->query($sql);
    $row = $query->fetch_assoc();
    echo json_encode($row);
}
?>