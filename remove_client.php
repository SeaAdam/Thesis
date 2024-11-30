<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'appointment_system');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request is valid
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientId = intval($_POST['id']);
    $reason = $conn->real_escape_string($_POST['reason']);

    // Fetch client details
    $query = "SELECT client_name, company_name, position FROM clients_info WHERE id = $clientId";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $client = $result->fetch_assoc();

        // Store the removal details
        $insertQuery = "INSERT INTO removed_clients (client_id, name, company, position, reason) 
                        VALUES ($clientId, '{$client['client_name']}', '{$client['company_name']}', '{$client['position']}', '$reason')";
        $conn->query($insertQuery);

        // Delete from clients_account and clients_info
        $conn->query("DELETE FROM clients_account WHERE id = $clientId");
        $conn->query("DELETE FROM clients_info WHERE id = $clientId");

        // Send success response
        echo json_encode(['status' => 'success', 'message' => 'Client removed successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Client not found.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}

$conn->close();
?>
