<?php
include 'includes/dbconn.php';

// Prepare the SQL query to fetch services
$sql = "SELECT * FROM services_table";
$query = $conn->query($sql);

// Check if the query is successful
if ($query) {
    // Fetch all the services as an associative array
    $services = [];
    while ($row = $query->fetch_assoc()) {
        $services[] = $row;
    }

    // Send the response as JSON
    header('Content-Type: application/json');
    echo json_encode($services);
} else {
    // Send an error response if the query fails
    http_response_code(500);  // Internal Server Error
    echo json_encode(['error' => 'Failed to fetch services']);
}
?>
