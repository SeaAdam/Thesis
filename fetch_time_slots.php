<?php
// header('Content-Type: application/json');

// include 'includes/dbconn.php';

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);

// // Check connection
// if ($conn->connect_error) {
//     die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
// }

// if (!isset($_GET['schedule_id']) || empty($_GET['schedule_id'])) {
//     echo json_encode(['error' => 'Invalid schedule_id']);
//     exit;
// }

// $schedule_id = $_GET['schedule_id'];

// if ($schedule_id > 0) {
//     // Fetch time slots based on the schedule_id and include the ID
//     $sql = "SELECT ts.ID, ts.start_time, ts.end_time, sr.Slots
//             FROM time_slots ts
//             JOIN schedule_record_table sr ON ts.schedule_id = sr.ID
//             WHERE ts.schedule_id = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param('i', $schedule_id);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     $time_slots = [];
//     while ($row = $result->fetch_assoc()) {
//         $time_slots[] = [
//             'id' => $row['ID'],
//             'start_time' => $row['start_time'],
//             'end_time' => $row['end_time'],
//             'slots_remaining' => $row['Slots'] // Assuming 'Slots' represents the available slots
//         ];
//     }

//     // Output the time slots in JSON format
//     echo json_encode($time_slots);

//     $stmt->close();
// } else {
//     echo json_encode(['error' => 'Invalid schedule_id']);
// }

// $conn->close();

//GOODS
header('Content-Type: application/json');

include 'includes/dbconn.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

if (!isset($_GET['schedule_id']) || empty($_GET['schedule_id'])) {
    echo json_encode(['error' => 'Invalid schedule_id']);
    exit;
}

$schedule_id = $_GET['schedule_id'];

if ($schedule_id > 0) {
    // Fetch time slots based on the schedule_id
    $sql = "
        SELECT ts.ID, ts.start_time, ts.end_time, sr.Slots,
               IFNULL(b.count, 0) AS booked_count
        FROM time_slots ts
        JOIN schedule_record_table sr ON ts.schedule_id = sr.ID
        LEFT JOIN (
            SELECT time_slot_id, COUNT(*) AS count
            FROM transactions
            WHERE status = 'Pending' OR status = 'Approved'
            GROUP BY time_slot_id
        ) b ON ts.ID = b.time_slot_id
        WHERE ts.schedule_id = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $schedule_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $time_slots = [];
    while ($row = $result->fetch_assoc()) {
        // Determine if the slot is booked
        $is_booked = ($row['booked_count'] > 0 || $row['Slots'] <= 0) ? true : false;

        $time_slots[] = [
            'id' => $row['ID'],
            'start_time' => $row['start_time'],
            'end_time' => $row['end_time'],
            'slots_remaining' => $row['Slots'],
            'is_booked' => $is_booked
        ];
    }

    // Output the time slots in JSON format
    echo json_encode($time_slots);

    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid schedule_id']);
}

$conn->close();


?>