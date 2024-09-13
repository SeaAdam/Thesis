<?php
session_start();

include 'includes/dbconn.php';

if (isset($_POST['submit'])) {
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
    if ($conn->query($sql)) {
        $_SESSION['successEditClient'] = "Client Information Successfully updated!";
    } else {
        $_SESSION['errorEditClient'] = $conn->error;
    }
} else {
    $_SESSION['error'] = 'Please Select First Information to Edit';
}
header('location:clientProfile.php');

?>