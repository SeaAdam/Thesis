<?php

include 'includes/dbconn.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "SELECT ci.*, ca.Username, ca.Password 
            FROM clients_info ci 
            LEFT JOIN clients_account ca ON ci.id = ca.client_id 
            WHERE ci.id = '$id'";

    $query = $conn->query($sql);
    $row = $query->fetch_assoc();


    echo json_encode($row);
}

?>