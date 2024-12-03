<?php
session_start();
include 'includes/dbconn.php';
include 'notification_functions.php';

if (isset($_POST['id']) && isset($_POST['status'])) {
    $clientBookingID = $_POST['id'];
    $status = $_POST['status'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        $sql = "UPDATE appointment_system.client_booking
                SET status = ?, 
                    date_seen = NOW(),
                    reminder_time = CASE 
                        WHEN ? = 'Approved' THEN DATE_ADD(NOW(), INTERVAL 1 MINUTE) 
                        ELSE reminder_time 
                    END
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $status, $status, $clientBookingID);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Insert into appointment_reminders when the booking is approved
            if ($status == 'Approved') {
                // Set the reminder time to 1 minute from now
                $reminderTime = date('Y-m-d H:i:s', strtotime('+1 minute'));

                $sql = "INSERT INTO appointment_reminders (client_booking_id, reminder_time, account_id)
                SELECT id, reminder_time, account_id FROM client_booking WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $clientBookingID);
                $stmt->execute();


            }

            // Fetch the client details for email notification
            $sql = "SELECT account_id FROM appointment_system.client_booking WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $clientBookingID);
            $stmt->execute();
            $result = $stmt->get_result();
            $transaction = $result->fetch_assoc();
            $clientID = $transaction['account_id'];

            // Fetch the email from the clients_info table
            $sql = "SELECT email_address FROM clients_info WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $clientID);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $userEmail = $user['email_address'];

            if (!$userEmail || !filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email address.");
            }

            // Insert a notification for the client
            $notificationSql = "INSERT INTO client_notification (client_id, transaction_id, status, message, created_at) 
                                VALUES (?, ?, ?, ?, NOW())";
            $notificationStmt = $conn->prepare($notificationSql);
            $message = "Your appointment with ID $clientBookingID has been $status.";
            $notificationStmt->bind_param('iiss', $clientID, $clientBookingID, $status, $message);
            $notificationStmt->execute();

            // Send email notification about status update
            $emailSubject = "Appointment Status Updated";
            $emailMessage = "Your appointment with ID $clientBookingID has been $status.";
            if (sendEmailNotification($userEmail, $emailSubject, $emailMessage)) {
                error_log("Email sent successfully to $userEmail");
            } else {
                error_log("Failed to send email notification to $userEmail");
                throw new Exception("Error sending email notification.");
            }

            // Commit the transaction
            $conn->commit();
            echo 'Success';
        } else {
            echo 'No changes made';
        }

        $stmt->close();
    } catch (Exception $e) {
        $conn->rollback();
        error_log("Exception: " . $e->getMessage());
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'No ID or status provided';
}

$conn->close();



?>