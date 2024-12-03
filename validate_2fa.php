<?php
session_start();
header('Content-Type: application/json');

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inputCode = trim($_POST['twofaCode']);

    if (!isset($_SESSION['twofaCode'])) {
        $response['message'] = "Session expired. Please request a new code.";
        echo json_encode($response);
        exit();
    }

    $storedCode = $_SESSION['twofaCode'];


    if (!isset($_SESSION['failedAttempts'])) {
        $_SESSION['failedAttempts'] = 0;
    }

    if ((string)$inputCode === $storedCode) {

        $response['success'] = true;
        $response['message'] = "2FA code verified successfully!";
        $response['redirect'] = 'userDashboard.php';
        unset($_SESSION['twofaCode']);
        unset($_SESSION['failedAttempts']);
    } else {
        $_SESSION['failedAttempts']++;
        
        $remainingAttempts = 5 - $_SESSION['failedAttempts'];

        if ($_SESSION['failedAttempts'] >= 5) {

            $response['message'] = "Too many failed attempts. You will be redirected to the home page.";
            $response['redirect'] = 'too_many_attempts.php';
        } else {
            $response['message'] = "Invalid 2FA code. You have $remainingAttempts attempts remaining.";
        }
    }

    echo json_encode($response);
}



?>
