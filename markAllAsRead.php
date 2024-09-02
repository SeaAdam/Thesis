<?php
include 'includes/dbconn.php';

// Start a transaction
$conn->begin_transaction();

try {
    // Update all notifications to read
    $sql = "UPDATE notifications SET read_status = 1 WHERE read_status = 0";
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
