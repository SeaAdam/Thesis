<?php

include 'includes/dbconn.php';
session_start();

if (isset($_POST['submit'])) {
    $ID = $_POST['ID'];

    if (!$ID) {
        $_SESSION['errorDelete'] = "No record selected for deletion.";
        header("location: adminSchedule.php");
        exit();
    }

    // Begin transaction
    $conn->begin_transaction();
    
    try {
        // Delete time slots associated with the schedule
        $delete_time_slots_sql = "DELETE FROM time_slots WHERE schedule_id = ?";
        $stmt = $conn->prepare($delete_time_slots_sql);
        $stmt->bind_param("i", $ID);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete time slots: " . $stmt->error);
        }

        // Delete the schedule record
        $delete_schedule_sql = "DELETE FROM schedule_record_table WHERE ID = ?";
        $stmt = $conn->prepare($delete_schedule_sql);
        $stmt->bind_param("i", $ID);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete schedule: " . $stmt->error);
        }

        // Commit transaction
        $conn->commit();
        $_SESSION['deleted'] = "Record and its associated time slots have been deleted!";
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        $_SESSION['errorDelete'] = "Error deleting record: " . $e->getMessage();
    }

    // Close the statement
    $stmt->close();
} else {
    $_SESSION["error"] = "Please select the record to delete first!";
}

header("location: adminSchedule.php");
exit();


?>