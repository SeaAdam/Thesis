<?php
session_start();
include 'includes/dbconn.php';
include_once('includes/logFunction.php');

$response = array('status' => '', 'message' => '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['usernameLogin']);
    $password = trim($_POST['loginPassword']);
    $loginType = $_POST['loginType'];

    if ($loginType === 'admin') {

        $query = "SELECT ID, Username, Password FROM admin_table WHERE Username = ?";
    } elseif ($loginType === 'clients') {
        $query = "SELECT ID, Username, Password FROM clients_account WHERE Username = ?";
    } else {

        $query = "SELECT ID, Username, Password FROM registration_table WHERE Username = ?";
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();


        if ($password === $user['Password']) {

            $_SESSION['user_id'] = $user['ID'];
            $_SESSION['username'] = $user['Username'];
            $_SESSION['loginType'] = $loginType;

            if ($loginType === 'admin') {

                $response['status'] = 'success';
                $response['message'] = 'Successfully logged in as admin!';
                $response['redirect'] = 'adminDashboard.php';
            } elseif ($loginType === 'clients') {

                $response['status'] = 'success';
                $response['message'] = 'Successfully logged in as our client!';
                $response['redirect'] = 'clientDashboard.php';
            } else {

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