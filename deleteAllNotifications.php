<?php
include 'includes/dbconn.php';

// Start a transaction
$conn->begin_transaction();

try {
    // Delete all notifications
    $sql = "DELETE FROM notifications";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $conn->commit();
    echo 'Success';
} catch (Exception $e) {
    $conn->rollback();
    echo 'Error: ' . $e->getMessage();
}

$stmt->close();
$conn->close();
?>
