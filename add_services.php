<?php
session_start();
include 'includes/dbconn.php';

// Establish the connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch form data
$Services = $_POST['Services'];
$Cost = $_POST['Cost'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
$duration = $_POST['duration'];
$selectedDate = $_POST['serviceDate'];  // New date field
$schedule_id = $_POST['schedule_id'];   // Fetching the selected schedule ID from the form

// Check if the service already exists in the database
$check_query = "SELECT * FROM services_table WHERE Services = ? AND schedule_id = ?";
$check_stmt = $mysqli->prepare($check_query);
$check_stmt->bind_param("si", $Services, $schedule_id);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    $_SESSION['errorServices'] = "The selected service is already in the record.";
} else {
    // Insert new service into the services_table with schedule_id
    $query = "INSERT INTO services_table (Services, Cost, start_time, end_time, duration, schedule_id) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sssssi", $Services, $Cost, $startTime, $endTime, $duration, $schedule_id);

    if ($stmt->execute()) {
        // Service was added successfully, now generate time slots
        $lastInsertedId = $stmt->insert_id;  // Get the last inserted service ID

        // Generate time slots based on start time, end time, and duration
        $timeSlots = generateTimeSlots($startTime, $endTime, $duration);

        // Insert count of time slots into the services_table
        $slotCount = count($timeSlots);
        $updateQuery = "UPDATE services_table SET slots_count = ? WHERE id = ?";
        $updateStmt = $mysqli->prepare($updateQuery);
        $updateStmt->bind_param("ii", $slotCount, $lastInsertedId);
        $updateStmt->execute();

        // Now insert each time slot into the time_slots table with the schedule_id
        $timeSlotQuery = "INSERT INTO time_slots (service_id, time_slot, schedule_id) VALUES (?, ?, ?)";
        $timeSlotStmt = $mysqli->prepare($timeSlotQuery);

        foreach ($timeSlots as $timeSlot) {
            $timeSlotStmt->bind_param("iss", $lastInsertedId, $timeSlot, $schedule_id);
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

/**
 * Function to generate time slots based on start time, end time, and duration
 */
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