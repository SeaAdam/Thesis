<?php
session_start();
include 'includes/dbconn.php';
include 'notification_functions.php';

if (isset($_POST['id']) && isset($_POST['status'])) {
    $transactionId = $_POST['id'];
    $status = $_POST['status'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Update the transaction status and set the current date and time for date_seen
        $sql = "UPDATE appointment_system.transactions 
                SET status = ?, date_seen = NOW() 
                WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $status, $transactionId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Fetch user_id for the notification
            $sql = "SELECT user_id FROM appointment_system.transactions WHERE ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $transactionId);
            $stmt->execute();
            $result = $stmt->get_result();
            $transaction = $result->fetch_assoc();
            $userId = $transaction['user_id'];

            // Fetch the email from user_2fa table
            $sql = "SELECT email FROM user_2fa WHERE userID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $userEmail = $user['email'];

            if (!$userEmail || !filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email address.");
            }

            // Insert a notification into the notifications table
            $notificationSql = "INSERT INTO notifications (user_id, transaction_id, status, message, created_at) 
                                VALUES (?, ?, ?, ?, NOW())";
            $notificationStmt = $conn->prepare($notificationSql);
            $message = "Your appointment with ID $transactionId has been $status.";
            $notificationStmt->bind_param('iiss', $userId, $transactionId, $status, $message);
            $notificationStmt->execute();

            // Send email notification
            $emailSubject = "Appointment Status Updated";
            $emailMessage = "Your appointment with ID $transactionId has been $status.";

            // Add the additional message if status is 'Completed'
            if ($status === 'Completed') {
                // Calculate the exact date and time for picking up the documents (2 working days)
                $pickupDate = new DateTime();
                $pickupDate->modify('+2 weekdays'); // Adds 2 working days

                // Format the date and time
                $pickupDateFormatted = $pickupDate->format('l, F j, Y \a\t g:i A');  // Example: Monday, December 4, 2024 at 3:00 PM

                $emailMessage = "
                    <p>Dear Patient,</p>
                    <p>Thank you for using our appointment system. Your appointment with ID $transactionId has been marked as <strong>Completed</strong>.</p>
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
                throw new Exception("Error sending email notification.");
            }

            // Insert reminder logic
            $sql = "SELECT date_seen FROM appointment_system.transactions WHERE ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $transactionId);
            $stmt->execute();
            $result = $stmt->get_result();
            $transaction = $result->fetch_assoc();
            $dateSeen = $transaction['date_seen'];

            // Calculate reminder_time (1 minute after date_seen)
            $reminderTime = date('Y-m-d H:i:s', strtotime($dateSeen . ' +1 minute'));

            // Insert into user_appointment_reminders table
            $reminderSql = "INSERT INTO user_appointment_reminders (transaction_id, user_id, reminder_time) 
                            VALUES (?, ?, ?)";
            $reminderStmt = $conn->prepare($reminderSql);
            $reminderStmt->bind_param('iis', $transactionId, $userId, $reminderTime);
            $reminderStmt->execute();

            // Additional logic if status is 'Completed' or 'Rejected'
            if ($status === 'Rejected') {
                
                $sql = "SELECT service_id  FROM appointment_system.transactions WHERE ID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $transactionId);
                $stmt->execute();
                $result = $stmt->get_result();
                $transaction = $result->fetch_assoc();

                if ($transaction) {
                    $serviceType = $transaction['service_id'];

                    // Increment the slots for the corresponding schedule
                    $sql = "UPDATE services_table
                            SET slots_count = slots_count + 1 
                            WHERE ID = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('i', $serviceType);
                    $stmt->execute();
                }
            }

            // Commit the transaction
            $conn->commit();
            echo 'Success';
        } else {
            echo 'No changes made';
        }

        // Close all statements
        $stmt->close();
        $notificationStmt->close();
        $reminderStmt->close();
    } catch (Exception $e) {
        // Rollback transaction in case of errors
        $conn->rollback();
        error_log("Exception: " . $e->getMessage());
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'No ID or status provided';
}

// Close the database connection
$conn->close();
?>
