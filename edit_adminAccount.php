<?php
session_start();

include 'includes/dbconn.php';

if (isset($_POST['submit'])) {
    $ID = $_POST['ID'];
    $Name = $_POST['Name'];
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];

    $sql = "UPDATE admin_table SET Name='$Name', Username='$Username', Password='$Password' WHERE ID='$ID'";
    if ($conn->query($sql)) {
        $_SESSION['successEditUser'] = "Client Information Successfully updated!";
    } else {
        $_SESSION['errorEditUser'] = $conn->error;
    }
} else {
    $_SESSION['error'] = 'Please Select First Information to Edit';
}
header('location:adminAccount.php');

?>