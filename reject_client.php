<?php
include 'includes/dbconn.php';

if (isset($_GET['id'])) {
    $client_id = $_GET['id'];

    // Update the client status to rejected
    $update_sql = "UPDATE clients_info SET status = 'rejected' WHERE id = $client_id";
    if ($conn->query($update_sql) === TRUE) {
        // Redirect with SweetAlert on success
        echo "<script>
                Swal.fire({
                    title: 'Rejected!',
                    text: 'Client has been rejected successfully.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'adminClients.php'; // Redirect back to the same page
                    }
                });
              </script>";
    } else {
        // Error rejecting client
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to reject client.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
              </script>";
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