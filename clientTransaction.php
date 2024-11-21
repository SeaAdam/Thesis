<?php
include 'includes/dbconn.php';
include 'login.php';

if (!isset($_SESSION['username']) || $_SESSION['loginType'] !== 'clients') {
    header('Location: index.php');
    exit();
}

$clientUsername = $_SESSION['username'];
$sql = "SELECT client_id FROM clients_account WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $clientUsername);
$stmt->execute();
$result = $stmt->get_result();

// Check if a record was found
if ($result->num_rows > 0) {
    // Fetch the client_id from the database
    $row = $result->fetch_assoc();
    $id = $row['client_id'];
} else {
    // Handle the case where no user was found (optional)
    echo "No client found with this username.";
    exit();
}
include 'notification_functions.php'; // Create this file for the functions

$notificationsClient = fetchNotificationsClient($id);
$unread_count = countUnreadNotificationsClient($id);
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
                            <h2><?php echo htmlspecialchars($clientUsername); ?></h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>General</h3>
                            <ul class="nav side-menu">
                                <li><a href="clientDashboard.php"><i class="fa fa-home"></i> Appointment </a>
                                </li>
                                <li><a href="clientEvents.php"><i class="fa fa-edit"></i> Events </a>
                                </li>
                                <li><a href="clientProfile.php"><i class="fa fa-desktop"></i> Profile </a>
                                </li>
                                <li><a href="clientTransaction.php"><i class="fa fa-table"></i> Transaction </a>
                                <li><a href="#"><i></i> HELP DESK </a>
                                </li>
                                <?php
                                include './no_error_contacts.php'; // Assuming this file sets up the $data array
                                
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
                                    <span class="badge bg-green"><?php echo count($notificationsClient); ?></span>
                                    <span class="badge bg-green"><?php echo $unread_count; ?></span>
                                </a>
                                <ul class="dropdown-menu list-unstyled msg_list" role="menu"
                                    aria-labelledby="navbarDropdown1">
                                    <?php foreach ($notificationsClient as $notification): ?>
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
                                <th>Booking No.</th>
                                <th>Services Acquired</th>
                                <th>Date Appointment</th>
                                <th>Date Seen</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sqlClientId = "SELECT client_id FROM clients_account WHERE username = ?";
                            $stmt = $conn->prepare($sqlClientId);
                            $stmt->bind_param('s', $clientUsername);
                            $stmt->execute();
                            $stmt->bind_result($clientId);
                            $stmt->fetch();
                            $stmt->close();

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
            LEFT JOIN 
                services_table st ON cb.services = st.ID
            WHERE 
                cb.account_id = ?";

                            $query = $conn->prepare($sql);
                            $query->bind_param('i', $clientId);
                            $query->execute();
                            $result = $query->get_result();

                            if ($result) {
                                while ($row = $result->fetch_assoc()) {
                                    $statusClass = '';
                                    if ($row['status'] == 'Approved') {
                                        $statusClass = 'bg-success text-white';
                                    } elseif ($row['status'] == 'Completed') {
                                        $statusClass = 'bg-info text-white';
                                    } elseif ($row['status'] == 'Rejected') {
                                        $statusClass = 'bg-danger text-white';
                                    } elseif ($row['status'] == 'Pending') {
                                        $statusClass = 'bg-dark text-white';
                                    } elseif ($row['status'] == 'Canceled') {
                                        $statusClass = 'bg-secondary text-white';
                                    }
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo htmlspecialchars($row['id']); ?></th>
                                        <td><span class="<?php echo htmlspecialchars($statusClass); ?>">
                                                <?php echo htmlspecialchars($row['status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['booking_no']); ?></td>
                                        <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['date_appointment']); ?></td>
                                        <td><?php echo htmlspecialchars($row['date_seen']); ?></td>
                                        <td>
                                            <!-- View Receipt Button (Not shown for Pending or Canceled) -->
                                            <?php if ($row['status'] != 'Pending' && $row['status'] != 'Canceled') { ?>
                                                <a href="viewReceipt.php?transaction_id=<?php echo htmlspecialchars($row['id']); ?>"
                                                    class="btn btn-success btn-sm">
                                                    <i class="fa fa-info" aria-hidden="true"></i> View Receipt
                                                </a>
                                            <?php } ?>

                                            <!-- Cancel Button for Pending Status Only -->
                                            <?php if ($row['status'] == 'Pending') { ?>
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="cancelTransaction('<?php echo htmlspecialchars($row['id']); ?>')">
                                                    <i class="fa fa-times" aria-hidden="true"></i> Cancel
                                                </button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "Error: " . $conn->error;
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

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            function cancelTransaction(transactionId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, cancel it!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: 'cancelTransaction.php',
                            type: 'POST',
                            data: { transaction_id: transactionId },
                            success: function (response) {
                                if (response == 'success') {
                                    Swal.fire(
                                        'Canceled!',
                                        'The transaction has been canceled.',
                                        'success'
                                    ).then(() => {
                                        location.reload(); // Reload the page
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'There was an issue canceling the transaction. Please try again.',
                                        'error'
                                    );
                                }
                            },
                            error: function () {
                                Swal.fire(
                                    'Error!',
                                    'Could not communicate with the server. Please try again.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            }
        </script>

</body>

</html>