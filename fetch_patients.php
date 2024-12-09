<?php
include 'includes/dbconn.php';

header('Content-Type: application/json');

// Fetch patients from the database
$query = "SELECT ID, CONCAT(FirstName, ' ', MI, ' ', LastName) AS fullName FROM registration_table";
$stmt = $conn->prepare($query);
$stmt->execute();
$stmt->bind_result($id, $name);

$patients = [];
while ($stmt->fetch()) {
    $patients[] = ['ID' => $id, 'fullName' => $name];
}

echo json_encode($patients);

$stmt->close();
$conn->close();
?>
