<?php

include 'includes/dbconn.php';

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $sql = "SELECT * FROM client_schedule WHERE id= '$id'";
    $query = $conn->query($sql);
    $row = $query->fetch_assoc();
    echo json_encode($row);
}
?>