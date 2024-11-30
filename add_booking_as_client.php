<?php
include 'includes/dbconn.php';
session_start();

// Helper function to log messages to the database
function logToDatabase($message, $conn)
{
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

    // Check the total number of rejections for the user
    $rejectionSql = "SELECT COUNT(*) AS rejection_count FROM deleted_bookings 
    WHERE account_id = ? AND status = 'Rejected'";
    $rejectionStmt = $conn->prepare($rejectionSql);
    $rejectionStmt->bind_param('i', $account_id);
    $rejectionStmt->execute();
    $rejectionResult = $rejectionStmt->get_result();
    $row = $rejectionResult->fetch_assoc();

    // Check if there are 3 or more rejections
    if ($row['rejection_count'] >= 3) {
        logToDatabase("Booking for client ID: $account_id is disabled due to 3 or more rejections.", $conn);

        // Fetch user information to store in blocked_users
        $userSql = "SELECT username FROM clients_account WHERE client_id = ?";
        $userStmt = $conn->prepare($userSql);
        $userStmt->bind_param('i', $account_id);
        $userStmt->execute();
        $userResult = $userStmt->get_result();
        $userRow = $userResult->fetch_assoc();

        // Check if the user is already in the blocked_users table
        $checkBlockedSql = "SELECT blocked_until FROM blocked_users WHERE account_id = ? AND username = ?";
        $checkBlockedStmt = $conn->prepare($checkBlockedSql);
        $checkBlockedStmt->bind_param('is', $account_id, $userRow['username']);
        $checkBlockedStmt->execute();
        $checkBlockedResult = $checkBlockedStmt->get_result();

        // If the user is already blocked
        if ($checkBlockedResult->num_rows > 0) {
            $row = $checkBlockedResult->fetch_assoc();
            $blockedUntil = $row['blocked_until'];

            // Convert the 'blocked_until' value to a timestamp
            $blockedUntilTimestamp = strtotime($blockedUntil);

            // Check if the block period has expired
            if ($blockedUntilTimestamp > time()) {
                // Block is still active, calculate the time left
                $timeLeft = $blockedUntilTimestamp - time(); // Difference in seconds
                $minutesLeft = floor($timeLeft / 60);  // Convert to minutes
                $secondsLeft = $timeLeft % 60;         // Remaining seconds

                // Format the error message with the time left
                $_SESSION['error_message'] = "You are temporarily blocked from making bookings. Please try again in $minutesLeft minutes and $secondsLeft seconds.";
                header("Location: clientDashboard.php");
                exit();
            } else {
                // Block period expired, unblock user and delete data from deleted_bookings
                // Delete user's data from deleted_bookings
                $deleteDataSql = "DELETE FROM deleted_bookings WHERE account_id = ?";
                $deleteDataStmt = $conn->prepare($deleteDataSql);
                $deleteDataStmt->bind_param('i', $account_id);

                if ($deleteDataStmt->execute()) {
                    logToDatabase("Deleted data for unblocked user ID: $account_id from deleted_bookings.", $conn);
                } else {
                    logToDatabase("Error deleting data from deleted_bookings for user ID: $account_id.", $conn);
                }
                $deleteDataStmt->close();

                // Remove the user from the blocked_users table (unblock the user)
                $unblockSql = "DELETE FROM blocked_users WHERE account_id = ? AND username = ?";
                $unblockStmt = $conn->prepare($unblockSql);
                $unblockStmt->bind_param('is', $account_id, $userRow['username']);
                $unblockStmt->execute();
                $unblockStmt->close();
            }
        } else {
            $blockSql = "INSERT INTO blocked_users (account_id, username, reason, blocked_at, blocked_until) 
             VALUES (?, ?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 1 MINUTE))";

            $blockStmt = $conn->prepare($blockSql);
            $reason = "Blocked due to 3 rejections";
            $blockStmt->bind_param('iss', $account_id, $userRow['username'], $reason);

            if (!$blockStmt->execute()) {
                logToDatabase("Error inserting into blocked_users table: " . $blockStmt->error, $conn);
            } else {
                logToDatabase("Successfully inserted blocked user with ID: $account_id and username: " . $userRow['username'], $conn);
            }

            $blockStmt->close();

            // Set the error message and redirect to the client dashboard with a message
            $_SESSION['error_message'] = "You have reached the maximum number of rejections. You are temporarily blocked from making further bookings.";
            header("Location: clientDashboard.php");
            exit();
        }

        $checkBlockedStmt->close();
    }

    $rejectionStmt->close();


    // Delete any rejected or canceled bookings before proceeding
    $deleteSql = "SELECT * FROM client_booking WHERE account_id = ? AND date_appointment = ? AND status IN ('Rejected', 'Canceled')";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param('is', $account_id, $selectedDate);

    $deleteStmt->execute();
    $result = $deleteStmt->get_result();

    while ($row = $result->fetch_assoc()) {
        // Insert the record into the backup table before deleting it
        $backupSql = "INSERT INTO deleted_bookings (status, booking_no, services, date_appointment, date_seen, account_id, deleted_at) 
                  VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $backupStmt = $conn->prepare($backupSql);
        $backupStmt->bind_param('sssssi', $row['status'], $row['booking_no'], $row['services'], $row['date_appointment'], $row['date_seen'], $row['account_id']);

        if (!$backupStmt->execute()) {
            logToDatabase("Error inserting into deleted_bookings: " . $backupStmt->error, $conn);
            echo "Error inserting deleted booking into backup table.";
            exit();
        }
        $backupStmt->close();
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