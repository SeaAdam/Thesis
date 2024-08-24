<?php
session_start();
if (!isset($_SESSION['twofaCode'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify 2FA Code</title>
</head>
<body>
    <form method="POST" action="validate_2fa.php">
        <label for="twofaCode">Enter the 2FA code sent to your email:</label>
        <input type="text" id="twofaCode" name="twofaCode" required>
        <button type="submit">Verify Code</button>
    </form>
</body>
</html>
