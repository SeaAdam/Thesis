<?php
include 'includes/dbconn.php';

if (isset($_GET['id'])) {
    $client_id = $_GET['id'];

    // Fetch client details
    $sql = "SELECT * FROM clients_info WHERE id = $client_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Generate a username and password (avoid spaces in the username)
        $username = strtolower(preg_replace("/[^a-zA-Z0-9]/", "", $row['client_name'])) . rand(1000, 9999);
        $password = bin2hex(random_bytes(4)); // Create a random password

        // Insert into clients_account
        $insert_sql = "INSERT INTO clients_account (client_id, username, password) 
                       VALUES ('$client_id', '$username', '$password')";

        if ($conn->query($insert_sql) === TRUE) {
            // Update the client status to approved
            $update_sql = "UPDATE clients_info SET status = 'approved' WHERE id = $client_id";
            if ($conn->query($update_sql) === TRUE) {
                // Redirect with SweetAlert on success
                echo "<script>
                        Swal.fire({
                            title: 'Success!',
                            text: 'Client approved and account created. Username: $username, Password: $password',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'adminClients.php'; // Redirect back to the same page
                            }
                        });
                      </script>";
            } else {
                // Error updating client status
                echo "<script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to update client status.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                      </script>";
            }
        } else {
            // Error creating client account
            echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to create client account.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                  </script>";
        }
    }
} else {
    // Invalid client ID or other errors
    echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'Invalid request.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
          </script>";
}

$conn->close();
?>