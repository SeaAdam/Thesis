<?php
include 'includes/dbconn.php';

// Create a new MySQLi instance
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Query to fetch events
$query = "SELECT ID, Slots_Date  FROM schedule_record_table";
$result = $mysqli->query($query);

$events = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = [
            'id' => $row['ID'],
            'start' => $row['Slots_Date'],  // Ensure this format is compatible with FullCalendar
            'extendedProps' => [
                'schedule_id' => $row['ID'],  // Include the schedule_id here
                'buttonText' => 'Book Here'  // Example button text
            ],
        ];
    }
}

// Close the connection
$mysqli->close();

// Output JSON
header('Content-Type: application/json');
echo json_encode($events);

?>