<?php
session_start(); 

include 'includes/dbconn.php';


$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$slots = $_POST['Slots'];
$slots_Date = $_POST['SlotsDate'];
$start_Time = $_POST['StartTime'];
$end_Time = $_POST['EndTime'];
$durations = $_POST['Durations'];   

$check_query = "SELECT * FROM schedule_record_table WHERE Slots_Date = ?";
$check_stmt = $mysqli->prepare($check_query);
$check_stmt->bind_param("s", $slots_Date);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    $_SESSION['errorevent'] = "The selected date date is already occupied by another event.";
} else {
    $query = "INSERT INTO schedule_record_table (Slots, Slots_Date, Start_Time, End_Time, Durations) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sssss", $slots, $slots_Date, $start_Time, $end_Time, $durations);

    if ($stmt->execute()) {
        $_SESSION['save'] = "Event added successfully.";
    } else {
        $_SESSION['cancel'] = "There was a problem adding the event.";
    }

    $stmt->close();
}

$check_stmt->close();
$mysqli->close();

header('Location: adminSchedule.php');
exit();
?>