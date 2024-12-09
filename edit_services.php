<?php
session_start();

include 'includes/dbconn.php';

if(isset($_POST['submit'])){
    $ID = $_POST['ID'];
    $Services = $_POST['Services'];
    $Cost = $_POST['Cost'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $duration = $_POST['duration'];
    $slots_count = $_POST['slots_count'];
    $schedule_id = $_POST['schedule_id'];

    // Update all fields in the database
    $sql = "UPDATE services_table SET Services='$Services', Cost='$Cost', start_time='$start_time', 
            end_time='$end_time', duration='$duration', slots_count='$slots_count', schedule_id='$schedule_id' 
            WHERE ID='$ID'"; 
            
    if($conn->query($sql)){
        $_SESSION['successEditServices'] = "Service Information Successfully Updated!";
    } else {
        $_SESSION['errorEditServices'] = $conn->error;
    }
} else {
    $_SESSION['error'] = 'Please Select Information to Edit';
}
header('location: adminServices.php');
?>
