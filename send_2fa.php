<?php
session_start();
include 'includes/dbconn.php';
require 'autoloader.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userEmail = trim($_POST['userEmail']);


    $twofaCode = rand(100000, 999999); 
    $_SESSION['twofaCode'] = (string)$twofaCode; 
    $_SESSION['email'] = $userEmail;


    $mail = new PHPMailer(true);
    try {

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'adamerodagat@gmail.com'; 
        $mail->Password   = 'gnxh erjw yxfo jtdr'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;


        $mail->setFrom('adamerodagat@gmail.com', 'adameroemailer');
        $mail->addAddress($userEmail);


        $mail->isHTML(true);
        $mail->Subject = 'Your 2FA Code';
        $mail->Body    = 'Your 2FA code is: <strong>' . $twofaCode . '</strong>';

        $mail->send();


        header("Location: enter_email.php");
        exit();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>