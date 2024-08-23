<?php
$dsn = 'mysql:host=localhost;dbname=appointment_system';
$username = 'root';
$password = '';
$options = [];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

$events = [];

// Define the range of years you want the holidays to be shown (e.g., 5 years in the past and 5 years in the future)
$currentYear = date('Y');
$startYear = $currentYear - 5; // 5 years in the past
$endYear = $currentYear + 5; // 5 years in the future

// Fetch holidays
$stmt = $pdo->query('SELECT holiday, dateHolidays FROM holidays');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Extract month and day only
    $monthDay = date('m-d', strtotime($row['dateHolidays']));

    // Create an event for each year in the defined range
    for ($year = $startYear; $year <= $endYear; $year++) {
        $fullDate = $year . '-' . $monthDay;
        $events[] = [
            'title' => $row['holiday'],
            'date' => $fullDate,
            'color' => 'gray',
            'status' => 'holiday'
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($events);
?>