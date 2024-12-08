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


    $conn->begin_transaction();
    
    try {

        $delete_schedule_sql = "DELETE FROM schedule_record_table WHERE ID = ?";
        $stmt = $conn->prepare($delete_schedule_sql);
        $stmt->bind_param("i", $ID);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete schedule: " . $stmt->error);
        }


        $conn->commit();
        $_SESSION['deleted'] = "Record and its associated time slots have been deleted!";
    } catch (Exception $e) {

        $conn->rollback();
        $_SESSION['errorDelete'] = "Error deleting record: " . $e->getMessage();
    }


    $stmt->close();
} else {
    $_SESSION["error"] = "Please select the record to delete first!";
}

header("location: adminSchedule.php");
exit();


?>