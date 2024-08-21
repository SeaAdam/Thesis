<?php
session_start(); 

include 'includes/dbconn.php';

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$FirstName = $_POST['FirstName'];
$MI = $_POST['MI'];
$LastName = $_POST['LastName'];
$Gender = $_POST['Gender'];
$DOB = $_POST['DOB'];
$Age = $_POST['Age'];
$Contact = $_POST['Contact'];
$PresentAddress = $_POST['PresentAddress'];
$Username = $_POST['Username'];
$Password = $_POST['Password'];
$ConfirmPassword = $_POST['ConfirmPassword'];

// Check if passwords match
if ($Password !== $ConfirmPassword) {
    $_SESSION['errorPasswordMatch'] = "Passwords do not match.";
    header('Location: index.php');
    exit();
}

// Validate password strength (at least 8 characters, including numbers and letters)
if (!preg_match('/^(?=.*\d)(?=.*[a-zA-Z]).{8,}$/', $Password)) {
    $_SESSION['errorPassword'] = "Password must be at least 8 characters long and contain both numbers and letters.";
    header('Location: adminPatients.php');
    exit();
}

// Check if username already exists
$check_query = "SELECT * FROM registration_table WHERE Username = ? OR (FirstName = ? AND LastName = ?)";
$check_stmt = $mysqli->prepare($check_query);
$check_stmt->bind_param("sss", $Username, $FirstName, $LastName);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    $_SESSION['errorUserAlreadyAdded'] = "The information is already registered.";
    $check_stmt->close();
    $mysqli->close();
    header('Location: adminPatients.php');
    exit();
}

$check_stmt->close();

// // Hash the password
// $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

// Insert new user into database
$query = "INSERT INTO registration_table (FirstName, MI, LastName, Gender, DOB, Age, Contact, PresentAddress, Username, Password, ConfirmPassword) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("sssssssssss", $FirstName, $MI, $LastName, $Gender, $DOB, $Age, $Contact, $PresentAddress, $Username, $Password, $ConfirmPassword);

if ($stmt->execute()) {
    $_SESSION['AddednewPatients'] = "Successfully Registered.";
} else {
    $_SESSION['cancelAddNewPatients'] = "There was a problem with registration.";
}

$stmt->close();
$mysqli->close();

header('Location: adminPatients.php');
exit();
?>
