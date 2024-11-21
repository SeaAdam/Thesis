<?php
include 'includes/dbconn.php';
session_start();

// Fetch transaction_id from URL parameter
$transaction_id = isset($_GET['transaction_id']) ? intval($_GET['transaction_id']) : 0;

if ($transaction_id > 0) {
    // Fetch details for the transaction
    $sql = "SELECT 
                t.ID AS transaction_id,
                t.status,
                t.transaction_no,
                s.Services AS service_id,
                sr.Slots_Date AS schedule_id,
                CONCAT(ts.start_time, ' - ', ts.end_time) AS time_slot_id,
                t.date_seen
            FROM 
                appointment_system.transactions t
                LEFT JOIN appointment_system.services_table s ON t.service_id = s.ID
                LEFT JOIN appointment_system.schedule_record_table sr ON t.schedule_id = sr.ID
                LEFT JOIN appointment_system.time_slots ts ON t.time_slot_id = ts.ID
            WHERE 
                t.ID = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $transaction_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Receipt</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome -->
            <style>
                .receipt-container {
                    max-width: 900px;
                    margin: auto;
                    padding: 20px;
                    border: 1px solid #ddd;
                    border-radius: 8px;
                    background: #f9f9f9;
                }
                .header-container {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    margin-bottom: 20px;
                }
                .header-container .logo {
                    flex: 1;
                    text-align: center;
                }
                .header-container .logo img {
                    max-height: 100px; /* Adjust height as needed */
                    width: auto;
                }
                .letterhead {
                    text-align: center;
                    flex: 2;
                    margin-bottom: 3rem;
                }
                .letterhead h2, .letterhead h3 {
                    margin: 0;
                }
                .letterhead h2 {
                    font-size: 28px;
                }
                .letterhead h3 {
                    font-size: 20px;
                }
                .receipt-title {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .receipt-title h1 {
                    margin: 0;
                    font-size: 24px;
                }
                .receipt-title p {
                    margin: 0;
                    font-size: 18px;
                }
                .receipt-table th, .receipt-table td {
                    padding: 8px;
                    text-align: left;
                }
                .back-button {
                    position: fixed;
                    top: 20px;
                    left: 20px;
                    z-index: 1000;
                }
                .back-button a {
                    text-decoration: none;
                    color: #fff;
                }
                .back-button .fa {
                    font-size: 24px;
                    color: #007bff; /* Bootstrap primary color */
                }
                .complimentary-closing {
                    margin-top: 40px;
                    text-align: center;
                }
                .signature {
                    margin-top: 40px;
                    text-align: center;
                }
            </style>
            <script>
                window.onload = function() {
                    window.print();
                };
            </script>
        </head>
        <body>
            <div class="back-button">
                <a href="userTransaction.php">
                    <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
                </a>
            </div>
            <div class="container mt-5">
                <div class="receipt-container">
                    <div class="header-container">
                        <div class="logo">
                            <img src="images\LOGO.png" alt="Logo Left"> <!-- Replace with the path to your left logo -->
                        </div>
                        <div class="letterhead">
                            <h2>BRAIN MASTER DIAGNOSTIC CENTER (BMDC)</h2>
                            <h3>APPOINTMENT SCHEDULING SYSTEM</h3>
                            <h3>ONLINE RECEIPT</h3>
                        </div>
                        <div class="logo">
                            <img src="images\LOGO.png" alt="Logo Right"> <!-- Replace with the path to your right logo -->
                        </div>
                    </div>
                    <div class="receipt-title">
                        <h1>APPOINTMENT RECEIPT</h1>
                        <p>Transaction No: <?php echo htmlspecialchars($row['transaction_no']); ?></p>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped receipt-table">
                            <tbody>
                                <tr>
                                    <th>Transaction ID</th>
                                    <td><?php echo htmlspecialchars($row['transaction_id']); ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                </tr>
                                <tr>
                                    <th>Service</th>
                                    <td><?php echo htmlspecialchars($row['service_id']); ?></td>
                                </tr>
                                <tr>
                                    <th>Date Appointment</th>
                                    <td><?php echo htmlspecialchars($row['schedule_id']); ?></td>
                                </tr>
                                <tr>
                                    <th>Time Slot</th>
                                    <td><?php echo htmlspecialchars($row['time_slot_id']); ?></td>
                                </tr>
                                <tr>
                                    <th>Date Seen</th>
                                    <td><?php echo htmlspecialchars($row['date_seen']); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="complimentary-closing">
                        <p>Approved By:</p>
                        <p><strong>Jhayson Fabrigar</strong></p>
                        <p>Officer In Charge</p>
                    </div>
                    <div class="signature">
                        <p>Signature:</p>
                        <p>__________________________</p>
                    </div>
                </div>
            </div>

            <!-- Bootstrap JS and dependencies -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>
        </html>
        <?php
    } else {
        echo "<p class='text-center'>No details found for this transaction.</p>";
    }

    $stmt->close();
} else {
    echo "<p class='text-center'>Invalid transaction ID.</p>";
}

