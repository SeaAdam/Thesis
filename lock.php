<?php
session_start();
include 'includes/dbconn.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredPassword = $_POST['password'];
    $pageName = 'adminAccount.php';


    $stmt = $conn->prepare("SELECT hashed_password FROM admin_locks WHERE page_name = ?");
    $stmt->bind_param("s", $pageName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['hashed_password'];


        if (password_verify($enteredPassword, $hashedPassword)) {
            $_SESSION['unlocked_pages'][$pageName] = true;
            header("Location: adminAccount.php");
            exit();
        } else {
            $error = "Incorrect password. Please try again.";
        }
    } else {
        $error = "Lock not found for the specified page.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unlock Admin Page</title>
</head>
<body>
    <h1>Unlock Admin Page</h1>
    <form method="POST" action="">
        <label for="password">Enter Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Unlock</button>
    </form>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

     <!-- Go Back Button -->
     <form action="adminDashboard.php" method="get">
        <button type="submit">Go Back</button>
    </form>
</body>
</html>
