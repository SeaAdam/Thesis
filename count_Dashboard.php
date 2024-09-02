<?php 
include 'includes/dbconn.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT COUNT(*) as total FROM registration_table";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $countPatient = $row['total'];
} else {
    $countPatient = 0;
}

$sqlServices = "SELECT COUNT(*) as total FROM services_table";
$resultServices = $conn->query($sqlServices);

if ($resultServices->num_rows > 0) {
    $rowServices = $resultServices->fetch_assoc();
    $countServices = $rowServices['total'];
} else {
    $countServices = 0;
}

$sqlServices = "SELECT COUNT(*) as total FROM services_table";
$resultServices = $conn->query($sqlServices);

if ($resultServices->num_rows > 0) {
    $rowServices = $resultServices->fetch_assoc();
    $countServices = $rowServices['total'];
} else {
    $countServices = 0;
}

$sqlSchedules = "SELECT COUNT(*) as total FROM schedule_record_table";
$resultSchedules  = $conn->query($sqlSchedules);

if ($resultSchedules ->num_rows > 0) {
    $rowSchedules  = $resultSchedules ->fetch_assoc();
    $countSchedules  = $rowSchedules ['total'];
} else {
    $countSchedules  = 0;
}


$conn->close();


?>