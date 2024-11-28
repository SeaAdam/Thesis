<?php
include 'includes/dbconn.php'; 

$defaultPassword = '123123'; 

$hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);


$pageName = 'adminAccount.php';


$stmt = $conn->prepare("INSERT INTO admin_locks (page_name, hashed_password) VALUES (?, ?)");
$stmt->bind_param("ss", $pageName, $hashedPassword);


if ($stmt->execute()) {
    echo "Default password has been securely stored in the database!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
?>
