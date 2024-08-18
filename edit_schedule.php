<?php
session_start();

include 'includes/dbconn.php';

if(isset($_POST['submit'])){
    $ID = $_POST['ID'];
    $Slots = $_POST['Slots'];
    $Slots_Date = $_POST['Slots_Date'];
    $Start_Time = $_POST['Start_Time'];
    $End_Time = $_POST['End_Time'];
    $Durations = $_POST['Durations'];

    $sql = "UPDATE schedule_record_table SET Slots='$Slots', Slots_Date='$Slots_Date', Start_Time='$Start_Time', End_Time='$End_Time', Durations='$Durations' WHERE ID='$ID'"; 
    if($conn->query($sql)){
        $_SESSION['successEditSchedule'] = "Client Information Successfully updated!";
    }else {
        $_SESSION['errorEditSchedule'] = $conn->error;
    }
}else {
    $_SESSION['error'] = 'Please Select First Information to Edit';
}
header('location:adminSchedule.php') ;

?>