<?php
session_start();
include 'includes/dbconn.php';

$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get the SlotsDate from POST
$slots_Date = $_POST['SlotsDate'];

// Check if the selected date already exists
$check_query = "SELECT * FROM schedule_record_table WHERE Slots_Date = ?";
$check_stmt = $mysqli->prepare($check_query);
$check_stmt->bind_param("s", $slots_Date);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    $_SESSION['errorevent'] = "The selected date is already occupied by another event.";
    $check_stmt->close();
    $mysqli->close();
    header('Location: adminSchedule.php');
    exit();
}

$check_stmt->close();

// Insert the SlotsDate into the table
$query = "INSERT INTO schedule_record_table (Slots_Date) VALUES (?)";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $slots_Date);

if ($stmt->execute()) {
    $_SESSION['save'] = "Date added successfully.";
} else {
    $_SESSION['cancel'] = "There was a problem saving the date.";
}

$stmt->close();
$mysqli->close();

// Redirect back to the admin schedule page
header('Location: adminSchedule.php');
exit();
?>
