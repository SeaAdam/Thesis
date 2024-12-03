<?php
include 'includes/dbconn.php';

if (isset($_GET['clientId'])) {
    $clientId = $_GET['clientId'];
    

    $sql = "SELECT * FROM clients_info WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $clientId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {

        $client = $result->fetch_assoc();
        

        echo json_encode([
            'company_name' => $client['company_name'],
            'address' => $client['address'],
            'contact_number' => $client['contact_number'],
            'email_address' => $client['email_address']
        ]);
    } else {
        echo json_encode(null);
    }
} else {
    echo json_encode(null);
}
?>
