<?php

include 'includes/dbconn.php';
session_start();


if (isset($_POST['submit'])) {
    $ID = $_POST['ID'];
    $sql = "DELETE FROM registration_table WHERE ID='$ID'";
    if ($conn->query($sql)) {
        $_SESSION['deletedPatients'] = "Record has been deleted!;";
    } else {
        $_SESSION['errorDelete'] = "No record deleted!;";
    }
} else {
    $_SESSION["error"] = "Please select  first the record to delete!;";
}

header("location: adminPatients.php");
?>