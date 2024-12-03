<?php
include 'includes/dbconn.php';
session_start();

// Get the client ID from the form (client name selection)
$clientId = $_POST['clientName'];  // Selected client ID from clients_info
$companyName = $_POST['companyName'];
$address = $_POST['address'];
$contact = $_POST['contact'];
$email = $_POST['email'];
$serviceType = $_POST['serviceType'];
$selectedDate = $_POST['selectedDate'];

// Get the client_id from clients_account based on clientId (from clients_info)
$sql = "SELECT client_id FROM clients_account WHERE client_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $clientId);  // client_id in clients_account is linked to id in clients_info
$stmt->execute();
$result = $stmt->get_result();

// Check if the client_id exists in clients_account
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $account_id = $row['client_id'];  // Use client_id as account_id for client_booking
} else {
    echo "Client not found in clients_account.";
    exit();
}

// Insert the new booking record into the client_booking table
$sql_booking = "INSERT INTO client_booking (status, booking_no, services, date_appointment, date_seen, account_id)
                VALUES (?, ?, ?, ?, NOW(), ?)";
$stmt_booking = $conn->prepare($sql_booking);

// Generate a booking number
$booking_no = 'CLT-' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);

// Set the booking status as 'Pending'
$status = 'Pending';
$stmt_booking->bind_param('ssssi', $status, $booking_no, $serviceType, $selectedDate, $account_id);  // Use account_id here

// Execute the query and check for success
if ($stmt_booking->execute()) {
    echo "Booking successful!";  // Return success message
} else {
    echo "Error: " . $stmt_booking->error;  // Return error message
}

// Close prepared statements and connection
$stmt_booking->close();
$stmt->close();
$conn->close();
?>