$conn->close();
?>

<table id="transactionTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Status</th>
                                <th>Booking No.</th>
                                <th>Services Acquired</th>
                                <th>Date Appointment</th>
                                <th>Date Seen</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sqlClientId = "SELECT client_id FROM clients_account WHERE username = ?";
                            $stmt = $conn->prepare($sqlClientId);
                            $stmt->bind_param('s', $clientUsername);
                            $stmt->execute();
                            $stmt->bind_result($clientId);
                            $stmt->fetch();
                            $stmt->close();

                            $sql = "
            SELECT 
                cb.id, 
                cb.status, 
                cb.booking_no, 
                st.Services AS service_name, 
                cb.date_appointment, 
                cb.date_seen
            FROM 
                client_booking cb
            LEFT JOIN 
                services_table st ON cb.services = st.ID
            WHERE 
                cb.account_id = ?";

                            $query = $conn->prepare($sql);
                            $query->bind_param('i', $clientId);
                            $query->execute();
                            $result = $query->get_result();

                            if ($result) {
                                while ($row = $result->fetch_assoc()) {
                                    $statusClass = '';
                                    if ($row['status'] == 'Approved') {
                                        $statusClass = 'bg-success text-white';
                                    } elseif ($row['status'] == 'Completed') {
                                        $statusClass = 'bg-info text-white';
                                    } elseif ($row['status'] == 'Rejected') {
                                        $statusClass = 'bg-danger text-white';
                                    } elseif ($row['status'] == 'Pending') {
                                        $statusClass = 'bg-dark text-white';
                                    } elseif ($row['status'] == 'Canceled') {
                                        $statusClass = 'bg-secondary text-white';
                                    }
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo htmlspecialchars($row['id']); ?></th>
                                        <td><span class="<?php echo htmlspecialchars($statusClass); ?>">
                                                <?php echo htmlspecialchars($row['status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['booking_no']); ?></td>
                                        <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['date_appointment']); ?></td>
                                        <td><?php echo htmlspecialchars($row['date_seen']); ?></td>
                                        <td>
                                            <!-- View Receipt Button (Not shown for Pending or Canceled) -->
                                            <?php if ($row['status'] != 'Pending' && $row['status'] != 'Canceled') { ?>
                                                <a href="viewReceipt.php?transaction_id=<?php echo htmlspecialchars($row['id']); ?>"
                                                    class="btn btn-success btn-sm">
                                                    <i class="fa fa-info" aria-hidden="true"></i> View Receipt
                                                </a>
                                            <?php } ?>

                                            <!-- Cancel Button for Pending Status Only -->
                                            <?php if ($row['status'] == 'Pending') { ?>
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="cancelTransaction('<?php echo htmlspecialchars($row['id']); ?>')">
                                                    <i class="fa fa-times" aria-hidden="true"></i> Cancel
                                                </button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "Error: " . $conn->error;
                            }

                            $conn->close();
                            ?>
                        </tbody>
                    </table>

                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            function cancelTransaction(transactionId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, cancel it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                       
                        $.ajax({
                            url: 'cancelTransaction.php',
                            type: 'POST',
                            data: { transaction_id: transactionId },
                            success: function (response) {
                                if (response == 'success') {
                                    Swal.fire(
                                        'Canceled!',
                                        'The transaction has been canceled.',
                                        'success'
                                    ).then(() => {
                                        location.reload(); // Reload the page
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'There was an issue canceling the transaction. Please try again.',
                                        'error'
                                    );
                                }
                            },
                            error: function () {
                                Swal.fire(
                                    'Error!',
                                    'Could not communicate with the server. Please try again.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            }
        </script>

