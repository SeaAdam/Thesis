<?php
session_start();
include 'includes/dbconn.php';
include_once('includes/logFunction.php');

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


error_log(print_r($_POST, true));

$response = array('status' => '', 'message' => '', 'role' => '');


$check_query = "SELECT * FROM clients_info WHERE client_name = ?";
$check_stmt = $mysqli->prepare($check_query);
$check_stmt->bind_param("s", $client_name);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    $_SESSION['errorInformationAlreadyRegistered'] = "The client information is already in the record.";


    logAction(0, 'Failed client registration attempt', "Client Name: $client_name, Error: Client information already in the record.");

    $response['status'] = 'error';
    $response['message'] = 'Client information is already in the record.';
} else {
    $query = "INSERT INTO clients_info (client_name, company_name, position, address, contact_number, email_address, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssssss", $client_name, $company_name, $position, $address, $contact_number, $email_address);

    if ($stmt->execute()) {
        $_SESSION['Registered'] = "Client registration is pending approval.";


        logAction(0, 'Successful client registration', "Client Name: $client_name, Company Name: $company_name, Status: Pending");

        $response['status'] = 'success';
        $response['message'] = 'Client registration is pending approval.';
        $response['role'] = 'Client';
    } else {
        $_SESSION['cancelClientReg'] = "There was a problem adding the client.";


        error_log("Error: " . $stmt->error);
        logAction(0, 'Failed client registration', "Client Name: $client_name, Error: " . $stmt->error);

        $response['status'] = 'error';
        $response['message'] = 'There was a problem adding the client.';
    }

    $stmt->close();
}

$check_stmt->close();
$mysqli->close();


header('Content-Type: application/json');
echo json_encode($response);
exit();

?>
