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

    // Track failed attempts
    if (!isset($_SESSION['failedAttempts'])) {
        $_SESSION['failedAttempts'] = 0;
    }

    if ((string)$inputCode === $storedCode) {
        // Code matches, proceed with login or redirect
        $response['success'] = true;
        $response['message'] = "2FA code verified successfully!";
        $response['redirect'] = 'userDashboard.php'; // Redirect to dashboard
        unset($_SESSION['twofaCode']);
        unset($_SESSION['failedAttempts']); // Reset failed attempts on success
    } else {
        $_SESSION['failedAttempts']++;
        
        $remainingAttempts = 5 - $_SESSION['failedAttempts'];

        if ($_SESSION['failedAttempts'] >= 5) {
            // Redirect to too_many_attempts.php after 5 failed attempts
            $response['message'] = "Too many failed attempts. You will be redirected to the home page.";
            $response['redirect'] = 'too_many_attempts.php'; // Redirect to the "too many attempts" page
        } else {
            $response['message'] = "Invalid 2FA code. You have $remainingAttempts attempts remaining.";
        }
    }

    echo json_encode($response);
}



?>
