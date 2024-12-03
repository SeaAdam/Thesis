<?php 
include 'includes/dbconn.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total patients
$sql = "SELECT COUNT(*) as total FROM registration_table";
$result = $conn->query($sql);
$countPatient = ($result->num_rows > 0) ? $result->fetch_assoc()['total'] : 0;

// Fetch total services
$sqlServices = "SELECT COUNT(*) as total FROM services_table";
$resultServices = $conn->query($sqlServices);
$countServices = ($resultServices->num_rows > 0) ? $resultServices->fetch_assoc()['total'] : 0;

// Fetch total schedules
$sqlSchedules = "SELECT COUNT(*) as total FROM schedule_record_table";
$resultSchedules  = $conn->query($sqlSchedules);
$countSchedules = ($resultSchedules->num_rows > 0) ? $resultSchedules->fetch_assoc()['total'] : 0;

// Fetch total admin users
$sqlAdmin = "SELECT COUNT(*) as total FROM admin_table";
$resultAdmin = $conn->query($sqlAdmin);
$countAdmin = ($resultAdmin->num_rows > 0) ? $resultAdmin->fetch_assoc()['total'] : 0;

// Fetch total blocked users
$sqlBlocked = "SELECT COUNT(*) as total FROM blocked_users";
$resultBlocked = $conn->query($sqlBlocked);
$countBlocked = ($resultBlocked->num_rows > 0) ? $resultBlocked->fetch_assoc()['total'] : 0;

// Fetch total clients info
$sqlClients = "SELECT COUNT(*) as total FROM clients_info";
$resultClients = $conn->query($sqlClients);
$countClients = ($resultClients->num_rows > 0) ? $resultClients->fetch_assoc()['total'] : 0;

// Fetch total client schedules
$sqlClientSchedules = "SELECT COUNT(*) as total FROM client_schedule";
$resultClientSchedules = $conn->query($sqlClientSchedules);
$countClientSchedules = ($resultClientSchedules->num_rows > 0) ? $resultClientSchedules->fetch_assoc()['total'] : 0;

// Fetch total events
$sqlEvents = "SELECT COUNT(*) as total FROM events_table";
$resultEvents = $conn->query($sqlEvents);
$countEvents = ($resultEvents->num_rows > 0) ? $resultEvents->fetch_assoc()['total'] : 0;

// Fetch total holidays
$sqlHolidays = "SELECT COUNT(*) as total FROM holidays";
$resultHolidays = $conn->query($sqlHolidays);
$countHolidays = ($resultHolidays->num_rows > 0) ? $resultHolidays->fetch_assoc()['total'] : 0;

// Fetch total removed clients
$sqlRemovedClients = "SELECT COUNT(*) as total FROM removed_clients";
$resultRemovedClients = $conn->query($sqlRemovedClients);
$countRemovedClients = ($resultRemovedClients->num_rows > 0) ? $resultRemovedClients->fetch_assoc()['total'] : 0;

// Fetch total reviews
$sqlReviews = "SELECT COUNT(*) as total FROM reviews";
$resultReviews = $conn->query($sqlReviews);
$countReviews = ($resultReviews->num_rows > 0) ? $resultReviews->fetch_assoc()['total'] : 0;

// Close the database connection
$conn->close();
?>
