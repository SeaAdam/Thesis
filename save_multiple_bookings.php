<?php
error_reporting(E_ALL);  // Report all errors
ini_set('display_errors', 1);  // Display errors

include 'includes/dbconn.php';  // Include database connection

header('Content-Type: application/json');  // Ensure the response is in JSON format

// Check if POST data is available
if (isset($_POST['serviceIds']) && isset($_POST['schedule'])) {
    // Get the POST data
    $serviceIds = json_decode($_POST['serviceIds']);  // Decode the selected service IDs
    $schedule = $_POST['schedule'];  // Get the selected schedule (AM or PM)

    // Validate the inputs
    if (empty($serviceIds) || empty($schedule)) {
        echo json_encode(['success' => false, 'error' => 'Invalid input data']);
        exit;
    }

    // Prepare the JSON-encoded service IDs
    $serviceIdsJson = json_encode($serviceIds);  // Convert service IDs to a JSON string

    // Assuming you have a bookings table where you store multiple bookings
    // Prepare the query to insert data into the bookings table
    $query = "INSERT INTO bookings_table (service_ids, schedule) VALUES (?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(['success' => false, 'error' => 'Database prepare failed']);
        exit;
    }

    // Bind the parameters
    $stmt->bind_param("ss", $serviceIdsJson, $schedule);  // Store service IDs as a JSON string

    // Execute the statement and check if it was successful
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);  // Return error message if failed
    }

    // Close the statement
    $stmt->close();
} else {
    // Return an error if POST data is not received correctly
    echo json_encode(['success' => false, 'error' => 'Invalid input data']);
}

// Close the connection
$conn->close();
?>
