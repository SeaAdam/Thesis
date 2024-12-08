<?php
include 'includes/dbconn.php';

include 'login.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['loginType'] !== 'user') {
    header('Location: index.php'); // Redirect to login page if not logged in as admin
    exit();
}

$Dusername = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

include 'notification_functions.php'; // Create this file for the functions

$notifications = fetchNotifications($user_id);
$unread_count = countUnreadNotifications($user_id);
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <title>User Transactions</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">

    <style>
        .dropdown-item.unread {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .dropdown-item.read {
            background-color: #ffffff;
            font-weight: normal;
        }

        /* Style for status color coding */
        .status-accepted {
            background-color: #28a745;
            /* Green for accepted */
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            text-align: center;
        }

        .status-rejected {
            background-color: #dc3545;
            /* Red for rejected */
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            text-align: center;
        }

        .status-completed {
            background-color: #007bff;
            /* Blue for completed */
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            text-align: center;
        }

        .status-pending {
            background-color: #ffc107;
            /* Yellow for pending */
            color: black;
            padding: 5px 10px;
            border-radius: 4px;
            text-align: center;
        }

        /* Style for the 'View Receipt' button */
        .btn-info {
            background-color: #17a2b8;
            /* Info button color */
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
            text-align: center;
        }

        .btn-info:hover {
            background-color: #138496;
            /* Darker blue for hover effect */
        }
    </style>

</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="userDashboard.php" class="site_title"><i class="fa fa-plus-square"></i> <span>Brain
                                Master DC</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="images\icon-profile-user.png" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2><?php echo ($Dusername); ?></h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>General</h3>
                            <ul class="nav side-menu">
                                <li><a href="userDashboard.php"><i class="fa fa-home"></i> Appointment </a>
                                </li>
                                <li><a href="userEvents.php"><i class="fa fa-edit"></i> Events </a>
                                </li>
                                <li><a href="userProfile.php"><i class="fa fa-desktop"></i> Profile </a>
                                </li>
                                <li><a href="userTransaction.php"><i class="fa fa-table"></i> Transaction </a>
                                <li><a href="userMultipleTransaction.php"><i class="fa fa-table"></i> Multiple
                                        Transaction</a>
                                <li><a href="#"><i></i> HELP DESK </a>
                                </li>
                                <?php
                                include './contactsFetch.php'; // Assuming this file sets up the $data array
                                
                                foreach ($data as $item): ?>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-phone" aria-hidden="true"></i>
                                            <?php echo htmlspecialchars($item['ServiceProvider']) . '| ' . htmlspecialchars($item['MobileNo']); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                    </div>
                    <!-- /sidebar menu -->


                </div>
            </div>


            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <nav class="nav navbar-nav">
                        <ul class=" navbar-right">
                            <li class="nav-item dropdown open" style="padding-left: 15px;">
                                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true"
                                    id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                                </a>
                                <div class="dropdown-menu dropdown-usermenu pull-right"
                                    aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out pull-right"></i>
                                        Log Out</a>
                                </div>
                            </li>

                            <li role="presentation" class="nav-item dropdown open">
                                <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1"
                                    data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="badge bg-green"><?php echo count($notifications); ?></span>
                                    <span class="badge bg-green"><?php echo $unread_count; ?></span>
                                </a>
                                <ul class="dropdown-menu list-unstyled msg_list" role="menu"
                                    aria-labelledby="navbarDropdown1">
                                    <?php foreach ($notifications as $notification): ?>
                                        <li class="nav-item">
                                            <a class="dropdown-item <?php echo $notification['read_status'] == 0 ? 'unread' : 'read'; ?>"
                                                href="#"
                                                onclick="markAsRead(<?php echo $notification['transaction_id']; ?>)">
                                                <i class="fa fa-info-circle"></i>
                                                Booking ID: <?php echo $notification['transaction_id']; ?> - Status:
                                                <?php echo $notification['status']; ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                    <li class="nav-item">
                                        <a class="dropdown-item" href="javascript:;" onclick="markAllAsRead()">
                                            <i class="fa fa-check"></i> Mark All as Read
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <div class="right_col" role="main">
                <div>
                    <h1>Transaction Table</h1>
                    <table id="transactionTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Service Names</th>
                                <th>Schedule</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'includes/dbconn.php';

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

                                    // Color-coding the status
                                    $statusClass = "";
                                    switch ($row['status']) {
                                        case 'accepted':
                                            $statusClass = "status-accepted";
                                            break;
                                        case 'rejected':
                                            $statusClass = "status-rejected";
                                            break;
                                        case 'completed':
                                            $statusClass = "status-completed";
                                            break;
                                        default:
                                            $statusClass = "status-pending";
                                    }

                                    // Add the row to the table
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";  // Booking ID
                                    echo "<td>" . htmlspecialchars($serviceNamesStr) . "</td>";  // Service Names
                                    echo "<td>" . $scheduleStr . "</td>";  // Schedule (AM/PM)
                                    echo "<td>" . $row['created_at'] . "</td>";  // Created At
                                    echo "<td class='$statusClass'>" . $row['status'] . "</td>";  // Status (with color)
                                    echo "<td><a href='view_receipt_mb.php?id=" . $row['id'] . "' class='btn btn-info'>View Receipt</a></td>";  // View Receipt button
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

            <script>
                $(document).ready(function () {
                    $('#transactionTable').DataTable({
                        "paging": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "pageLength": 10,
                        "order": [[0, 'desc']],
                        "columnDefs": [
                            { "orderable": false, "targets": [5] } // Action column has index 5
                        ]
                    });
                });
            </script>




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
        <!-- SweetAlert CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


        <script>
            function markAsRead(transaction_id) {
                fetch(`mark_notification_read.php?transaction_id=${transaction_id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update the notification's class to 'read'
                            document.querySelector(`a[onclick='markAsRead(${transaction_id})']`).classList.remove('unread');
                            document.querySelector(`a[onclick='markAsRead(${transaction_id})']`).classList.add('read');

                            // Update the count (reload can be omitted if updating count manually)
                            location.reload();
                        }
                    });
            }

            function markAllAsRead() {
                fetch('mark_all_notifications_read.php')
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

            function cancelBooking(transactionId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this action!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, cancel it!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Use AJAX to send POST request
                        $.ajax({
                            url: 'cancel_booking_user.php',
                            method: 'POST',
                            data: { transaction_id: transactionId },
                            success: function (response) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: response,
                                    icon: 'success',
                                    timer: 2000, // Time in milliseconds (2 seconds)
                                    showConfirmButton: false // Hide the button
                                }).then(() => {
                                    // Reload the page after the SweetAlert closes
                                    location.reload(); // This will refresh the page
                                });
                            },
                            error: function (xhr, status, error) {
                                Swal.fire('Error', 'There was a problem with the request.', 'error');
                            }
                        });
                    }
                });
            }









        </script>

</body>

</html>