<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enter Email for 2FA</title>
</head>
<body>
    <form method="POST" action="send_2fa.php">
        <label for="userEmail">Enter your email address to receive the 2FA code:</label>
        <input type="email" id="userEmail" name="userEmail" required>
        <button type="submit">Send 2FA Code</button>
    </form>
</body>
</html>
