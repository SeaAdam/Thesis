<?php
session_start();
include 'includes/dbconn.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['usernameLogin']);
    $password = trim($_POST['loginPassword']);
    $loginType = $_POST['loginType']; 

    
    if ($loginType === 'admin') {
        $query = "SELECT Username, Password FROM admin_table WHERE Username = ?";
    } else {
        $query = "SELECT Username, Password FROM registration_table WHERE Username = ?";
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check if the password matches
        if ($password === $user['Password']) { 
            if ($loginType === 'admin') {
                $_SESSION['adminUsername'] = $user['Username'];
                header("Location: adminDashboard.php");
            } else {
                $_SESSION['username'] = $user['Username'];
                header("Location: userDashboard.php");
            }
            exit();
        } else {
            
            $_SESSION['error'] = "Invalid password.";
            header("Location: loginS.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Username not found.";
        header("Location: logins.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>