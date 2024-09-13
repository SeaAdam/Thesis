<?php

include 'includes/dbconn.php';

header('Content-Type: application/json'); // Ensure the content type is JSON

try {
    // Fetch client-specific schedules
    $sql = "SELECT schedule_date AS start FROM client_schedule";
    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("Database query failed: " . $conn->error);
    }

    $events = [];
    while ($row = $result->fetch_assoc()) {
        $scheduleDate = $row['start'];

        // Check if this date is booked in client_booking
        $checkBookingSql = "SELECT COUNT(*) AS booked, MAX(status) AS status FROM client_booking WHERE date_appointment = ?";
        $stmt = $conn->prepare($checkBookingSql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param('s', $scheduleDate);
        $stmt->execute();
        $checkResult = $stmt->get_result();
        $booking = $checkResult->fetch_assoc();

        if (!$booking) {
            throw new Exception("Query failed: " . $stmt->error);
        }

        $isBooked = $booking['booked'] > 0; // Check if any bookings exist for this date
        $status = $booking['status'] ?? ''; // Default to empty if no status is found

        // Determine if the button should be red
        $shouldBeRed = in_array($status, ['Completed', 'Rejected']) ? false : $isBooked;

        $events[] = [
            'start' => $scheduleDate, // FullCalendar expects 'start' as the date
            'title' => '', // Display title
            'extendedProps' => [
                'isBooked' => $shouldBeRed, // Include booking status
                'status' => $status // Include status
            ]
        ];
    }

    echo json_encode($events); // Return the events in JSON format
} catch (Exception $e) {
    // Handle exceptions and return an error message
    echo json_encode(['error' => $e->getMessage()]);
}

$conn->close();








?>
