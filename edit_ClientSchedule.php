<?php
session_start();

include 'includes/dbconn.php';

if(isset($_POST['submit'])){
    $id = $_POST['ID'];
    $schedule_date= $_POST['schedule_date'];

    $sql = "UPDATE client_schedule SET schedule_date='$schedule_date' WHERE id='$id'"; 
    if($conn->query($sql)){
        $_SESSION['successEditClientSchedule'] = "Client Information Successfully updated!";
    }else {
        $_SESSION['errorEditCliientSchedule'] = $conn->error;
    }
}else {
    $_SESSION['error'] = 'Please Select First Information to Edit';
}
header('location:clientSchedule.php') ;

?>