<?php
// session_start();
// include 'includes/dbconn.php';
// require 'autoloader.php';

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $userEmail = trim($_POST['userEmail']);


//     $twofaCode = rand(100000, 999999); 
//     $_SESSION['twofaCode'] = (string)$twofaCode; 
//     $_SESSION['email'] = $userEmail;


//     $mail = new PHPMailer(true);
//     try {

//         $mail->isSMTP();
//         $mail->Host       = 'smtp.gmail.com';
//         $mail->SMTPAuth   = true;
//         $mail->Username   = 'adamerodagat@gmail.com'; 
//         $mail->Password   = 'gnxh erjw yxfo jtdr'; 
//         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//         $mail->Port       = 587;


//         $mail->setFrom('adamerodagat@gmail.com', 'adameroemailer');
//         $mail->addAddress($userEmail);


//         $mail->isHTML(true);
//         $mail->Subject = 'Your 2FA Code';
//         $mail->Body    = 'Your 2FA code is: <strong>' . $twofaCode . '</strong>';

//         $mail->send();


//         header("Location: enter_email.php");
//         exit();
//     } catch (Exception $e) {
//         echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
//     }
// }
// session_start();
// include 'includes/dbconn.php';
// include 'notification_functions.php';

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $userEmail = trim($_POST['userEmail']);

//     // Generate and store a 2FA code
//     $twofaCode = rand(100000, 999999); // Generate a 6-digit code
//     $_SESSION['twofaCode'] = (string)$twofaCode; // Store as string
//     $_SESSION['email'] = $userEmail;

//     // Send the 2FA code via email
//     $subject = 'Your 2FA Code';
//     $message = 'Your 2FA code is: <strong>' . $twofaCode . '</strong>';

//     if (sendEmailNotification($userEmail, $subject, $message)) {
//         header("Location: enter_email.php");
//         exit();
//     } else {
//         echo "Message could not be sent. Please try again.";
//     }
// }

// session_start();
// include 'includes/dbconn.php';
// include 'notification_functions.php';

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     // Retrieve and sanitize user input
//     $userEmail = trim($_POST['userEmail']);

//     // Validate email format
//     if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
//         echo "Invalid email format.";
//         exit();
//     }

//     // Generate and store a 2FA code
//     $twofaCode = rand(100000, 999999); // Generate a 6-digit code
//     $_SESSION['twofaCode'] = (string)$twofaCode; // Store as string
//     $_SESSION['email'] = $userEmail;

//     // Prepare email details
//     $subject = 'Your 2FA Code';
//     $message = 'Your 2FA code is: <strong>' . $twofaCode . '</strong>';

//     // Send the 2FA code via email
//     if (sendEmailNotification($userEmail, $subject, $message)) {
//         // Redirect or inform the user of successful email sending
//         header("Location: enter_email.php");
//         exit();
//     } else {
//         // Error handling
//         echo "Message could not be sent. Please try again.";
//     }
// }
session_start();
include 'includes/dbconn.php';
include 'notification_functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize user input
    $userEmail = trim($_POST['userEmail']);

    // Validate email format
    if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    // Generate and store a 2FA code
    $twofaCode = rand(100000, 999999); // Generate a 6-digit code
    $_SESSION['twofaCode'] = (string) $twofaCode; // Store as string

    // Check if user ID is set in session
    if (isset($_SESSION['userID'])) {
        $userID = $_SESSION['userID'];

        // Prepare and execute query to store email and user ID
        $query = "INSERT INTO user_2fa (userID, email) VALUES (?, ?)";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("is", $userID, $userEmail);

            if ($stmt->execute()) {
                // Prepare email details
                $subject = 'Your 2FA Code';
                $message = 'Your 2FA code is: <strong>' . $twofaCode . '</strong>';

                // Send the 2FA code via email
                if (sendEmailNotification($userEmail, $subject, $message)) {
                    // Redirect or inform the user of successful email sending
                    header("Location: enter_email.php");
                    exit();
                } else {
                    // Error handling for email sending
                    echo "Message could not be sent. Please try again.";
                }
            } else {
                // Error handling for database insertion
                echo "Failed to save email in the database.";
            }
            $stmt->close();
        } else {
            echo "Failed to prepare the database statement.";
        }
    } else {
        echo "User ID not found in session.";
    }
    $conn->close();
}

?>