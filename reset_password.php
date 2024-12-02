<?php
session_start();
include 'includes/dbconn.php';

$response = array('status' => '', 'message' => '');

// Check if the token is provided
if (isset($_GET['token']) && !empty($_GET['token'])) {
    $token = $_GET['token'];

    // Step 1: Validate the token and check if it is still valid (i.e., not expired)
    $query = "SELECT * FROM password_resets WHERE token = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Token found, fetch token data
        $row = $result->fetch_assoc();
        $email = $row['email'];
        $expiry = $row['expiry'];

        // Check if token has expired
        if (strtotime($expiry) > time()) {
            // Token is valid, process password reset
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Get the new password and confirm password
                $password = trim($_POST['password']);
                $confirmPassword = trim($_POST['confirm_password']);

                // Basic validation for password and confirm password
                if (empty($password) || empty($confirmPassword)) {
                    $response['status'] = 'error';
                    $response['message'] = 'Both password fields are required.';
                } elseif ($password !== $confirmPassword) {
                    $response['status'] = 'error';
                    $response['message'] = 'Passwords do not match.';
                } else {
                    // Step 2: Update both the user's password and confirm password in the registration table
                    $updateQuery = "UPDATE registration_table rt
                                    INNER JOIN user_2fa u2fa ON rt.ID = u2fa.userID
                                    SET rt.Password = ?, rt.ConfirmPassword = ?
                                    WHERE u2fa.email = ?";
                    $stmt = $conn->prepare($updateQuery);
                    $stmt->bind_param("sss", $password, $confirmPassword, $email);
                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {
                        // Step 3: Delete the reset token from the password_resets table as it's no longer needed
                        $deleteQuery = "DELETE FROM password_resets WHERE token = ?";
                        $stmt = $conn->prepare($deleteQuery);
                        $stmt->bind_param("s", $token);
                        $stmt->execute();

                        $response['status'] = 'success';
                        $response['message'] = 'Your password has been successfully updated.';
                    } else {
                        $response['status'] = 'error';
                        $response['message'] = 'An error occurred while updating your password. Please try again.';
                    }
                }
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'The reset token has expired.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Invalid or expired reset token.';
    }

    $stmt->close();
    $conn->close();
} else {
    $response['status'] = 'error';
    $response['message'] = 'No reset token provided.';
}

// Display the response
echo json_encode($response);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    
</head>

<body>
    <?php if (isset($response['message'])): ?>
        <div class="alert <?php echo $response['status'] == 'error' ? 'error' : 'success'; ?>">
            <?php echo $response['message']; ?>
        </div>
    <?php endif; ?>

    <?php if ($response['status'] == 'success'): ?>
        <!-- Redirect to login page or home after successful password reset -->
        <p><a href="login.php">Click here to log in with your new password</a></p>
    <?php else: ?>
        <!-- Password reset form -->
        <form action="reset_password.php?token=<?php echo $token; ?>" method="POST">
            <label for="password">New Password</label>
            <input type="password" name="password" id="password" required><br><br>

            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" required><br><br>

            <button type="submit">Reset Password</button>
        </form>
    <?php endif; ?>

    <script>
        document.getElementById('resetPasswordForm')?.addEventListener('submit', function (e) {
            e.preventDefault();
            const form = this;
            const submitButton = form.querySelector('button[type="submit"]');
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Resetting...';
            submitButton.disabled = true;

            const formData = new FormData(form);

            fetch('reset_password.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        window.location.href = 'index.php'; // Redirect to login
                    } else {
                        alert(data.message);
                    }
                })
                .catch(() => alert('An error occurred. Please try again.'))
                .finally(() => {
                    submitButton.innerHTML = 'Reset Password';
                    submitButton.disabled = false;
                });
        });
    </script>
</body>

</html>
