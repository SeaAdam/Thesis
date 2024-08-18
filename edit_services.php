<?php
session_start();

include 'includes/dbconn.php';

if(isset($_POST['submit'])){
    $ID = $_POST['ID'];
    $Services = $_POST['Services'];
    $Cost= $_POST['Cost'];

    $sql = "UPDATE services_table SET Services='$Services', Cost='$Cost' WHERE ID='$ID'"; 
    if($conn->query($sql)){
        $_SESSION['successEditservices'] = "Client Information Successfully updated!";
    }else {
        $_SESSION['errorEditservices'] = $conn->error;
    }
}else {
    $_SESSION['error'] = 'Please Select First Information to Edit';
}
header('location:adminServices.php') ;

?>