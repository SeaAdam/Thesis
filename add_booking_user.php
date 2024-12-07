<?php
include 'includes/dbconn.php';


function logToDatabase($message) {
    global $conn;
    $sql = "INSERT INTO booking_logs (message) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $message);
    $stmt->execute();
    $stmt->close();
}

$patientId = $_POST['patientName'];
$serviceType = $_POST['serviceType'];
$scheduleId = $_POST['scheduleId'];
$timeSlotId = $_POST['selectedTimeSlot']; 


if (empty($patientId)) {
    $message = "Error: Patient ID is empty.";
    logToDatabase($message);
    die($message);
}


$sql = "SELECT FirstName, MI, LastName, username FROM registration_table WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $patientId);
$stmt->execute();
$result = $stmt->get_result();
$userRow = $result->fetch_assoc();
$stmt->close();

if (!$userRow) {
    $message = "Error: User not found for Patient ID: $patientId.";
    logToDatabase($message);
    die($message);
}

$firstName = $userRow['FirstName'];
$mi = $userRow['MI'];
$lastName = $userRow['LastName'];
$username = $userRow['username'];


logToDatabase("User details retrieved for: $firstName $mi $lastName, Username: $username");


$sql = "SELECT ID FROM transactions WHERE user_id = ? AND status IN ('Pending', 'Approved')";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $patientId);
$stmt->execute();
$result = $stmt->get_result();
$existingBooking = $result->fetch_assoc();
$stmt->close();

if ($existingBooking) {

    session_start();
    $_SESSION['errorMessage'] = "Error: You already have a pending or approved booking. Please complete your current booking first.";
    logToDatabase($_SESSION['errorMessage']);
    header('Location: userDashboard.php');
    exit;
}



$sql = "SELECT ID FROM registration_table WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$userRow = $result->fetch_assoc();
$stmt->close();

if (!$userRow) {
    $message = "Error: User ID not found for username: $username.";
    logToDatabase($message);
    die($message);
}

$user_id = $userRow['ID'];


$transactionNo = 'PTN-' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);


$conn->begin_transaction();

try {

    logToDatabase("Attempting to insert new transaction: $transactionNo.");

    $sql = "INSERT INTO transactions (status, transaction_no, service_id, schedule_id, time_slot_id, date_seen, user_id) 
            VALUES (?, ?, ?, ?, ?, NOW(), ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssi', $status, $transactionNo, $serviceType, $scheduleId, $timeSlotId, $user_id);

    $status = 'Pending';

    if (!$stmt->execute()) {
        throw new Exception('Error inserting transaction: ' . $stmt->error);
    }


    logToDatabase("Transaction $transactionNo inserted successfully.");


    $sql = "UPDATE services_table SET slots_count = slots_count - 1 WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $serviceType);

    if (!$stmt->execute()) {
        throw new Exception('Error updating schedule slots: ' . $stmt->error);
    }


    logToDatabase("Schedule slots updated for schedule ID: $serviceType.");


    $notificationSql = "INSERT INTO admin_notification (user_id, transaction_no, message, created_at) VALUES (?, ?, ?, NOW())";
    $notificationStmt = $conn->prepare($notificationSql);

    if (!$notificationStmt) {
        throw new Exception('Prepare failed for notification: ' . $conn->error);
    }

    $message = "New Appointment Booking Transaction: $transactionNo with user id $user_id.";
    $notificationStmt->bind_param('iss', $user_id, $transactionNo, $message);

    if (!$notificationStmt->execute()) {
        throw new Exception('Error executing notification: ' . $notificationStmt->error);
    }


    logToDatabase("Notification for transaction $transactionNo successfully inserted.");


    $notificationStmt->close();
    $conn->commit();
    
    $_SESSION['successBookingUser'] = 'Booking successfully added!';
    logToDatabase("Booking transaction completed successfully for transaction number: $transactionNo.");
} catch (Exception $e) {

    $conn->rollback();
    $_SESSION['error'] = $e->getMessage();
    logToDatabase("Error during transaction: " . $e->getMessage());
}


$stmt->close();
$conn->close();


header('Location: userDashboard.php');
exit;
?>