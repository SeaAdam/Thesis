<?php
session_start();
include 'includes/dbconn.php';

$response = array('status' => '', 'message' => '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['usernameLogin']);
    $password = trim($_POST['loginPassword']);
    $loginType = $_POST['loginType'];

    if ($loginType === 'admin') {
        // Fetch admin details including ID
        $query = "SELECT ID, Username, Password FROM admin_table WHERE Username = ?";
    } else {
        // Fetch user details including ID
        $query = "SELECT ID, Username, Password FROM registration_table WHERE Username = ?";
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check if the password matches
        if ($password === $user['Password']) {
            // Store user details in session
            $_SESSION['user_id'] = $user['ID'];
            $_SESSION['username'] = $user['Username'];
            $_SESSION['loginType'] = $loginType;

            if ($loginType === 'admin') {
                // Admins are redirected to admin dashboard
                $response['status'] = 'success';
                $response['message'] = 'Successfully logged in as admin!';
                $response['redirect'] = 'adminDashboard.php';
            } else {
                // Regular users are redirected to 2FA page
                $response['status'] = 'success';
                $response['message'] = 'Redirecting to 2FA authentication...';
                $response['redirect'] = 'enter_email.php';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Invalid password.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Username not found.';
    }

    $stmt->close();
    $conn->close();
    echo json_encode($response);
    exit();
}



?>