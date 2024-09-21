<?php

include 'includes/dbconn.php';
session_start();


if (isset($_POST['submit'])) {
    $id = $_POST['ID'];
    $sql = "DELETE FROM client_schedule WHERE id='$id'";
    if ($conn->query($sql)) {
        $_SESSION['deletedClientSchedule'] = "Record has been deleted!;";
    } else {
        $_SESSION['errorDelete'] = "No record deleted!;";
    }
} else {
    $_SESSION["error"] = "Please select  first the record to delete!;";
}

header("location: clientSchedule.php");
?>