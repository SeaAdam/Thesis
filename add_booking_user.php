<?php
include 'includes/dbconn.php';

// Collect POST data
$selectedTimeSlot = $_POST['selectedTimeSlot'];
$patientId = $_POST['patientName']; // Expecting patient ID
$serviceType = $_POST['serviceType'];
$scheduleId = $_POST['scheduleId'];
$timeSlotId = $_POST['timeSlotId'];

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

// Generate a unique transaction number in the format PTN-XXX
$transactionNo = 'PTN-' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);

// Begin transaction
$conn->begin_transaction();

try {
    // Insert into transactions table
    $sql = "INSERT INTO transactions (status, transaction_no, service_id, schedule_id, time_slot_id, date_seen, user_id) 
            VALUES (?, ?, ?, ?, ?, NOW(), ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssi', $status, $transactionNo, $serviceType, $scheduleId, $timeSlotId, $user_id);

    $status = 'Pending'; // or any default status you prefer

    if (!$stmt->execute()) {
        throw new Exception('Error: ' . $stmt->error);
    }

    // Decrement the slot count
    $sql = "UPDATE schedule_record_table SET Slots = Slots - 1 WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $scheduleId);

    if (!$stmt->execute()) {
        throw new Exception('Error updating slots: ' . $stmt->error);
    }

    // Insert a notification into the notifications table
    $notificationSql = "INSERT INTO admin_notification (user_id, transaction_no, message, created_at) VALUES (?, ?, ?, NOW())";
    $notificationStmt = $conn->prepare($notificationSql);

    if (!$notificationStmt) {
        die('Prepare failed: ' . $conn->error);
    }

    $message = "New Appointment Booking Transaction: $transactionNo with user id $user_id.";
    $notificationStmt->bind_param('iss', $user_id, $transactionNo, $message);

    if (!$notificationStmt->execute()) {
        die('Execute failed: ' . $notificationStmt->error);
    }

    $notificationStmt->close();

    // Commit transaction
    $conn->commit();
    $_SESSION['successBookingUser'] = 'Booking successfully added!';
} catch (Exception $e) {
    // Rollback transaction in case of error
    $conn->rollback();
    $_SESSION['error'] = $e->getMessage();
}

// Close connection
$stmt->close();
$conn->close();

// Redirect back to the booking page
header('Location: userDashboard.php');
exit;
?>