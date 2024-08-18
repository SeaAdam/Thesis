<?php
session_start();

include 'includes/dbconn.php';

if(isset($_POST['submit'])){
    $ID = $_POST['ID'];
    $Title = $_POST['Title'];
    $Descriptions = $_POST['Descriptions'];
    $Start_dates = $_POST['Start_dates'];
    $End_date = $_POST['End_date'];

    $sql = "UPDATE events_table SET Title='$Title', Descriptions='$Descriptions', Start_dates='$Start_dates', End_date='$End_date' WHERE ID='$ID'"; 
    if($conn->query($sql)){
        $_SESSION['success'] = "Client Information Successfully updated!";
    }else {
        $_SESSION['error'] = $conn->error;
    }
}else {
    $_SESSION['error'] = 'Please Select First Information to Edit';
}
header('location:adminEvents.php') ;

?>