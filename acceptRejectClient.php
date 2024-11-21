<?php
session_start();
include 'includes/dbconn.php';

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];

    if ($action == 'accept') {
        $query = "UPDATE clients_info SET status = 'accepted' WHERE id = ?";
    } elseif ($action == 'reject') {
        $query = "UPDATE clients_info SET status = 'rejected' WHERE id = ?";
    } else {
        $_SESSION['error'] = "Invalid action.";
        header('Location: adminClients.php');
        exit();
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Client status updated successfully.";
    } else {
        $_SESSION['error'] = "Error updating client status.";
    }

    $stmt->close();
    header('Location: adminClients.php');
    exit();
}

$conn->close();
?>
