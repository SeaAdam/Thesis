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



// Fetch holidays
$stmt = $pdo->query('SELECT name, date FROM holidays');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $events[] = [
        'title' => $row['name'],
        'date' => $row['date'],
        'color' => 'gray',
        'status' => 'holiday'
    ];
}

header('Content-Type: application/json');
echo json_encode($events);
?>
