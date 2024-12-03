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


$currentYear = date('Y');
$startYear = $currentYear - 5;
$endYear = $currentYear + 5;


$stmt = $pdo->query('SELECT holiday, dateHolidays FROM holidays');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $monthDay = date('m-d', strtotime($row['dateHolidays']));


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