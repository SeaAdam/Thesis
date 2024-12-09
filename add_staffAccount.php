<?php
session_start(); 

include 'includes/dbconn.php';

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$Name = $_POST['Name'];
$Username = $_POST['Username'];
$Password= $_POST['Password'];

$check_query = "SELECT * FROM staff_table WHERE Username = ?";
$check_stmt = $mysqli->prepare($check_query);
$check_stmt->bind_param("s", $Username);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    $_SESSION['errorAddUser'] = "The selected account is already in the record.";
} else {
    $query = "INSERT INTO staff_table (Name, Username, Password) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sss", $Name, $Username, $Password);

    if ($stmt->execute()) {
        $_SESSION['saveAddUser'] = "User added successfully.";
    } else {
        $_SESSION['cancelAddUser'] = "There was a problem adding the user information.";
    }

    $stmt->close();
}

$check_stmt->close();
$mysqli->close();

header('Location: staffAccount.php');
exit();
?>