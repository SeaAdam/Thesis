<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Email for 2FA</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .container {
            max-width: 600px;
            margin-top: 50px;
        }

        .spinner-container {
            display: none;
            text-align: center;
            margin-top: 20px;
        }

        .error-message {
            color: red;
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div id="emailForm">
            <h2 class="text-center">Enter Email for 2FA</h2>
            <form id="send2faForm" method="POST" action="send_2fa.php">
                <div class="form-group">
                    <label for="userEmail">Enter your email address to receive the 2FA code:</label>
                    <input type="email" class="form-control" id="userEmail" name="userEmail" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Send 2FA Code</button>
            </form>
        </div>
        <div id="verifyForm" style="display: none;">
            <h2 class="text-center">Verify 2FA Code</h2>
            <form id="verify2faForm" method="POST" action="validate_2fa.php">
                <div class="form-group">
                    <label for="twofaCode">Enter the 2FA code sent to your email:</label>
                    <input type="text" class="form-control" id="twofaCode" name="twofaCode" required>
                </div>
                <button type="submit" class="btn btn-success btn-block">Verify Code</button>
            </form>
            <div class="error-message" id="errorMessage"></div>
        </div>
        <div class="spinner-container" id="loadingSpinner">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <p id="loadingMessage">Please wait...</p>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Handle form submission for sending 2FA code
        document.getElementById('send2faForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission

            // Show the loading spinner and update the message
            document.getElementById('loadingSpinner').style.display = 'block';
            document.getElementById('loadingMessage').innerText = 'Please wait, sending the code to your email...';

            // Send an AJAX request to submit the form
            var formData = new FormData(this);
            fetch('send_2fa.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(result => {
                    // Hide the loading spinner
                    document.getElementById('loadingSpinner').style.display = 'none';

                    // Show the verify form if the email was sent successfully
                    document.getElementById('emailForm').style.display = 'none';
                    document.getElementById('verifyForm').style.display = 'block';
                })
                .catch(error => {
                    // Hide the loading spinner in case of error
                    document.getElementById('loadingSpinner').style.display = 'none';
                    console.error('Error:', error);
                });
        });

        // Handle form submission for verifying 2FA code
        document.getElementById('verify2faForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission

            // Show the loading spinner and update the message
            document.getElementById('loadingSpinner').style.display = 'block';
            document.getElementById('loadingMessage').innerText = 'Logging in...';

            // Send an AJAX request to validate the 2FA code
            var formData = new FormData(this);
            fetch('validate_2fa.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(result => {
                    // Hide the loading spinner
                    document.getElementById('loadingSpinner').style.display = 'none';

                    if (result.success) {
                        // Show success SweetAlert
                        Swal.fire({
                            title: 'Success!',
                            text: '2FA verification successful. Redirecting...',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            // Redirect to the next page or login page
                            window.location.href = result.redirect || 'userDashboard.php';
                        });
                    } else {
                        if (result.redirect) {
                            // Redirect to another page if specified
                            window.location.href = result.redirect;
                        } else {
                            // Show error SweetAlert
                            Swal.fire({
                                title: 'Error!',
                                text: result.message || 'Invalid 2FA code. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'Try Again'
                            });
                        }
                    }
                })
                .catch(error => {
                    // Hide the loading spinner in case of error
                    document.getElementById('loadingSpinner').style.display = 'none';
                    console.error('Error:', error);

                    // Show error SweetAlert for unexpected errors
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong. Please try again later.',
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                });
        });


    </script>
</body>

</html>