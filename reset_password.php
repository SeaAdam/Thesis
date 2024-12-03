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


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Brain Master Diagnostic Center Appointment System</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 50px;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            max-width: 400px;
            width: 100%;
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.5em;
            color: #333;
        }

        .alert {
            margin-bottom: 20px;
            padding: 12px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }

        .alert.success {
            background-color: #28a745;
            color: white;
        }

        .alert.error {
            background-color: #dc3545;
            color: white;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        label {
            font-size: 0.9em;
            color: #555;
            display: block;
            margin-bottom: 8px;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 12px;
            width: 100%;
            font-size: 1em;
            color: #495057;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            outline: none;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #007bff;
        }

        button[type="submit"] {
            width: 100%;
            padding: 14px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        button[type="submit"]:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #007bff;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        .password-help {
            font-size: 0.8em;
            color: #6c757d;
            margin-top: 5px;
        }
    </style>

</head>

<body>
    <div class="container">
        <h2>Reset Password | Brain Master Diagnostic Center Appointment System</h2>

        <?php if (isset($response['message'])): ?>
            <div class="alert <?php echo $response['status'] == 'error' ? 'error' : 'success'; ?>">
                <?php echo $response['message']; ?>
            </div>
        <?php endif; ?>

        <?php if ($response['status'] == 'success'): ?>
            <!-- Redirect to login page or home after successful password reset -->
            <p class="back-link"><a href="index.php">Click here to log in with your new password</a></p>
        <?php else: ?>
            <!-- Password reset form -->
            <form action="reset_password.php?token=<?php echo $token; ?>" method="POST">
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    <span class="password-toggle" onclick="togglePasswordVisibility('password')">👁️</span>
                    <div class="password-help">Password must be at least 8 characters, include at least one uppercase
                        letter, one number, and one special character.</div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                    <span class="password-toggle" onclick="togglePasswordVisibility('confirm_password')">👁️</span>
                </div>

                <button type="submit">Reset Password</button>
            </form>
        <?php endif; ?>
    </div>

    <script>
        // Toggle password visibility
        function togglePasswordVisibility(id) {
            const passwordField = document.getElementById(id);
            const icon = passwordField.nextElementSibling;
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.textContent = '🙈'; // Change to "Hide" icon
            } else {
                passwordField.type = 'password';
                icon.textContent = '👁️'; // Change to "Show" icon
            }
        }

        // Password validation
        function validatePassword(password, confirmPassword) {
            const regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            if (!regex.test(password)) {
                alert("Password must be at least 8 characters long, contain one uppercase letter, one number, and one special character.");
                return false;
            }

            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }

            return true;
        }

        // Form submission with AJAX
        document.getElementById('resetPasswordForm')?.addEventListener('submit', function (e) {
            e.preventDefault();
            const form = this;
            const submitButton = form.querySelector('button[type="submit"]');
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Resetting...';
            submitButton.disabled = true;

            const password = form.querySelector('#password').value;
            const confirmPassword = form.querySelector('#confirm_password').value;

            if (!validatePassword(password, confirmPassword)) {
                submitButton.innerHTML = 'Reset Password';
                submitButton.disabled = false;
                return;
            }

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