<?php
session_start();

include 'includes/dbconn.php';

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$Services = $_POST['Services'];
$Cost = $_POST['Cost'];
$startTime = $_POST['startTime'];  
$endTime = $_POST['endTime'];      
$duration = $_POST['duration'];    

$check_query = "SELECT * FROM services_table WHERE Services = ?";
$check_stmt = $mysqli->prepare($check_query);
$check_stmt->bind_param("s", $Services);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    $_SESSION['errorServices'] = "The selected service is already in the record.";
} else {
    $query = "INSERT INTO services_table (Services, Cost, start_time, end_time, duration) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sssss", $Services, $Cost, $startTime, $endTime, $duration);

    if ($stmt->execute()) {
        $lastInsertedId = $stmt->insert_id;  

        
        $timeSlots = generateTimeSlots($startTime, $endTime, $duration);

        
        $slotCount = count($timeSlots);
        $updateQuery = "UPDATE services_table SET slots_count = ? WHERE id = ?";
        $updateStmt = $mysqli->prepare($updateQuery);
        $updateStmt->bind_param("ii", $slotCount, $lastInsertedId);
        $updateStmt->execute();

        
        $timeSlotQuery = "INSERT INTO time_slots (service_id, time_slot) VALUES (?, ?)";
        $timeSlotStmt = $mysqli->prepare($timeSlotQuery);

        foreach ($timeSlots as $timeSlot) {
            $timeSlotStmt->bind_param("is", $lastInsertedId, $timeSlot);
            $timeSlotStmt->execute();
        }

        $_SESSION['saveServices'] = "Services added and time slots generated successfully.";
        $timeSlotStmt->close();
        $updateStmt->close();
    } else {
        $_SESSION['cancelServices'] = "There was a problem adding the service.";
    }

    $stmt->close();
}

$check_stmt->close();
$mysqli->close();

header('Location: adminServices.php');
exit();


function generateTimeSlots($startTime, $endTime, $duration)
{
    $start = new DateTime($startTime);
    $end = new DateTime($endTime);
    $interval = new DateInterval('PT' . $duration . 'M');

    $slots = [];
    while ($start < $end) {
        $endSlot = clone $start;
        $endSlot->add($interval);

        // Format times as "HH:mm - HH:mm"
        $slots[] = $start->format('H:i') . ' - ' . $endSlot->format('H:i');
        $start->add($interval);
    }

    return $slots;  // Return array of time slots
}
?>