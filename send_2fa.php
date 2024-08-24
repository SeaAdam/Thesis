<?php
session_start();
include 'includes/dbconn.php';
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userEmail = trim($_POST['userEmail']);

    // Generate and store a 2FA code
    $twofaCode = rand(100000, 999999); // Generate a 6-digit code
    $_SESSION['twofaCode'] = (string)$twofaCode; // Store as string
    $_SESSION['email'] = $userEmail;

    // Send the 2FA code via email using Gmail SMTP
    $mail = new PHPMailer(true);
    try {
        // Gmail settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'adamerodagat@gmail.com'; // Replace with your Gmail address
        $mail->Password   = 'gnxh erjw yxfo jtdr'; // Replace with your app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('adamerodagat@gmail.com', 'adameroemailer');
        $mail->addAddress($userEmail);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your 2FA Code';
        $mail->Body    = 'Your 2FA code is: <strong>' . $twofaCode . '</strong>';

        $mail->send();

        // Redirect to 2FA verification page
        header("Location: enter_email.php");
        exit();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
