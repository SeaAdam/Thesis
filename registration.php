<?php
session_start();
include 'includes/dbconn.php';
include_once('includes/logFunction.php');

$mysqli = new mysqli($servername, $username, $password, $dbname);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$FirstName = $_POST['FirstName'];
$MI = $_POST['MI'];
$LastName = $_POST['LastName'];
$Gender = $_POST['Gender'];
$DOB = $_POST['DOB'];
$Age = $_POST['Age'];
$Contact = $_POST['Contact'];
$PresentAddress = $_POST['PresentAddress'];
$Username = $_POST['Username'];
$Password = $_POST['Password'];
$ConfirmPassword = $_POST['ConfirmPassword'];

$response = [];

if ($Password !== $ConfirmPassword) {
    $response['status'] = 'error';
    $response['message'] = "Passwords do not match.";
    logAction(0, 'Failed registration attempt', "Username: $Username, Error: Passwords do not match");
    echo json_encode($response);
    exit();
}

if (!preg_match('/^(?=.*\d)(?=.*[a-zA-Z]).{8,}$/', $Password)) {
    $response['status'] = 'error';
    $response['message'] = "Password must be at least 8 characters long and contain both numbers and letters.";
    logAction(0, 'Failed registration attempt', "Username: $Username, Error: Password must be at least 8 characters long and contain both numbers and letters.");
    echo json_encode($response);
    exit();
}

$check_query = "SELECT * FROM registration_table WHERE Username = ? OR (FirstName = ? AND LastName = ?)";
$check_stmt = $mysqli->prepare($check_query);
$check_stmt->bind_param("sss", $Username, $FirstName, $LastName);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    $response['status'] = 'error';
    $response['message'] = "The information is already registered.";
    logAction(0, 'Failed registration attempt', "Username: $Username, FirstName: $FirstName, LastName: $LastName - Information already registered.");
    echo json_encode($response);
    $check_stmt->close();
    $mysqli->close();
    exit();
}

$check_stmt->close();
$query = "INSERT INTO registration_table (FirstName, MI, LastName, Gender, DOB, Age, Contact, PresentAddress, Username, Password, ConfirmPassword) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("sssssssssss", $FirstName, $MI, $LastName, $Gender, $DOB, $Age, $Contact, $PresentAddress, $Username, $Password, $ConfirmPassword);

if ($stmt->execute()) {
    $response['status'] = 'success';
    $response['role'] = 'Client';
    logAction(0, 'Successful registration', "Username: $Username, FirstName: $FirstName, LastName: $LastName, Registered successfully.");
} else {
    $response['status'] = 'error';
    $response['message'] = "There was a problem with registration.";
    logAction(0, 'Failed registration', "Username: $Username, Error: " . $stmt->error);
}

$stmt->close();
$mysqli->close();

echo json_encode($response);
exit();
?>
