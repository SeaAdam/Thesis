<?php
include 'includes/dbconn.php';
include 'notification_functions.php';

if (isset($_POST['bookingId']) && isset($_POST['action'])) {
    $bookingId = $_POST['bookingId'];
    $action = $_POST['action'];

    // Determine the status based on the action
    if ($action === 'accept') {
        $status = 'Accepted';
    } elseif ($action === 'reject') {
        $status = 'Rejected';
    } elseif ($action === 'complete') {
        $status = 'Completed';
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid action!']);
        exit;
    }

    // Update the booking status
    $query = "UPDATE bookings_table SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(['success' => false, 'error' => 'Database prepare failed']);
        exit;
    }

    $stmt->bind_param("si", $status, $bookingId);

    if ($stmt->execute()) {
        // Fetch user_id for the notification
        $sql = "SELECT user_id FROM bookings_table WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $bookingId);
        $stmt->execute();
        $result = $stmt->get_result();
        $booking = $result->fetch_assoc();
        $userId = $booking['user_id'];

        // Fetch the email from user_2fa table
        $sql = "SELECT email FROM user_2fa WHERE userID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $userEmail = $user['email'];

        if (!$userEmail || !filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'error' => 'Invalid email address.']);
            exit;
        }

        // Insert a notification into the notifications table
        $notificationSql = "INSERT INTO notifications (user_id, transaction_id, status, message, created_at) 
                            VALUES (?, ?, ?, ?, NOW())";
        $notificationStmt = $conn->prepare($notificationSql);
        $message = "Your booking with ID $bookingId has been $status.";
        $notificationStmt->bind_param('iiss', $userId, $bookingId, $status, $message);
        $notificationStmt->execute();

        // Send email notification
        $emailSubject = "Booking Status Updated";
        $emailMessage = "Your booking with ID $bookingId has been $status.";

        // Add the additional message if status is 'Completed'
        if ($status === 'Completed') {
            // Calculate the exact date and time for picking up the documents (2 working days)
            $pickupDate = new DateTime();
            $pickupDate->modify('+2 weekdays'); // Adds 2 working days

            // Format the date and time
            $pickupDateFormatted = $pickupDate->format('l, F j, Y \a\t g:i A');  // Example: Monday, December 4, 2024 at 3:00 PM

            $emailMessage = "
                <p>Dear Patient,</p>
                <p>Thank you for using our booking system. Your booking with ID $bookingId has been marked as <strong>Completed</strong>.</p>
                <p>We are pleased to inform you that the result or hard copy of your files will be available in 2 working days from the date and time you received this email.</p>
                <p>You can pick up the documents at our office on <strong>$pickupDateFormatted</strong>.</p>
                <p><strong>Location:</strong> 303, Sujeco Building, 1754 E Rodriguez Sr. Ave, Immaculate Conception, Quezon City, 1111 Metro Manila.</p>
                <p><strong>Office Hours:</strong> Mon-Fri 8am-5pm (Sun Closed).</p>
                <p>We look forward to serving you again!</p>
                <p>Best regards,</p>
                <p>Brain Master Diagnostic Center</p>
            ";
        }

        if (sendEmailNotification($userEmail, $emailSubject, $emailMessage)) {
            error_log("Email sent successfully to $userEmail");
        } else {
            error_log("Failed to send email notification to $userEmail");
        }

        echo json_encode(['success' => true, 'message' => 'Booking status updated']);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $notificationStmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
}

$conn->close();
?>