<?php
include 'includes/dbconn.php';

include 'login.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['loginType'] !== 'user') {
    header('Location: index.php'); // Redirect to login page if not logged in as admin
    exit();
}

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
// Fetch user details based on username
$sql = "SELECT * FROM registration_table WHERE Username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

$stmt->close();
$conn->close();

// Retrieve the email from the session
$userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : 'Not provided';

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

    <title>User Profile</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">

    <!-- Include SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Include SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

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
                            <h2><?php echo ($username); ?></h2>
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
                        <a data-toggle="tooltip" data-placement="top" title="Logout" href="index.php">
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
                <div class="container mt-5">
                    <div class="row">
                        <!-- Profile Display Form (Left) -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <img src="images\profile-pic.jpg" class="mb-3" alt="Profile Picture" width="150"
                                        height="150">
                                    <h4 class="FullName">
                                        <?php echo htmlspecialchars($user['FirstName'] . ' ' . $user['MI'] . ' ' . $user['LastName']); ?>
                                    </h4>
                                </div>
                            </div>
                        </div>

                        <!-- Information Display Form (Right) -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Gender</th>
                                                <td>
                                                    <p class="Gender"><?php echo htmlspecialchars($user['Gender']); ?>
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Age</th>
                                                <td>
                                                    <p class="Age"><?php echo htmlspecialchars($user['Age']); ?></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Date of Birth</th>
                                                <td>
                                                    <p class="DOB"><?php echo htmlspecialchars($user['DOB']); ?></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Contact</th>
                                                <td>
                                                    <p class="Contact"><?php echo htmlspecialchars($user['Contact']); ?>
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Present Address</th>
                                                <td>
                                                    <p class="PresentAddress">
                                                        <?php echo htmlspecialchars($user['PresentAddress']); ?>
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Username</th>
                                                <td>
                                                    <p class="Username">
                                                        <?php echo htmlspecialchars($user['Username']); ?>
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Email Address (use in 2FA)</th>
                                                <td>
                                                    <p class="Email">
                                                        <?php echo htmlspecialchars($userEmail); ?>
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Action</th>
                                                <td>
                                                    <a href="#" data-id="<?php echo $user['ID']; ?>"
                                                        class="btn btn-success btn-sm edit"><i class="fa fa-edit"
                                                            aria-hidden="true"></i>
                                                        Edit</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
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

        <?php include "includes/booking_modal.php"; ?>

        <script>
            $(function () {
                $('.edit').click(function (e) {
                    e.preventDefault();
                    $('#editUserProfile').modal('show');
                    var id = $(this).data('id');
                    getRow(id);
                });
            });

            function getRow(id) {
                $.ajax({
                    type: 'GET',
                    url: 'fetch_user_editProfile.php',
                    data: { id: id },
                    dataType: 'json',
                    success: function (response) {
                        if (response.error) {
                            console.error('Error:', response.error);
                        } else {
                            $('.ID').val(response.ID);
                            $('#EUFirstName').val(response.FirstName);
                            $('#EUMI').val(response.MI);
                            $('#EULastName').val(response.LastName);
                            $('#EUGender').val(response.Gender);
                            $('#EUAge').val(response.Age);
                            $('#EUDOB').val(response.DOB);
                            $('#EUContact').val(response.Contact);
                            $('#EUPresentAddress').val(response.PresentAddress);
                            $('#EPUsername').val(response.Username);
                            $('#EPPassword').val(response.Password);
                            $('#EPConfirmPassword').val(response.ConfirmPassword);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });
            }

            $('#editUserProfile form').submit(function (e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: 'update_user_editProfile.php',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if (response.error) {
                            // Display SweetAlert for error
                            Swal.fire({
                                title: 'Error!',
                                text: response.error,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            // Display SweetAlert for success
                            Swal.fire({
                                title: 'Success!',
                                text: 'Profile updated successfully!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#editUserProfile').modal('hide');
                                    location.reload();
                                }
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        // Display SweetAlert for AJAX error
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to update the profile. Please try again later.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });


            document.addEventListener('DOMContentLoaded', function () {
                // Fetch user information based on session username
                function fetchUserInfo() {
                    $.ajax({
                        type: 'POST',
                        url: 'login.php', // Update this to the correct PHP file
                        dataType: 'json',
                        success: function (response) {
                            if (response.error) {
                                console.error(response.error);
                                return;
                            }

                            var fullName = response.FirstName + " " + response.MI + " " + response.LastName;
                            $('.FullName').text(fullName);
                            $('.ID').val(response.ID);
                            $('.FirstName').text(response.FirstName);
                            $('.MI').text(response.MI);
                            $('.LastName').text(response.LastName);
                            $('.Gender').text(response.Gender);
                            $('.Age').text(response.Age);
                            $('.DOB').text(response.DOB);
                            $('.Contact').text(response.Contact);
                            $('.PresentAddress').text(response.PresentAddress);
                            $('.Username').text(response.Username);

                        },
                        error: function (xhr, status, error) {
                            console.error('Error fetching user info:', error);
                        }
                    });
                }

                // Call the function to fetch and display user info
                fetchUserInfo();
            });

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