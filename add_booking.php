<?php
// include 'includes/dbconn.php';

// // Collect POST data
// $selectedTimeSlot = $_POST['selectedTimeSlot'];
// $patientName = $_POST['patientName'];
// $serviceType = $_POST['serviceType'];
// $scheduleId = $_POST['scheduleId'];
// $timeSlotId = $_POST['timeSlotId'];

// // Generate a unique transaction number in the format PTN-XXX
// $transactionNo = 'PTN-' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);

// // Insert into transactions table
// $sql = "INSERT INTO transactions (status, transaction_no, service_id, schedule_id, time_slot_id, date_seen) 
//         VALUES (?, ?, ?, ?, ?, NOW())";

// $stmt = $conn->prepare($sql);
// $stmt->bind_param('sssss', $status, $transactionNo, $serviceType, $scheduleId, $timeSlotId);

// $status = 'Pending'; // or any default status you prefer

// if ($stmt->execute()) {
//     echo 'Booking successfully added!';
// } else {
//     echo 'Error: ' . $stmt->error;
// }

// $stmt->close();
// $conn->close();

include 'includes/dbconn.php';

// Collect POST data
$selectedTimeSlot = $_POST['selectedTimeSlot'];
$patientId = $_POST['patientName']; // Expecting patient ID
$serviceType = $_POST['serviceType'];
$scheduleId = $_POST['scheduleId'];
$timeSlotId = $_POST['timeSlotId'];

// Debug: Output all POST data
echo "Received POST data:<br>";
foreach ($_POST as $key => $value) {
    echo htmlspecialchars($key) . ": " . htmlspecialchars($value) . "<br>";
}

// Debug: Output the received patient ID
echo "Received Patient ID: " . htmlspecialchars($patientId) . "<br>";

// Ensure patientId is not empty
if (empty($patientId)) {
    die('Error: Patient ID is empty.');
}

// Query to fetch the full name and username for the given patient ID
$sql = "SELECT FirstName, MI, LastName, username FROM registration_table WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $patientId);
$stmt->execute();
$result = $stmt->get_result();
$userRow = $result->fetch_assoc();
$stmt->close();

if (!$userRow) {
    die('Error: User not found.');
}

$firstName = $userRow['FirstName'];
$mi = $userRow['MI'];
$lastName = $userRow['LastName'];
$username = $userRow['username'];

// Debug: Output the fetched details
echo "Fetched First Name: " . htmlspecialchars($firstName) . "<br>";
echo "Fetched MI: " . htmlspecialchars($mi) . "<br>";
echo "Fetched Last Name: " . htmlspecialchars($lastName) . "<br>";
echo "Fetched Username: " . htmlspecialchars($username) . "<br>";

// Fetch user_id based on the username
$sql = "SELECT ID FROM registration_table WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$userRow = $result->fetch_assoc();
$stmt->close();

if (!$userRow) {
    die('Error: User ID not found.');
}

$user_id = $userRow['ID'];

// Debug: Output the user_id
echo "Fetched User ID: " . htmlspecialchars($user_id) . "<br>";

// Generate a unique transaction number in the format PTN-XXX
$transactionNo = 'PTN-' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);

// Insert into transactions table
$sql = "INSERT INTO transactions (status, transaction_no, service_id, schedule_id, time_slot_id, date_seen, user_id) 
        VALUES (?, ?, ?, ?, ?, NOW(), ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param('sssssi', $status, $transactionNo, $serviceType, $scheduleId, $timeSlotId, $user_id);

$status = 'Pending'; // or any default status you prefer

if ($stmt->execute()) {
    echo 'Booking successfully added!';
} else {
    echo 'Error: ' . $stmt->error;
}

$stmt->close();
$conn->close();





?>
