<?php


























session_start();
include 'includes/dbconn.php';

if (isset($_POST['submit'])) {

    $ID = $_POST['ID'];
    $client_name = $_POST['client_name'];
    $company_name = $_POST['company_name'];
    $position = $_POST['position'];
    $address = $_POST['address'];
    $contact_number = $_POST['contact_number'];
    $email_address = $_POST['email_address'];


    $Username = $_POST['Username']; 
    $Password = $_POST['Password'];


    $conn->begin_transaction();

    try {

        $sql1 = "UPDATE clients_info SET client_name ='$client_name', company_name='$company_name', 
        position ='$position', address='$address', contact_number ='$contact_number', 
        email_address ='$email_address' WHERE id='$ID'";
        if (!$conn->query($sql1)) {
            throw new Exception($conn->error);
        }


        $sql2 = "UPDATE clients_account SET Username='$Username', Password='$Password' WHERE client_id='$ID'";
        if (!$conn->query($sql2)) {
            throw new Exception($conn->error);
        }


        $conn->commit();
        $_SESSION['successEditClient'] = "Client Information and Account Successfully updated!";
    } catch (Exception $e) {

        $conn->rollback();
        $_SESSION['errorEditClient'] = "Error updating client info: " . $e->getMessage();
    }
} else {
    $_SESSION['error'] = 'Please Select Information to Edit First';
}

header('location:adminClients.php');

?>