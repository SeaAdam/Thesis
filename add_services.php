<?php
session_start(); 

include 'includes/dbconn.php';

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$Services = $_POST['Services'];
$Cost = $_POST['Cost'];

$check_query = "SELECT * FROM services_table WHERE Services = ?";
$check_stmt = $mysqli->prepare($check_query);
$check_stmt->bind_param("s", $Services);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    $_SESSION['errorServices'] = "The selected service is already in the record.";
} else {
    $query = "INSERT INTO services_table (Services, Cost) VALUES (?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ss", $Services, $Cost);

    if ($stmt->execute()) {
        $_SESSION['saveServices'] = "Services added successfully.";
    } else {
        $_SESSION['cancelServices'] = "There was a problem adding the service.";
    }

    $stmt->close();
}

$check_stmt->close();
$mysqli->close();

header('Location: adminServices.php');
exit();
?>