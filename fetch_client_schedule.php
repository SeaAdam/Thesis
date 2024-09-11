<?php
include 'includes/dbconn.php';

// Fetch client-specific schedules
$sql = "SELECT schedule_date AS start FROM client_schedule";
$result = $conn->query($sql);

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'start' => $row['start'], // FullCalendar expects 'start' as the date
        'title' => 'Client Schedule', // Display title
        'extendedProps' => [
            'isClientSchedule' => true
        ]
    ];
}

echo json_encode($events); // Return the events in JSON format
$conn->close();
?>
