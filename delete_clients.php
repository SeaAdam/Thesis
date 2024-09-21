<?php

// include 'includes/dbconn.php';
// session_start();


// if (isset($_POST['submit'])) {
//     $ID = $_POST['id'];
//     $sql = "DELETE FROM clients_info WHERE id='$ID'";
//     if ($conn->query($sql)) {
//         $_SESSION['deletedClient'] = "Record has been deleted!;";
//     } else {
//         $_SESSION['errorDelete'] = "No record deleted!;";
//     }
// } else {
//     $_SESSION["error"] = "Please select  first the record to delete!;";
// }

// header("location: adminClients.php");


include 'includes/dbconn.php';
session_start();

if (isset($_POST['submit'])) {
    $ID = $_POST['ID'];

    // Start a transaction
    $conn->begin_transaction();
    try {
        // Delete from clients_account
        $sql_account = "DELETE FROM clients_account WHERE client_id='$ID'";
        $conn->query($sql_account);

        // Delete from clients_info
        $sql_info = "DELETE FROM clients_info WHERE id='$ID'";
        $conn->query($sql_info);

        // Commit the transaction
        $conn->commit();
        $_SESSION['deletedClient'] = "Record has been deleted!";
    } catch (Exception $e) {
        // Rollback the transaction if any query fails
        $conn->rollback();
        $_SESSION['errorDelete'] = "No record deleted! Error: " . $e->getMessage();
    }
} else {
    $_SESSION["error"] = "Please select first the record to delete!";
}

header("location: adminClients.php");

?>