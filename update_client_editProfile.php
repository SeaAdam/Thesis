<?php
include 'includes/dbconn.php';

if (isset($_POST['ID'])) {
    $ID = $_POST['ID'];
    $client_name = $_POST['client_name'];
    $company_name = $_POST['company_name'];
    $position = $_POST['position'];
    $address = $_POST['address'];
    $contact_number = $_POST['contact_number'];
    $email_address = $_POST['email_address'];

    $sql = "UPDATE clients_info SET client_name ='$client_name', company_name='$company_name', 
    position ='$position', address='$address', 
    contact_number ='$contact_number', email_address ='$email_address' WHERE id='$ID'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => 'Record updated successfully']);
    } else {
        echo json_encode(['error' => 'Error updating record: ' . $conn->error]);
    }
} else {
    echo json_encode(['error' => 'ID not set']);
}
?>
