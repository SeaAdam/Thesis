<?php

include 'includes/dbconn.php';
session_start();

if (isset($_POST['submit'])) {
    $ID = $_POST['ID'];


    $conn->begin_transaction();
    try {

        $sql_account = "DELETE FROM clients_account WHERE client_id='$ID'";
        $conn->query($sql_account);


        $sql_info = "DELETE FROM clients_info WHERE id='$ID'";
        $conn->query($sql_info);


        $conn->commit();
        $_SESSION['deletedClient'] = "Record has been deleted!";
    } catch (Exception $e) {

        $conn->rollback();
        $_SESSION['errorDelete'] = "No record deleted! Error: " . $e->getMessage();
    }
} else {
    $_SESSION["error"] = "Please select first the record to delete!";
}

header("location: adminClients.php");

?>