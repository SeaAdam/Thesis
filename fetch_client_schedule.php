<?php

include 'includes/dbconn.php';

header('Content-Type: application/json');

try {

    $sql = "SELECT schedule_date AS start FROM client_schedule";
    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("Database query failed: " . $conn->error);
    }

    $events = [];
    while ($row = $result->fetch_assoc()) {
        $scheduleDate = $row['start'];


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

        $isBooked = $booking['booked'] > 0;
        $status = $booking['status'] ?? '';


        $shouldBeRed = in_array($status, ['Completed', 'Rejected']) ? false : $isBooked;

        $events[] = [
            'start' => $scheduleDate,
            'title' => '',
            'extendedProps' => [
                'isBooked' => $shouldBeRed,
                'status' => $status
            ]
        ];
    }

    echo json_encode($events);
} catch (Exception $e) {

    echo json_encode(['error' => $e->getMessage()]);
}

$conn->close();








?>
