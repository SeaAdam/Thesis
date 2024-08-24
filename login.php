<?php
session_start();
include 'includes/dbconn.php'; 
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['usernameLogin']);
    $password = trim($_POST['loginPassword']);
    $loginType = $_POST['loginType']; 

    if ($loginType === 'admin') {
        $query = "SELECT Username, Password FROM admin_table WHERE Username = ?";
    } else {
        $query = "SELECT Username, Password FROM registration_table WHERE Username = ?";
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check if the password matches (no hashing involved)
        if ($password === $user['Password']) {
            // Store username in session and redirect to email input page
            $_SESSION['username'] = $user['Username'];
            $_SESSION['loginType'] = $loginType;
            header("Location: enter_email.php");
            exit();
        } else {
            $_SESSION['InvalidPass'] = "Invalid password.";
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['InvalidUser'] = "Username not found.";
        header("Location: index.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}

?>