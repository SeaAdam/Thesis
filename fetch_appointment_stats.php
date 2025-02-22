<?php
include 'includes/dbconn.php';

$data = [
    "daily" => [],
    "monthly" => []
];

// Fetch daily accommodations
$sqlDaily = "SELECT DATE(date_appointment) as date, COUNT(*) as count FROM client_booking GROUP BY DATE(date_appointment)";
$resultDaily = $conn->query($sqlDaily);
while ($row = $resultDaily->fetch_assoc()) {
    $data["daily"][] = $row;
}

// Fetch monthly accommodations
$sqlMonthly = "SELECT DATE_FORMAT(date_appointment, '%Y-%m') as month, COUNT(*) as count FROM client_booking GROUP BY DATE_FORMAT(date_appointment, '%Y-%m')";
$resultMonthly = $conn->query($sqlMonthly);
while ($row = $resultMonthly->fetch_assoc()) {
    $data["monthly"][] = $row;
}

// Return JSON data
echo json_encode($data);
?>
