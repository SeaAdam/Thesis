<?php

include 'includes/dbconn.php';
session_start();


if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM holidays WHERE id='$id'";
    if ($conn->query($sql)) {
        $_SESSION['deleted'] = "Record has been deleted!;";
    } else {
        $_SESSION['errorDelete'] = "No record deleted!;";
    }
} else {
    $_SESSION["error"] = "Please select  first the record to delete!;";
}

header("location: adminHolidays.php");
?>