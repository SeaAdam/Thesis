<?php
session_start(); 

include 'includes/dbconn.php';

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$ServiceProvider = $_POST['ServiceProvider'];
$MobileNo = $_POST['MobileNo'];

$check_query = "SELECT * FROM contactus_table WHERE MobileNo = ?";
$check_stmt = $mysqli->prepare($check_query);
$check_stmt->bind_param("s", $MobileNo);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    $_SESSION['errorContacts'] = "The selected service is already in the record.";
} else {
    $query = "INSERT INTO contactus_table (ServiceProvider, MobileNo) VALUES (?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ss", $ServiceProvider, $MobileNo);

    if ($stmt->execute()) {
        $_SESSION['saveContacts'] = "ServiceProvider added successfully.";
    } else {
        $_SESSION['cancelContacts'] = "There was a problem adding the service.";
    }

    $stmt->close();
}

$check_stmt->close();
$mysqli->close();

header('Location: adminContacts.php');
exit();
?>