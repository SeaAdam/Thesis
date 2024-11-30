<?php
include 'includes/dbconn.php';

// Function to log messages
function logToDatabase($message) {
    global $conn;
    $sql = "INSERT INTO booking_logs (message) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $message);
    $stmt->execute();
    $stmt->close();
}

$selectedTimeSlot = $_POST['selectedTimeSlot'];
$patientId = $_POST['patientName'];
$serviceType = $_POST['serviceType'];
$scheduleId = $_POST['scheduleId'];
$timeSlotId = $_POST['timeSlotId'];

// Check for empty patientId
if (empty($patientId)) {
    $message = "Error: Patient ID is empty.";
    logToDatabase($message);
    die($message);
}

// Fetch user details
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

// Log user information retrieval
logToDatabase("User details retrieved for: $firstName $mi $lastName, Username: $username");

// Check if the user already has a pending or approved booking
$sql = "SELECT ID FROM transactions WHERE user_id = ? AND status IN ('Pending', 'Approved')";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $patientId);
$stmt->execute();
$result = $stmt->get_result();
$existingBooking = $result->fetch_assoc();
$stmt->close();

if ($existingBooking) {
    // User has a pending or approved booking, restrict new booking
    session_start();
    $_SESSION['errorMessage'] = "Error: You already have a pending or approved booking. Please complete your current booking first.";
    logToDatabase($_SESSION['errorMessage']);
    header('Location: userDashboard.php'); // Redirect to the user dashboard
    exit; // Ensure no further code is executed
}


// Fetch user ID based on username
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

// Generate transaction number
$transactionNo = 'PTN-' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);

// Begin database transaction
$conn->begin_transaction();

try {
    // Log the start of the transaction
    logToDatabase("Attempting to insert new transaction: $transactionNo.");

    $sql = "INSERT INTO transactions (status, transaction_no, service_id, schedule_id, time_slot_id, date_seen, user_id) 
            VALUES (?, ?, ?, ?, ?, NOW(), ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssi', $status, $transactionNo, $serviceType, $scheduleId, $timeSlotId, $user_id);

    $status = 'Pending'; // Initial status for new transaction

    if (!$stmt->execute()) {
        throw new Exception('Error inserting transaction: ' . $stmt->error);
    }

    // Log transaction insertion
    logToDatabase("Transaction $transactionNo inserted successfully.");

    // Update schedule slots
    $sql = "UPDATE schedule_record_table SET Slots = Slots - 1 WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $scheduleId);

    if (!$stmt->execute()) {
        throw new Exception('Error updating schedule slots: ' . $stmt->error);
    }

    // Log slot update
    logToDatabase("Schedule slots updated for schedule ID: $scheduleId.");

    // Insert notification
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

    // Log notification insertion
    logToDatabase("Notification for transaction $transactionNo successfully inserted.");

    // Commit transaction
    $notificationStmt->close();
    $conn->commit();
    
    $_SESSION['successBookingUser'] = 'Booking successfully added!';
    logToDatabase("Booking transaction completed successfully for transaction number: $transactionNo.");
} catch (Exception $e) {
    // Rollback transaction if an error occurs
    $conn->rollback();
    $_SESSION['error'] = $e->getMessage();
    logToDatabase("Error during transaction: " . $e->getMessage());
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Redirect to the user dashboard
header('Location: userDashboard.php');
exit;
?>
