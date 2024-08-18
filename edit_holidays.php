<?php
session_start();

include 'includes/dbconn.php';

if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $holiday = $_POST['holiday'];
    $dateHolidays= $_POST['dateHolidays'];

    $sql = "UPDATE holidays SET holiday='$holiday', dateHolidays='$dateHolidays' WHERE id='$id'"; 
    if($conn->query($sql)){
        $_SESSION['successEditHolidays'] = "Client Information Successfully updated!";
    }else {
        $_SESSION['errorEditHolidays'] = $conn->error;
    }
}else {
    $_SESSION['error'] = 'Please Select First Information to Edit';
}
header('location:adminHolidays.php') ;

?>