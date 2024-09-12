<?php
// include 'includes/dbconn.php';

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Retrieve form data
//     $clientName = $_POST['clientName'];
//     $companyName = $_POST['companyName'];
//     $address = $_POST['address'];
//     $contact = $_POST['contact'];
//     $email = $_POST['email'];
//     $serviceType = $_POST['serviceType'];
//     $selectedDate = $_POST['selectedDate']; // Retrieve the selected date

//     // Generate a unique booking number in the format BOOK-XXX
//     $booking_no = 'CLT-' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);

//     // Insert data into the client_booking table
//     $sql = "INSERT INTO client_booking (status, booking_no, services, date_appointment, date_seen)
//             VALUES ('Pending', ?, ?, ?, NULL)"; // Use ? for date_appointment

//     // Prepare and bind
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param('sss', $booking_no, $serviceType, $selectedDate); // Bind the selected date

//     if ($stmt->execute()) {
//         header("Location: clientDashboard.php");
//     } else {
//         echo "Error: " . $conn->error;
//     }

//     // Close the statement and connection
//     $stmt->close();
//     $conn->close();
// } else {
//     echo "Invalid request method!";
// }

include 'includes/dbconn.php';
session_start();

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

    // Retrieve the client ID from the session
    if (isset($_SESSION['username'])) {
        $clientUsername = $_SESSION['username'];

        // Fetch the client_id from the clients_account table
        $sql = "SELECT client_id FROM clients_account WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $clientUsername);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $account_id = $row['client_id']; // Get the client ID
        } else {
            echo "Client ID not found.";
            exit();
        }
        $stmt->close();
    } else {
        echo "User not logged in.";
        exit();
    }

    // Insert data into the client_booking table including account_id
    $sql = "INSERT INTO client_booking (status, booking_no, services, date_appointment, date_seen, account_id)
            VALUES ('Pending', ?, ?, ?, NULL, ?)";

    // Prepare and bind
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssi', $booking_no, $serviceType, $selectedDate, $account_id); // Bind the account_id

    if ($stmt->execute()) {
        header("Location: clientDashboard.php");
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
