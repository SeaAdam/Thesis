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
                                <th>Status</th>
                                <th>Transaction No.</th>
                                <th>Services</th>
                                <th>Date Appointment</th>
                                <th>Time Slot</th>
                                <th>Date Seen</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'includes/dbconn.php';

                            $username = $_SESSION['username'];

                            $sql = "SELECT ID FROM appointment_system.registration_table WHERE username = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param('s', $username);
                            $stmt->execute();
                            $stmt->bind_result($user_id);
                            $stmt->fetch();
                            $stmt->close();

                            if ($user_id !== null) {
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
                            t.user_id = ?";

                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param('i', $user_id);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result === false) {
                                    die('Query failed: ' . htmlspecialchars($stmt->error));
                                }

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $statusClass = '';
                                        if ($row['status'] == 'Approved') {
                                            $statusClass = 'bg-success text-white';
                                        } elseif ($row['status'] == 'Completed') {
                                            $statusClass = 'bg-info text-white';
                                        } elseif ($row['status'] == 'Rejected') {
                                            $statusClass = 'bg-danger text-white';
                                        } else {
                                            $statusClass = 'bg-dark text-white'; // Default case
                                        }

                                        echo "<tr>
                                        <td>{$row['transaction_id']}</td>
                                        <td><span class='{$statusClass}'>{$row['status']}</span></td>
                                        <td>{$row['transaction_no']}</td>
                                        <td>{$row['service_id']}</td>
                                        <td>{$row['schedule_id']}</td>
                                        <td>{$row['time_slot_id']}</td>
                                        <td>{$row['date_seen']}</td>
                                        <td><a href='receipt.php?transaction_id={$row['transaction_id']}' class='btn btn-primary btn-sm'>View Receipt</a></td>
                                    </tr>";
                                    }
                                } else {
                                    echo "<p>No transactions found for User $username.</p>";
                                }

                                $stmt->close();
                            } else {
                                echo "<p>No user ID found for username '$username'.</p>";
                            }

                            $conn->close();
                            ?>
                        </tbody>
                    </table>

                </div>

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
        </script>

</body>

</html>