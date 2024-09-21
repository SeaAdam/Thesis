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
$contact_number = $_POST['contact_number'];  // Fixed wrong field name
$address = $_POST['address'];
$email_address = $_POST['email_address'];   // Fixed wrong field name
$Username = $_POST['Username'];
$Password = $_POST['Password'];

// Validate password strength (at least 8 characters, including numbers and letters)
if (!preg_match('/^(?=.*\d)(?=.*[a-zA-Z]).{8,}$/', $Password)) {
    $_SESSION['errorPassword'] = "Password must be at least 8 characters long and contain both numbers and letters.";
    header('Location: adminClients.php');
    exit();
}

// Check if client name already exists
$check_query = "SELECT * FROM clients_info WHERE client_name = ?";
$check_stmt = $mysqli->prepare($check_query);
$check_stmt->bind_param("s", $client_name);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    $_SESSION['errorUserAlreadyAdded'] = "The client information is already registered.";
    $check_stmt->close();
    $mysqli->close();
    header('Location: adminClients.php');
    exit();
}

$check_stmt->close();

// Insert new client into clients_info
$query = "INSERT INTO clients_info (client_name, company_name, position, contact_number, address, email_address) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ssssss", $client_name, $company_name, $position, $contact_number, $address, $email_address);

if ($stmt->execute()) {
    // Get the last inserted client ID
    $client_id = $stmt->insert_id;

    // Insert Username and hashed Password into clients_account
    $account_query = "INSERT INTO clients_account (client_id, Username, Password) VALUES (?, ?, ?)";
    $account_stmt = $mysqli->prepare($account_query);
    $account_stmt->bind_param("iss", $client_id, $Username, $Password);

    if ($account_stmt->execute()) {
        $_SESSION['AddednewClients'] = "Successfully registered client and account.";
    } else {
        $_SESSION['cancelAddNewClients'] = "There was a problem registering the account.";
    }

    $account_stmt->close();
} else {
    $_SESSION['cancelAddNewClients'] = "There was a problem registering the client.";
}

$stmt->close();
$mysqli->close();

header('Location: adminClients.php');
exit();
?>
