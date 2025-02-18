<?php
include 'includes/dbconn.php';

if (isset($_GET['transaction_id'])) {
    $transactionId = $_GET['transaction_id'];

    // Query to get the service for the specific transaction
    $sql = "SELECT s.ID AS service_id, s.Services AS service_name
            FROM appointment_system.transactions t
            LEFT JOIN appointment_system.services_table s ON t.service_id = s.ID
            WHERE t.ID = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $transactionId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = [];
    if ($row = $result->fetch_assoc()) {
        $data = ['service_id' => $row['service_id'], 'service_name' => $row['service_name']];
    }

    echo json_encode($data);
    $stmt->close();
    $conn->close();
}
?>
