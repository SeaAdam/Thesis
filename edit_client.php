<?php
// session_start();

// include 'includes/dbconn.php';

// if (isset($_POST['submit'])) {
//     $ID = $_POST['ID'];
//     $client_name = $_POST['client_name'];
//     $company_name = $_POST['company_name'];
//     $position = $_POST['position'];
//     $address = $_POST['address'];
//     $contact_number = $_POST['contact_number'];
//     $email_address = $_POST['email_address'];

//     $sql = "UPDATE clients_info SET client_name ='$client_name', company_name='$company_name', 
//     position ='$position', address='$address', 
//     contact_number ='$contact_number', email_address ='$email_address' WHERE id='$ID'";
//     if ($conn->query($sql)) {
//         $_SESSION['successEditClient'] = "Client Information Successfully updated!";
//     } else {
//         $_SESSION['errorEditClient'] = $conn->error;
//     }
// } else {
//     $_SESSION['error'] = 'Please Select First Information to Edit';
// }
// header('location:adminClients.php');

session_start();
include 'includes/dbconn.php';

if (isset($_POST['submit'])) {
    // Get posted data from the form
    $ID = $_POST['ID'];
    $client_name = $_POST['client_name'];
    $company_name = $_POST['company_name'];
    $position = $_POST['position'];
    $address = $_POST['address'];
    $contact_number = $_POST['contact_number'];
    $email_address = $_POST['email_address'];

    // Data for the clients_account table
    $Username = $_POST['Username']; 
    $Password = $_POST['Password']; // Unhashed password

    // Start a transaction to ensure both updates happen together
    $conn->begin_transaction();

    try {
        // Update clients_info table
        $sql1 = "UPDATE clients_info SET client_name ='$client_name', company_name='$company_name', 
        position ='$position', address='$address', contact_number ='$contact_number', 
        email_address ='$email_address' WHERE id='$ID'";
        if (!$conn->query($sql1)) {
            throw new Exception($conn->error);
        }

        // Update clients_account table for Username and Password (without hashing the password)
        $sql2 = "UPDATE clients_account SET Username='$Username', Password='$Password' WHERE client_id='$ID'";
        if (!$conn->query($sql2)) {
            throw new Exception($conn->error);
        }

        // Commit the transaction if both queries succeeded
        $conn->commit();
        $_SESSION['successEditClient'] = "Client Information and Account Successfully updated!";
    } catch (Exception $e) {
        // Rollback the transaction if any query fails
        $conn->rollback();
        $_SESSION['errorEditClient'] = "Error updating client info: " . $e->getMessage();
    }
} else {
    $_SESSION['error'] = 'Please Select Information to Edit First';
}

header('location:adminClients.php');

?>