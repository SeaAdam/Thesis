<?php
session_start();
include 'includes/dbconn.php'; 
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$response = array('status' => '', 'message' => '');

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
            // Store username in session
            $_SESSION['username'] = $user['Username'];
            $_SESSION['loginType'] = $loginType;

            if ($loginType === 'admin') {
                // Admin login success, redirect to admin dashboard
                $response['status'] = 'success';
                $response['message'] = 'Successfully logged in as admin!';
                $response['redirect'] = 'adminDashboard.php';
            } else {
                // User login success, redirect to 2FA page
                $response['status'] = 'success';
                $response['message'] = 'Redirecting to 2FA authentication...';
                $response['redirect'] = 'enter_email.php';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Invalid password.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Username not found.';
    }

    $stmt->close();
    $conn->close();
    echo json_encode($response);
    exit();
}


?>