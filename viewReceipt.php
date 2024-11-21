<?php
include 'includes/dbconn.php';

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['transaction_id'])) {
    $transaction_id = $_GET['transaction_id'];

    $sql = "
        SELECT 
            cb.id, 
            cb.booking_no, 
            cb.status, 
            st.Services AS service_name, 
            cb.date_appointment, 
            cb.date_seen, 
            cb.account_id 
        FROM 
            client_booking cb
        LEFT JOIN 
            services_table st ON cb.services = st.ID
        WHERE 
            cb.id = ?";

    // Prepare the SQL statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $transaction_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // If the transaction exists
        if ($result && $row = $result->fetch_assoc()) {
            // Transaction details
            $booking_no = htmlspecialchars($row['booking_no']);
            $status = htmlspecialchars($row['status']);
            $service_name = htmlspecialchars($row['service_name']);
            $date_appointment = htmlspecialchars($row['date_appointment']);
            $date_seen = htmlspecialchars($row['date_seen']);
        } else {
            // If transaction not found
            echo "Transaction not found.";
            exit();
        }

        $stmt->close();
    } else {
        // If SQL query preparation failed
        echo "Error preparing the query: " . $conn->error;
        exit();
    }
} else {
    echo "No transaction ID provided.";
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Receipt</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Font Awesome -->
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
            max-height: 100px;
            /* Adjust height as needed */
            width: auto;
        }

        .letterhead {
            text-align: center;
            flex: 2;
            margin-bottom: 3rem;
        }

        .letterhead h2,
        .letterhead h3 {
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

        .receipt-table th,
        .receipt-table td {
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
            color: #007bff;
            /* Bootstrap primary color */
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
        window.onload = function () {
            window.print(); // Automatically open print dialog
        };
    </script>
</head>

<body>

    <div class="back-button">
        <a href="clientTransaction.php">
            <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
        </a>
    </div>

    <div class="container mt-5">
        <div class="receipt-container">
            <div class="header-container">
                <div class="logo">
                    <img src="images/LOGO.png" alt="Logo Left"> <!-- Replace with the path to your left logo -->
                </div>
                <div class="letterhead">
                    <h2>BRAIN MASTER DIAGNOSTIC CENTER (BMDC)</h2>
                    <h3>APPOINTMENT SCHEDULING SYSTEM</h3>
                    <h3>ONLINE RECEIPT</h3>
                </div>
                <div class="logo">
                    <img src="images/LOGO.png" alt="Logo Right"> <!-- Replace with the path to your right logo -->
                </div>
            </div>
            <div class="receipt-title">
                <h1>APPOINTMENT RECEIPT</h1>
                <p>Transaction No: <?php echo $booking_no; ?></p>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped receipt-table">
                    <tbody>
                        <tr>
                            <th>Booking No.</th>
                            <td><?php echo $booking_no; ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><span class="badge 
                            <?php
                            if ($status == 'Approved')
                                echo 'bg-success text-white';
                            elseif ($status == 'Completed')
                                echo 'bg-info text-white';
                            elseif ($status == 'Rejected')
                                echo 'bg-danger text-white';
                            else
                                echo 'bg-dark text-white';
                            ?>">
                                    <?php echo $status; ?>
                                </span></td>
                        </tr>
                        <tr>
                            <th>Service</th>
                            <td><?php echo $service_name; ?></td>
                        </tr>
                        <tr>
                            <th>Date of Appointment</th>
                            <td><?php echo $date_appointment; ?></td>
                        </tr>
                        <tr>
                            <th>Date Seen</th>
                            <td><?php echo $date_seen ? $date_seen : 'N/A'; ?></td>
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

    <!-- Include Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>