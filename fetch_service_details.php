<?php
// Include your database connection
include 'includes/dbconn.php';

// Check if a service ID is provided in the GET request
if (isset($_GET['service_id'])) {
    $service_id = $_GET['service_id'];

    // Create a new connection to the database (if not already connected)
    global $conn;

    // Fetch the time slots for the provided service_id from the time_slots table
    $query = "SELECT id, time_slot, isBooked FROM time_slots WHERE service_id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(['error' => 'Failed to prepare SQL statement']);
        exit;
    }

    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the service has available time slots
    if ($result->num_rows > 0) {
        $timeSlots = [];

        // Fetch the time slots and add them to the timeSlots array
        while ($row = $result->fetch_assoc()) {
            // Check if the slot is booked
            $isBooked = $row['isBooked'] == 1; // If isBooked is 1, the slot is unavailable

            $timeSlots[] = [
                'id' => $row['id'],
                'time_slot' => $row['time_slot'],
                'isBooked' => $isBooked // Add the isBooked field to the response
            ];
        }

        // Return the time slots as a JSON response
        echo json_encode(['timeSlots' => $timeSlots]);
    } else {
        // Return an error if no time slots are found for the selected service
        echo json_encode(['error' => 'No available time slots for this service.']);
    }

    // Close the prepared statement
    $stmt->close();
} else {
    // Return an error if no service ID is provided
    echo json_encode(['error' => 'Service ID not provided']);
}
?>
