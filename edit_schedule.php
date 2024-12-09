<?php
session_start();

include 'includes/dbconn.php';

if (isset($_POST['submit'])) {
    $ID = $_POST['ID'];
    $Slots_Date = $_POST['Slots_Date'];

    // Update schedule record table
    $sql = "UPDATE schedule_record_table SET Slots_Date=? WHERE ID=?";
    if ($stmt = $conn->prepare($sql)) {
        // Corrected bind_param to bind both Slots_Date and ID
        $stmt->bind_param('si', $Slots_Date, $ID); // 's' for string (Slots_Date), 'i' for integer (ID)
        if ($stmt->execute()) {
            $_SESSION['successEditSchedule'] = "Schedule information successfully updated!";

            // Delete existing time slots for the schedule
            $delete_time_slots_query = "DELETE FROM time_slots WHERE schedule_id=?";
            if ($delete_stmt = $conn->prepare($delete_time_slots_query)) {
                $delete_stmt->bind_param('i', $ID); // Bind integer parameter for schedule_id
                if ($delete_stmt->execute()) {
                    $delete_stmt->close();
                } else {
                    $_SESSION['errorEditSchedule'] = "Failed to delete existing time slots: " . $conn->error;
                    header('Location: adminSchedule.php');
                    exit();
                }
            } else {
                $_SESSION['errorEditSchedule'] = "Failed to prepare delete statement: " . $conn->error;
                header('Location: adminSchedule.php');
                exit();
            }
        } else {
            $_SESSION['errorEditSchedule'] = "Failed to update schedule: " . $conn->error;
        }
        $stmt->close();
    } else {
        $_SESSION['errorEditSchedule'] = "Failed to prepare update statement: " . $conn->error;
    }
} else {
    $_SESSION['error'] = 'Please select the information to edit.';
}

header('Location: adminSchedule.php');
exit();
?>
