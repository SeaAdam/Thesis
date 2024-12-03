<?php
include 'includes/dbconn.php';


$selectedTimeSlot = $_POST['selectedTimeSlot'];
$patientId = $_POST['patientName'];
$serviceType = $_POST['serviceType'];
$scheduleId = $_POST['scheduleId'];
$timeSlotId = $_POST['timeSlotId'];


if (empty($patientId)) {
    die('Error: Patient ID is empty.');
}


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


$transactionNo = 'PTN-' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);


$conn->begin_transaction();

try {

    $sql = "INSERT INTO transactions (status, transaction_no, service_id, schedule_id, time_slot_id, date_seen, user_id) 
            VALUES (?, ?, ?, ?, ?, NOW(), ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssi', $status, $transactionNo, $serviceType, $scheduleId, $timeSlotId, $user_id);
    
    $status = 'Pending';
    
    if (!$stmt->execute()) {
        throw new Exception('Error: ' . $stmt->error);
    }


    $sql = "UPDATE schedule_record_table SET Slots = Slots - 1 WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $scheduleId);
    
    if (!$stmt->execute()) {
        throw new Exception('Error updating slots: ' . $stmt->error);
    }


    $conn->commit();
    $_SESSION['successBooking'] = 'Booking successfully added!';
} catch (Exception $e) {

    $conn->rollback();
    $_SESSION['error'] = $e->getMessage();
}


$stmt->close();
$conn->close();


header('Location: adminDashboard.php');
exit;

?>