<?php
include 'includes/dbconn.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings Dashboard</title>
    <!-- Add your CSS for styling -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <!-- Transaction Table Section -->
        <div class="transaction-table">
            <h1>Transaction Table</h1>
            <table id="transactionTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Service Names</th>
                        <th>Schedule</th>
                        <th>Created At</th>
                        <th>Status</th>
                        <th>Actions</th> <!-- Add actions column -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch all bookings from the database
                    $query = "SELECT id, service_ids, schedule, created_at, status FROM bookings_table";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Decode the schedule field (assuming it's a JSON array like ["AM", "PM"])
                            $schedule = $row['schedule'];
                            $scheduleStr = "";

                            // Map schedule to time slots
                            if ($schedule == 'AM') {
                                $scheduleStr = "10:00 AM - 12:00 PM";
                            } elseif ($schedule == 'PM') {
                                $scheduleStr = "2:00 PM - 4:00 PM";
                            }

                            // Decode the service_ids (array of IDs)
                            $serviceIds = json_decode($row['service_ids']);
                            $serviceNames = [];

                            // Get service names from the services table using the IDs
                            if (!empty($serviceIds)) {
                                foreach ($serviceIds as $serviceId) {
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

                            // Join the service names with commas for display
                            $serviceNamesStr = implode(', ', $serviceNames);

                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";  // Booking ID
                            echo "<td>" . htmlspecialchars($serviceNamesStr) . "</td>";  // Service Names
                            echo "<td>" . $scheduleStr . "</td>";  // Schedule (AM/PM)
                            echo "<td>" . $row['created_at'] . "</td>";  // Created At
                            echo "<td>" . $row['status'] . "</td>";  // Status (accepted/rejected)
                    
                            // Add Action Buttons for Accept/Reject
                            if ($row['status'] == 'pending') {
                                echo "<td>";
                                echo "<form method='POST' action='update_booking_status.php'>";
                                echo "<input type='hidden' name='bookingId' value='" . $row['id'] . "'>";
                                echo "<button type='submit' name='action' value='accept'>Accept</button>";
                                echo "<button type='submit' name='action' value='reject'>Reject</button>";
                                echo "</form>";
                                echo "</td>";
                            } elseif ($row['status'] == 'Accepted') {
                                echo "<td>";
                                echo "<form method='POST' action='update_booking_status.php'>";
                                echo "<input type='hidden' name='bookingId' value='" . $row['id'] . "'>";
                                echo "<button type='submit' name='action' value='complete'>Complete</button>";
                                echo "</form>";
                                echo "</td>";
                            } else {
                                echo "<td>-</td>";  // If not pending or accepted, show a dash or other text
                            }

                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No bookings found</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>