<?php
include 'includes/dbconn.php';
session_start();

// Helper function to log messages to the database
function logToDatabase($message, $conn) {
    $sql = "INSERT INTO booking_logs (message) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $message);
    $stmt->execute();
    $stmt->close();
}

// Start logging
logToDatabase("Received POST request for client booking.", $conn);

// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Capture form data
    $clientName = $_POST['clientName'];
    $companyName = $_POST['companyName'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $serviceType = $_POST['serviceType'];
    $selectedDate = $_POST['selectedDate'];

    $booking_no = 'CLT-' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);

    // Check if user is logged in
    if (isset($_SESSION['username'])) {
        $clientUsername = $_SESSION['username'];

        logToDatabase("Checking session for username: $clientUsername", $conn);

        // Get client ID based on the username
        $sql = "SELECT client_id FROM clients_account WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $clientUsername);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $account_id = $row['client_id'];

            logToDatabase("Successfully retrieved client ID: $account_id for username: $clientUsername", $conn);
        } else {
            logToDatabase("Error: Client ID not found for username: $clientUsername", $conn);
            echo "Client ID not found.";
            exit();
        }
        $stmt->close();
    } else {
        logToDatabase("Error: User not logged in. Session 'username' not found.", $conn);
        echo "User not logged in.";
        exit();
    }

    // Delete any rejected or canceled bookings before proceeding
    $deleteSql = "DELETE FROM client_booking WHERE account_id = ? AND date_appointment = ? AND status IN ('Rejected', 'Canceled')";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param('is', $account_id, $selectedDate);

    if (!$deleteStmt->execute()) {
        logToDatabase("Error executing delete query: " . $deleteStmt->error, $conn);
        echo "Error deleting previous booking.";
        exit();
    }

    logToDatabase("Successfully deleted previous rejected/canceled booking for client ID: $account_id on date: $selectedDate", $conn);
    $deleteStmt->close();

    // Insert the new booking record into the database
    $sql = "INSERT INTO client_booking (status, booking_no, services, date_appointment, date_seen, account_id)
            VALUES (?, ?, ?, ?, NOW(), ?)";
    $stmt = $conn->prepare($sql);
    $status = 'Pending';  // Set status as Pending
    $stmt->bind_param('ssssi', $status, $booking_no, $serviceType, $selectedDate, $account_id);

    if ($stmt->execute()) {
        logToDatabase("Successfully inserted booking for client ID: $account_id with booking number: $booking_no", $conn);

        // Insert a notification for the admin
        $notificationSql = "INSERT INTO admin_notification (user_id, transaction_no, message, created_at) 
                            VALUES (?, ?, ?, NOW())";
        $notificationStmt = $conn->prepare($notificationSql);

        if (!$notificationStmt) {
            logToDatabase("Prepare failed for admin notification: " . $conn->error, $conn);
            die('Prepare failed: ' . $conn->error);
        }

        $message = "New Appointment Booking Transaction: $booking_no with client id $account_id.";
        $notificationStmt->bind_param('iss', $account_id, $booking_no, $message);

        if (!$notificationStmt->execute()) {
            logToDatabase("Error executing admin notification insert: " . $notificationStmt->error, $conn);
            die('Execute failed: ' . $notificationStmt->error);
        }

        logToDatabase("Successfully inserted admin notification for transaction: $booking_no", $conn);

        // Close database connections
        $notificationStmt->close();

        // Redirect after successful booking and notification insert
        header("Location: clientDashboard.php");
        exit();  // Ensure script terminates here after redirect
    } else {
        logToDatabase("Error executing booking insert: " . $conn->error, $conn);
        echo "Error: " . $conn->error;
        exit();
    }

    // Close the database connection
    $stmt->close();
    $conn->close();

} else {
    logToDatabase("Invalid request method. Expected POST.", $conn);
    echo "Invalid request method!";
}
?>
