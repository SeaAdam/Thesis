<?php
include 'login.php';

// Check if the user is logged in and is a staff member
if (!isset($_SESSION['username']) || $_SESSION['loginType'] !== 'staff') {
    header('Location: index.php'); // Redirect to login page if not logged in as staff
    exit();
}

// Retrieve the staff username from the session
$staffUsername = $_SESSION['username'];
// Fetch notifications
include 'notification_functions.php'; // Include the file with fetchNotificationsAdmin function
$notificationsAdmin = fetchNotificationsAdmin();
$unread_count = countUnreadNotificationsAdmin();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>Appointments Pending</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .read {
            background-color: #f0f0f0;
            /* Example styling for unread */
        }

        .unread {
            background-color: #e0e0e0;
            /* Example styling for read */
        }
    </style>

</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="adminDashboard.php" class="site_title"><i class="fa fa-plus-square"></i> <span>Brain
                                Master DC</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="images/admin-icon.jpg" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2><?php echo htmlspecialchars($staffUsername); ?></h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <?php include('sidebar_staff.php'); ?>


                </div>
            </div>

            <?php include 'top_nav_admin.php'; ?>

            <div class="right_col" role="main">
                <h2>Multiple Booking Transactions</h2>
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
                        
                                // Status with color
                                if ($row['status'] == 'pending') {
                                    echo "<td style='color: orange;'>" . $row['status'] . "</td>";  // Pending (Orange)
                                } elseif ($row['status'] == 'Accepted') {
                                    echo "<td style='color: green;'>" . $row['status'] . "</td>";  // Accepted (Green)
                                } elseif ($row['status'] == 'Rejected') {
                                    echo "<td style='color: red;'>" . $row['status'] . "</td>";  // Rejected (Red)
                                } else {
                                    echo "<td>" . $row['status'] . "</td>";
                                }

                                // Add Action Buttons with Color Based on Status
                                if ($row['status'] == 'pending') {
                                    echo "<td>";
                                    echo "<button onclick=\"updateStatus(" . $row['id'] . ", 'accept')\" style='background-color: green; color: white; border: none; padding: 5px 10px; margin-right: 5px;'>Accept</button>";
                                    echo "<button onclick=\"updateStatus(" . $row['id'] . ", 'reject')\" style='background-color: red; color: white; border: none; padding: 5px 10px;'>Reject</button>";
                                    echo "</td>";
                                } elseif ($row['status'] == 'Accepted') {
                                    echo "<td>";
                                    echo "<button onclick=\"updateStatus(" . $row['id'] . ", 'complete')\" style='background-color: blue; color: white; border: none; padding: 5px 10px;'>Complete</button>";
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

        <!-- jQuery -->
        <script src="vendors/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <!-- FastClick -->
        <script src="vendors/fastclick/lib/fastclick.js"></script>
        <!-- NProgress -->
        <script src="vendors/nprogress/nprogress.js"></script>
        <!-- Chart.js -->
        <script src="vendors/Chart.js/dist/Chart.min.js"></script>
        <!-- gauge.js -->
        <script src="vendors/gauge.js/dist/gauge.min.js"></script>
        <!-- bootstrap-progressbar -->
        <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
        <!-- iCheck -->
        <script src="vendors/iCheck/icheck.min.js"></script>
        <!-- Skycons -->
        <script src="vendors/skycons/skycons.js"></script>
        <!-- Flot -->
        <script src="vendors/Flot/jquery.flot.js"></script>
        <script src="vendors/Flot/jquery.flot.pie.js"></script>
        <script src="vendors/Flot/jquery.flot.time.js"></script>
        <script src="vendors/Flot/jquery.flot.stack.js"></script>
        <script src="vendors/Flot/jquery.flot.resize.js"></script>
        <!-- Flot plugins -->
        <script src="vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
        <script src="vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
        <script src="vendors/flot.curvedlines/curvedLines.js"></script>
        <!-- DateJS -->
        <script src="vendors/DateJS/build/date.js"></script>
        <!-- JQVMap -->
        <script src="vendors/jqvmap/dist/jquery.vmap.js"></script>
        <script src="vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
        <script src="vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
        <!-- bootstrap-daterangepicker -->
        <script src="vendors/moment/min/moment.min.js"></script>
        <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

        <!-- Custom Theme Scripts -->
        <script src="build/js/custom.min.js"></script>

        <!-- SweetAlert2 CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>

            function updateStatus(bookingId, action) {
                // Show SweetAlert loading message
                Swal.fire({
                    title: 'Updating...',
                    text: 'Please wait while we update the status.',
                    allowOutsideClick: false,  // Prevent click outside to dismiss
                    didOpen: () => {
                        Swal.showLoading();  // Show loading animation
                    }
                });

                // Prepare data to send to the server
                var data = {
                    bookingId: bookingId,
                    action: action
                };

                // Send AJAX request
                $.ajax({
                    url: 'update_booking_status.php', // PHP file to update status
                    type: 'POST',
                    data: data,
                    success: function (response) {
                        var result = JSON.parse(response);
                        if (result.success) {
                            // Close the loading popup
                            Swal.close();

                            // Show success SweetAlert confirmation
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: result.message,
                            }).then(() => {
                                location.reload(); // Reload the page to reflect the updated status (optional)
                            });
                        } else {
                            // Close the loading popup
                            Swal.close();

                            // Show error SweetAlert message
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: result.error,
                            });
                        }
                    },
                    error: function () {
                        // Close the loading popup
                        Swal.close();

                        // Show AJAX error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: 'Failed to update booking status',
                        });
                    }
                });
            }

            function markAsRead(transaction_no) {
                fetch(`mark_notification_read_admin.php?transaction_no=${encodeURIComponent(transaction_no)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Find the notification link
                            const notificationLink = document.querySelector(`a[onclick*='markAsRead("${transaction_no}")']`);
                            if (notificationLink) {
                                // Update the notification's class to 'read'
                                notificationLink.classList.remove('unread');
                                notificationLink.classList.add('read');

                            }
                            location.reload();
                        } else {
                            console.error('Failed to mark notification as read.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }



            function markAllAsRead() {
                fetch('mark_all_notification_read_admin.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update all notifications' classes to 'read'
                            document.querySelectorAll('.dropdown-item.unread').forEach(item => {
                                item.classList.remove('unread');
                                item.classList.add('read');
                            });

                            // Update the count
                            location.reload();
                        }
                    });
            }




        </script>

</body>

</html>