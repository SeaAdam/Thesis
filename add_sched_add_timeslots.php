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
    $_SESSION['errorevent'] = "The selected date is already occupied by another event.";
    $check_stmt->close();
    $mysqli->close();
    header('Location: adminSchedule.php');
    exit();
}

$check_stmt->close();


$query = "INSERT INTO schedule_record_table (Slots, Slots_Date, Start_Time, End_Time, Durations) VALUES (?, ?, ?, ?, ?)";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("sssss", $slots, $slots_Date, $start_Time, $end_Time, $durations);

if ($stmt->execute()) {

    $schedule_id = $stmt->insert_id;
    $_SESSION['save'] = "Event added successfully.";
    

    $start = new DateTime($start_Time);
    $end = new DateTime($end_Time);
    $interval = new DateInterval('PT' . $durations . 'M');

    while ($start < $end) {
        $slot_end = clone $start;
        $slot_end->add($interval);

        if ($slot_end > $end) {
            $slot_end = $end;
        }

        $start_time_str = $start->format('H:i:s');
        $end_time_str = $slot_end->format('H:i:s');
        

        $insert_query = "INSERT INTO time_slots (start_time, end_time, schedule_id) VALUES (?, ?, ?)";
        $insert_stmt = $mysqli->prepare($insert_query);
        $insert_stmt->bind_param('ssi', $start_time_str, $end_time_str, $schedule_id);
        $insert_stmt->execute();
        $insert_stmt->close();
        
        $start = $slot_end;
    }
} else {
    $_SESSION['cancel'] = "There was a problem saving the event.";
}

$stmt->close();
$mysqli->close();

header('Location: adminSchedule.php');
exit();
?>
