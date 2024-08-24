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
