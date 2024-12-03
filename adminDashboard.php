<?php
include 'login.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['loginType'] !== 'admin') {
    header('Location: index.php'); // Redirect to login page if not logged in as admin
    exit();
}

// Retrieve the admin username from the session
$adminUsername = $_SESSION['username'];


include 'count_Dashboard.php';
// Fetch notifications
include 'notification_functions.php'; // Include the file with fetchNotificationsAdmin function
$notificationsAdmin = fetchNotificationsAdmin();
$unread_count = countUnreadNotificationsAdmin();

$maxValue = 100; // Assuming 100 as the maximum value for percentage

// Calculate percentage for each count
$percentPatient = ($countPatient / $maxValue) * 100;
$percentServices = ($countServices / $maxValue) * 100;
$percentSchedules = ($countSchedules / $maxValue) * 100;
$percentAdmin = ($countAdmin / $maxValue) * 100;
$percentBlocked = ($countBlocked / $maxValue) * 100;
$percentClients = ($countClients / $maxValue) * 100;
$percentClientSchedules = ($countClientSchedules / $maxValue) * 100;
$percentEvents = ($countEvents / $maxValue) * 100;
$percentHolidays = ($countHolidays / $maxValue) * 100;
$percentRemovedClients = ($countRemovedClients / $maxValue) * 100;
$percentReviews = ($countReviews / $maxValue) * 100;
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

    <title>Admin Dashboard</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">

    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.css' rel='stylesheet' />

    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.js'></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        #calendar {
            width: 70%;
            float: left;
        }

        #events-calendar {
            width: 100%;
        }

        #legend,
        #holidays {
            width: 25%;
            float: right;
            margin: 10px;
        }

        #legend ul,
        #holidays ul {
            list-style-type: none;
            padding: 0;
        }

        #legend li,
        #holidays li {
            margin-bottom: 10px;
        }

        #legend span {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }

        .fc .fc-button:not(:disabled) {
            background-color: lemonchiffon;
            color: black;

        }

        .fc .fc-button-primary:disabled {
            background-color: lemonchiffon;
            color: black;
        }

        .custom-button {
            display: block;
            margin: 5px auto;
            padding: 5px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .custom-button:hover {
            background-color: #0056b3;
        }

        .fc-h-event .fc-event-title {
            font-size: .8rem;
        }

        .chart-container {
            position: relative;
            width: 100%;
            /* Adjust width as needed */
            height: 200px;
            /* Adjust height as needed */
        }

        #statusDoughnutChart {
            width: 100% !important;
            height: 100% !important;
        }

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
                            <img src="images\admin-icon.jpg" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2><?php echo htmlspecialchars($adminUsername); ?></h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <?php include('sidebar.php'); ?>
                </div>
            </div>

            <?php include 'top_nav_admin.php'; ?>

            <?php include 'admin_dashboard_content.php'; ?>
            




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