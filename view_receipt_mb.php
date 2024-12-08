<?php
// Include the database connection
include 'includes/dbconn.php';

// Get the booking ID from the URL
if (isset($_GET['id'])) {
    $bookingId = $_GET['id'];

    // Fetch the booking details from the database
    $query = "SELECT id, service_ids, schedule, created_at, status FROM bookings_table WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $bookingId);
    $stmt->execute();
    $stmt->bind_result($id, $serviceIds, $schedule, $createdAt, $status);
    $stmt->fetch();
    $stmt->close();

    // Decode the service_ids (array of IDs)
    $serviceIdsArray = json_decode($serviceIds);
    $serviceNames = [];

    // Fetch the service names based on the service_ids
    if (!empty($serviceIdsArray)) {
        foreach ($serviceIdsArray as $serviceId) {
            $serviceQuery = "SELECT Services FROM services_table WHERE ID = ?";
            $serviceStmt = $conn->prepare($serviceQuery);
            $serviceStmt->bind_param('i', $serviceId);
            $serviceStmt->execute();
            $serviceStmt->bind_result($serviceName);
            $serviceStmt->fetch();
            $serviceStmt->close();

            if ($serviceName) {
                $serviceNames[] = $serviceName;
            }
        }
    }

    // Join the service names into a string
    $serviceNamesStr = implode(', ', $serviceNames);

    // Map schedule to time slots
    $scheduleStr = "";
    if ($schedule == 'AM') {
        $scheduleStr = "10:00 AM - 12:00 PM";
    } elseif ($schedule == 'PM') {
        $scheduleStr = "2:00 PM - 4:00 PM";
    }

    // Format the created_at date
    $createdAtFormatted = date('F j, Y, g:i a', strtotime($createdAt));
} else {
    echo "No booking ID provided!";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
                <p>Transaction No: <?php echo htmlspecialchars($id); ?></p>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped receipt-table">
                    <tbody>
                        <tr>
                            <th>Booking ID</th>
                            <td><?php echo htmlspecialchars($id); ?></td>
                        </tr>
                        <tr>
                            <th>Services Booked</th>
                            <td><?php echo $serviceNamesStr; ?></td>
                        </tr>
                        <tr>
                            <th>Schedule</th>
                            <td><?php echo $scheduleStr; ?></td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td><?php echo $createdAtFormatted; ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <?php
                                // Display status with color coding
                                if ($status == 'accepted') {
                                    echo "<span class='text-success font-weight-bold'>Accepted</span>";
                                } elseif ($status == 'rejected') {
                                    echo "<span class='text-danger font-weight-bold'>Rejected</span>";
                                } elseif ($status == 'completed') {
                                    echo "<span class='text-primary font-weight-bold'>Completed</span>";
                                } else {
                                    echo "<span class='text-warning font-weight-bold'>Pending</span>";
                                }
                                ?>
                            </td>
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