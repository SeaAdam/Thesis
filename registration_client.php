<?php
session_start(); 

include 'includes/dbconn.php';

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$client_name = $_POST['client_name'];
$company_name = $_POST['company_name'];
$position = $_POST['position'];
$address = $_POST['address'];
$contact_number = $_POST['contact_number'];
$email_address = $_POST['email_address'];   


$check_query = "SELECT * FROM clients_info WHERE client_name = ?";
$check_stmt = $mysqli->prepare($check_query);
$check_stmt->bind_param("s", $client_name);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    $_SESSION['errorInformationAlreadyRegistered'] = "The client information is already in the record.";
} else {
    $query = "INSERT INTO clients_info (client_name, company_name, position, address, contact_number, email_address) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssssss", $client_name, $company_name, $position, $address, $contact_number, $email_address);

    if ($stmt->execute()) {
        $_SESSION['Registered'] = "Services added successfully.";
    } else {
        $_SESSION['cancelClientReg'] = "There was a problem adding the service.";
    }

    $stmt->close();
}

$check_stmt->close();
$mysqli->close();

header('Location: index.php');
exit();
?>