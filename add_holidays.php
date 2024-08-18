<?php
session_start(); 

include 'includes/dbconn.php';

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$dateHoliday = $_POST['dateHolidays'];
$holiday = $_POST['holidays'];

$check_query = "SELECT * FROM holidays WHERE dateHolidays = ?";
$check_stmt = $mysqli->prepare($check_query);
$check_stmt->bind_param("s", $dateHoliday);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    $_SESSION['errorHolidays'] = "The selected date is already occupied by another event.";
} else {
    $query = "INSERT INTO holidays (dateHolidays, holiday) VALUES (?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ss", $dateHoliday, $holiday);

    if ($stmt->execute()) {
        $_SESSION['saveHolidays'] = "Event added successfully.";
    } else {
        $_SESSION['cancel'] = "There was a problem adding the event.";
    }

    $stmt->close();
}

$check_stmt->close();
$mysqli->close();

header('Location: adminHolidays.php');
exit();
?>