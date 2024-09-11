<?php
include 'login.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['loginType'] !== 'admin') {
    header('Location: index.php'); // Redirect to login page if not logged in as admin
    exit();
}

// Retrieve the admin username from the session
$adminUsername = $_SESSION['username'];
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

    <title>Appointments Approved</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                                <li><a><i class="fa fa-table"></i> Client Appointment <span class="fa fa-chevron-down"></span>
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
                                <li><a><i class="fa fa-table"></i> Patients Appointment <span class="fa fa-chevron-down"></span>
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

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.php">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </div>
                    <!-- /menu footer buttons -->
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
                                    <?php echo htmlspecialchars($adminUsername); ?>
                                </a>
                                <div class="dropdown-menu dropdown-usermenu pull-right"
                                    aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="index.php"><i class="fa fa-sign-out pull-right"></i>
                                        Log Out</a>
                                </div>
                            </li>

                            <li role="presentation" class="nav-item dropdown open">
                                <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1"
                                    data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="badge bg-green">6</span>
                                </a>
                                <ul class="dropdown-menu list-unstyled msg_list" role="menu"
                                    aria-labelledby="navbarDropdown1">
                                    <li class="nav-item">
                                        <a class="dropdown-item">
                                            <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were
                                                where...
                                            </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="dropdown-item">
                                            <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were
                                                where...
                                            </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="dropdown-item">
                                            <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were
                                                where...
                                            </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="dropdown-item">
                                            <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were
                                                where...
                                            </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <div class="text-center">
                                            <a class="dropdown-item">
                                                <strong>See All Alerts</strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <div class="right_col" role="main">
                <h2>Approved Transactions</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Status</th>
                            <th scope="col">Transaction No.</th>
                            <th scope="col">Services</th>
                            <th scope="col">Date Appointment</th>
                            <th scope="col">Time Slot</th>
                            <th scope="col">Date & Time Approved</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'includes/dbconn.php';

                        // Fetch all approved transactions
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
                t.status = 'Approved'";

                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result === false) {
                            die('Query failed: ' . htmlspecialchars($stmt->error));
                        }

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                        <td>{$row['transaction_id']}</td>
                        <td><span class='bg-primary text-white'>{$row['status']}</span></td>
                        <td>{$row['transaction_no']}</td>
                        <td>{$row['service_id']}</td>
                        <td>{$row['schedule_id']}</td>
                        <td>{$row['time_slot_id']}</td>
                        <td>{$row['date_seen']}</td>
                        <td>
                            <button class='btn btn-success btn-sm' onclick='confirmCompleteTransaction({$row['transaction_id']})'>Complete</button>
                        </td>
                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No approved transactions found.</td></tr>";
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
            function confirmCompleteTransaction(transactionId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to mark this transaction as completed.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, complete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show a loading spinner while the AJAX request is being processed
                        Swal.fire({
                            title: 'Processing...',
                            text: 'Please wait while we update the transaction status.',
                            icon: 'info',
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Proceed with updating the transaction status
                        updateTransactionStatus(transactionId, 'Completed');
                    }
                });
            }

            function updateTransactionStatus(id, status) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "update_status_approved.php", true); // Ensure this matches your PHP file
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        Swal.close(); // Close the loading spinner

                        if (xhr.responseText.trim() === 'Success') {
                            Swal.fire(
                                'Completed!',
                                'The transaction has been marked as completed.',
                                'success'
                            ).then(() => {
                                // Reload the page to reflect the changes
                                window.location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'Failed to update the transaction.',
                                'error'
                            );
                        }
                    }
                };

                // Send the data to the server
                xhr.send("id=" + encodeURIComponent(id) + "&status=" + encodeURIComponent(status));
            }


        </script>

</body>

</html>