<?php

include 'includes/dbconn.php';

// Create a new MySQLi instance
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Query to fetch events
$query = "SELECT ID, Title, Descriptions, Start_dates, End_date FROM events_table";
$result = $mysqli->query($query);

$events = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $end_date = date('Y-m-d', strtotime($row['End_date'] . ' +1 day')); // Adjust end date to include the entire day
        $events[] = [
            'id' => $row['ID'],
            'title' => $row['Title'],
            'description' => $row['Descriptions'],
            'start' => $row['Start_dates'],
            'end' => $end_date,  // Updated end date
            'buttonText' => 'View'
        ];
    }
}

// Close the connection
$mysqli->close();

// Output JSON
header('Content-Type: application/json');
echo json_encode($events);

?>
