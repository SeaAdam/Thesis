<?php
include 'includes/dbconn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $clientName = $_POST['clientName'];
    $companyName = $_POST['companyName'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $serviceType = $_POST['serviceType'];
    $selectedDate = $_POST['selectedDate']; // Retrieve the selected date

    // Generate a unique booking number in the format BOOK-XXX
    $booking_no = 'CLT-' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);

    // Insert data into the client_booking table
    $sql = "INSERT INTO client_booking (status, booking_no, services, date_appointment, date_seen)
            VALUES ('Pending', ?, ?, ?, NULL)"; // Use ? for date_appointment

    // Prepare and bind
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $booking_no, $serviceType, $selectedDate); // Bind the selected date

    if ($stmt->execute()) {
        echo "Booking successfully created!";
        // You can redirect to another page after successful booking
        // header("Location: success_page.php");
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method!";
}



?>
