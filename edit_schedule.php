<?php
session_start();

include 'includes/dbconn.php';

if (isset($_POST['submit'])) {
    $ID = $_POST['ID'];
    $Slots = $_POST['Slots'];
    $Slots_Date = $_POST['Slots_Date'];
    $Start_Time = $_POST['Start_Time'];
    $End_Time = $_POST['End_Time'];
    $Durations = $_POST['Durations'];

    // Update the schedule record
    $sql = "UPDATE schedule_record_table SET Slots=?, Slots_Date=?, Start_Time=?, End_Time=?, Durations=? WHERE ID=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('sssssi', $Slots, $Slots_Date, $Start_Time, $End_Time, $Durations, $ID);
        if ($stmt->execute()) {
            $_SESSION['successEditSchedule'] = "Schedule information successfully updated!";

            // Delete existing time slots for this schedule
            $delete_time_slots_query = "DELETE FROM time_slots WHERE schedule_id=?";
            if ($delete_stmt = $conn->prepare($delete_time_slots_query)) {
                $delete_stmt->bind_param('i', $ID);
                $delete_stmt->execute();
                $delete_stmt->close();
            } else {
                $_SESSION['errorEditSchedule'] = "Failed to delete existing time slots: " . $conn->error;
                header('Location: adminSchedule.php');
                exit();
            }

            // Insert updated time slots
            $start = new DateTime($Start_Time);
            $end = new DateTime($End_Time);
            $interval = new DateInterval('PT' . $Durations . 'M');

            while ($start < $end) {
                $slot_end = clone $start;
                $slot_end->add($interval);

                if ($slot_end > $end) {
                    $slot_end = $end;
                }

                $start_time_str = $start->format('H:i:s');
                $end_time_str = $slot_end->format('H:i:s');

                // Insert new time slot
                $insert_query = "INSERT INTO time_slots (start_time, end_time, schedule_id) VALUES (?, ?, ?)";
                if ($insert_stmt = $conn->prepare($insert_query)) {
                    $insert_stmt->bind_param('ssi', $start_time_str, $end_time_str, $ID);
                    $insert_stmt->execute();
                    $insert_stmt->close();
                } else {
                    $_SESSION['errorEditSchedule'] = "Failed to insert time slots: " . $conn->error;
                    header('Location: adminSchedule.php');
                    exit();
                }

                $start = $slot_end;
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