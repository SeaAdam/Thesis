<?php
session_start();
include 'includes/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inputCode = trim($_POST['twofaCode']);

    if (!isset($_SESSION['twofaCode'])) {
        echo "Session expired. Please request a new code.";
        exit();
    }

    $storedCode = $_SESSION['twofaCode'];

    if ((string)$inputCode === $storedCode) {
        // Code matches, proceed with login or redirect
        echo "2FA code verified successfully!";
        // Optionally, clear the 2FA code from session after successful validation
        unset($_SESSION['twofaCode']);
        header("Location: userDashboard.php");
        exit();
    } else {
        echo '<p style="color:red;">Invalid 2FA code. Please try again.</p>';
    }
}
?>
