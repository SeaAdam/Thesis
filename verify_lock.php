<?php
session_start();
require 'includes/dbconn.php';

$page_name = 'adminAccount.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_password = $_POST['password'];


    $stmt = $conn->prepare("SELECT hashed_password FROM admin_locks WHERE page_name = ?");
    $stmt->bind_param("s", $page_name);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();


    if (password_verify($entered_password, $hashed_password)) {

        $_SESSION['unlocked_pages'][$page_name] = true;
        header("Location: $page_name");
        exit;
    } else {
        $error_message = "Incorrect password. Please try again.";
    }
}
?>
