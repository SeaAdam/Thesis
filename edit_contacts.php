<?php
session_start();

include 'includes/dbconn.php';

if(isset($_POST['submit'])){
    $ID = $_POST['ID'];
    $ServiceProvider= $_POST['ServiceProvider'];
    $MobileNo = $_POST['MobileNo'];

    $sql = "UPDATE contactus_table SET ServiceProvider='$ServiceProvider', MobileNo='$MobileNo' WHERE ID='$ID'"; 
    if($conn->query($sql)){
        $_SESSION['successEditContacts'] = "Client Information Successfully updated!";
    }else {
        $_SESSION['errorEditContacts'] = $conn->error;
    }
}else {
    $_SESSION['error'] = 'Please Select First Information to Edit';
}
header('location:adminContacts.php') ;

?>