<?php
include 'includes/dbconn.php';

$year = isset($_GET['year']) ? intval($_GET['year']) : date("Y");

$data = [
    "Q1" => 0, // January - March
    "Q2" => 0, // April - June
    "Q3" => 0, // July - September
    "Q4" => 0  // October - December
];

// Fetch quarterly accommodations with a year filter
$sqlQuarterly = "SELECT 
    CASE 
        WHEN MONTH(date_appointment) BETWEEN 1 AND 3 THEN 'Q1'
        WHEN MONTH(date_appointment) BETWEEN 4 AND 6 THEN 'Q2'
        WHEN MONTH(date_appointment) BETWEEN 7 AND 9 THEN 'Q3'
        ELSE 'Q4'
    END AS quarter,
    COUNT(*) as count
FROM client_booking
WHERE YEAR(date_appointment) = ?
GROUP BY quarter";

$stmt = $conn->prepare($sqlQuarterly);
$stmt->bind_param("i", $year);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $data[$row['quarter']] = $row['count'];
}

// Return JSON data
echo json_encode($data);
?>
