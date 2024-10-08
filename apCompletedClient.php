<?php
include 'login.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['loginType'] !== 'admin') {
    header('Location: index.php'); // Redirect to login page if not logged in as admin
    exit();
}

// Retrieve the admin username from the session
$adminUsername = $_SESSION['username'];
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

    <title>Appointments Completed</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">

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
                            <h2><?php echo htmlspecialchars($adminUsername); ?></h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>General</h3>
                            <ul class="nav side-menu">
                                <li><a href="adminDashboard.php"><i class="fa fa-home"></i> Dashboard </a>
                                </li>
                                <li><a href="adminEvents.php"><i class="fa fa-edit"></i> Events </a>
                                </li>
                                <li><a href="adminClients.php"><i class="fa fa-desktop"></i> Clients </a>
                                </li>
                                <li><a><i class="fa fa-table"></i> Client Appointment <span
                                            class="fa fa-chevron-down"></span>
                                    </a>
                                    <ul class="nav child_menu">
                                        <li><a href="apPendingClient.php">Pending</a></li>
                                        <li><a href="apApprovedClient.php">Approved</a></li>
                                        <li><a href="apCompletedClient.php">Completed</a></li>
                                        <li><a href="apRejectedClient.php">Rejected</a></li>
                                    </ul>
                                </li>
                                <li><a href="adminPatients.php"><i class="fa fa-desktop"></i> Patients </a>
                                </li>
                                <li><a><i class="fa fa-table"></i> Patients Appointment <span
                                            class="fa fa-chevron-down"></span>
                                    </a>
                                    <ul class="nav child_menu">
                                        <li><a href="apPending.php">Pending</a></li>
                                        <li><a href="apApproved.php">Approved</a></li>
                                        <li><a href="apCompleted.php">Completed</a></li>
                                        <li><a href="apRejected.php">Rejected</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-table"></i> Maintenance<span class="fa fa-chevron-down"></span>
                                    </a>
                                    <ul class="nav child_menu">
                                        <li><a href="clientSchedule.php">Client Schedule</a></li>
                                        <li><a href="adminSchedule.php">Patient Schedule</a></li>
                                        <li><a href="adminHolidays.php">Holidays</a></li>
                                        <li><a href="adminServices.php">Services</a></li>
                                    </ul>
                                </li>
                                <li><a href="adminContacts.php"><i class="fa fa-table"></i> Contacts </a>
                                </li>
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
                        <ul class="navbar-right">
                            <li class="nav-item dropdown open" style="padding-left: 15px;">
                                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true"
                                    id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                                    <!-- Profile icon or user name can go here -->
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
                                    <span class="badge bg-green"><?php echo $unread_count; ?></span>
                                </a>
                                <ul class="dropdown-menu list-unstyled msg_list" role="menu"
                                    aria-labelledby="navbarDropdown1">
                                    <?php
                                    foreach ($notificationsAdmin as $notification) {
                                        $statusClass = $notification['status'] == 0 ? 'unread' : 'read';
                                        $transactionNo = htmlspecialchars($notification['transaction_no']);
                                        $message = htmlspecialchars($notification['message']);
                                        $createdAt = htmlspecialchars($notification['created_at']);

                                        echo '<li class="nav-item">';
                                        echo '<a class="dropdown-item ' . $statusClass . '" href="javascript:;" onclick="markAsRead(\'' . $transactionNo . '\')">';
                                        echo '<span class="message">' . $message . '</span>';
                                        echo '<span class="time">' . $createdAt . '</span>';
                                        echo '</a>';
                                        echo '</li>';
                                    }
                                    ?>


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

            <?php
            include 'includes/dbconn.php';
            ?>

            <div class="right_col" role="main">
                <h2>Completed Transactions</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Status</th>
                            <th scope="col">Transaction No.</th>
                            <th scope="col">Services</th>
                            <th scope="col">Date Appointment</th>
                            <th scope="col">Date & Time Completed</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'includes/dbconn.php';

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
                                LEFT JOIN services_table st ON cb.services = st.ID
                            WHERE 
                                cb.status = 'Completed'";

                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                <td>{$row['id']}</td>
                                <td><span class='bg-info text-white'>{$row['status']}</span></td>
                                <td>{$row['booking_no']}</td>
                                <td>{$row['service_name']}</td>
                                <td>{$row['date_appointment']}</td>
                                <td>{$row['date_seen']}</td>
                            </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No pending transactions found.</td></tr>";
                        }

                        $stmt->close();
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

        <script>
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