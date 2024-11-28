<?php
include 'includes/dbconn.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $clientName = $_POST['clientName'];
    $companyName = $_POST['companyName'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $serviceType = $_POST['serviceType'];
    $selectedDate = $_POST['selectedDate'];


    $booking_no = 'CLT-' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);


    if (isset($_SESSION['username'])) {
        $clientUsername = $_SESSION['username'];


        $sql = "SELECT client_id FROM clients_account WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $clientUsername);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $account_id = $row['client_id'];
        } else {
            echo "Client ID not found.";
            exit();
        }
        $stmt->close();
    } else {
        echo "User not logged in.";
        exit();
    }


    $sql = "INSERT INTO client_booking (status, booking_no, services, date_appointment, date_seen, account_id)
            VALUES (?, ?, ?, ?, NOW(), ?)";


    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssi', $status, $booking_no, $serviceType, $selectedDate, $account_id); 

    $status= 'Pending';

    if ($stmt->execute()) {
        header("Location: clientDashboard.php");
    } else {
        echo "Error: " . $conn->error;
    }


    $notificationSql = "INSERT INTO admin_notification (user_id, transaction_no, message, created_at) VALUES (?, ?, ?, NOW())";
    $notificationStmt = $conn->prepare($notificationSql);

    if (!$notificationStmt) {
        die('Prepare failed: ' . $conn->error);
    }

    $message = "New Appointment Booking Transaction: $booking_no with client id $account_id.";
    $notificationStmt->bind_param('iss', $account_id, $booking_no, $message);

    if (!$notificationStmt->execute()) {
        die('Execute failed: ' . $notificationStmt->error);
    }

    $notificationStmt->close();


    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method!";
}



?>
