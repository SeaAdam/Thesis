<?php


session_start(); 
include 'includes/dbconn.php';

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$schedule_dates = $_POST['schedule_date']; // This will now be an array

foreach ($schedule_dates as $schedule_date) {
    // Check if the date already exists in the database
    $check_query = "SELECT * FROM client_schedule WHERE schedule_date = ?";
    $check_stmt = $mysqli->prepare($check_query);
    $check_stmt->bind_param("s", $schedule_date);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $_SESSION['errorClientSchedule'] = "The date $schedule_date is already occupied.";
    } else {
        // Insert the new date into the database
        $query = "INSERT INTO client_schedule (schedule_date) VALUES (?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $schedule_date);

        if ($stmt->execute()) {
            $_SESSION['saveClientSchedule'] = "Date $schedule_date added successfully.";
        } else {
            $_SESSION['cancel'] = "There was a problem adding the date $schedule_date.";
        }

        $stmt->close();
    }
    $check_stmt->close();
}

$mysqli->close();
header('Location: clientSchedule.php');
exit();

?>