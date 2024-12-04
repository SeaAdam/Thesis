<?php
session_start();

include 'includes/dbconn.php';

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$Services = $_POST['Services'];
$Cost = $_POST['Cost'];
$startTime = $_POST['startTime'];  // Assuming you add this in your form
$endTime = $_POST['endTime'];      // Assuming you add this in your form
$duration = $_POST['duration'];    // Assuming you add this in your form

// Check if the service already exists in the database
$check_query = "SELECT * FROM services_table WHERE Services = ?";
$check_stmt = $mysqli->prepare($check_query);
$check_stmt->bind_param("s", $Services);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    $_SESSION['errorServices'] = "The selected service is already in the record.";
} else {
    // Insert new service into the services_table
    $query = "INSERT INTO services_table (Services, Cost, start_time, end_time, duration) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sssss", $Services, $Cost, $startTime, $endTime, $duration);

    if ($stmt->execute()) {
        // Service was added successfully, now generate time slots
        $lastInsertedId = $stmt->insert_id;  // Get the last inserted service ID

        // Generate the time slots dynamically based on start time, end time, and duration
        $timeSlots = generateTimeSlots($startTime, $endTime, $duration);

        // Insert count of time slots into the services_table
        $slotCount = count($timeSlots);
        $updateQuery = "UPDATE services_table SET slots_count = ? WHERE id = ?";
        $updateStmt = $mysqli->prepare($updateQuery);
        $updateStmt->bind_param("ii", $slotCount, $lastInsertedId);
        $updateStmt->execute();

        // Now, insert each time slot into the time_slots table
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