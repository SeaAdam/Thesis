<?php
session_start();

include 'includes/dbconn.php';

if (isset($_POST['submit'])) {
    $ID = $_POST['ID'];
    $FirstName = $_POST['FirstName'];
    $MI = $_POST['MI'];
    $LastName = $_POST['LastName'];
    $Gender = $_POST['Gender'];
    $DOB = $_POST['DOB'];
    $Age = $_POST['Age'];
    $Contact = $_POST['Contact'];
    $PresentAddress = $_POST['PresentAddress'];
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];
    $ConfirmPassword = $_POST['ConfirmPassword'];

    $sql = "UPDATE registration_table SET FirstName ='$FirstName', MI ='$MI', 
    LastName ='$LastName', Gender ='$Gender', 
    DOB ='$DOB', Age ='$Age', 
    Contact ='$Contact', PresentAddress ='$PresentAddress', 
    Username ='$Username', Password='$Password', ConfirmPassword ='$ConfirmPassword' WHERE ID='$ID'";
    if ($conn->query($sql)) {
        $_SESSION['successEditPatients'] = "Client Information Successfully updated!";
    } else {
        $_SESSION['errorEditPatients'] = $conn->error;
    }
} else {
    $_SESSION['error'] = 'Please Select First Information to Edit';
}
header('location:adminPatients.php');

?>