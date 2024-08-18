<?php
session_start(); 

include 'includes/dbconn.php';


$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$title = $_POST['eventTitle'];
$description = $_POST['eventDescription'];
$start_date = $_POST['startDate'];
$end_date = $_POST['endDate'];

$check_query = "SELECT * FROM events_table WHERE (Start_dates <= ? AND End_date >= ?)";
$check_stmt = $mysqli->prepare($check_query);
$check_stmt->bind_param("ss", $end_date, $start_date);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    $_SESSION['errorevent'] = "The selected date range is already occupied by another event.";
} else {
    $query = "INSERT INTO events_table (Title, Descriptions, Start_dates, End_date) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssss", $title, $description, $start_date, $end_date);

    if ($stmt->execute()) {
        $_SESSION['save'] = "Event added successfully.";
    } else {
        $_SESSION['cancel'] = "There was a problem adding the event.";
    }

    $stmt->close();
}

$check_stmt->close();
$mysqli->close();

header('Location: adminEvents.php');
exit();
?>