<?php
include 'includes/dbconn.php';

include 'login.php';

if (!isset($_SESSION['username']) || $_SESSION['loginType'] !== 'clients') {
    header('Location: index.php'); // Redirect to login page if not logged in as admin
    exit();
}

// Retrieve the admin username from the session
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

// Fetch user details based on client_id (from $id)
$sql = "SELECT * FROM clients_info WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    // Check if there was an error in preparing the statement
    die('Prepare failed: ' . $conn->error);
}

// Bind the client ID to the query (integer 'i' type)
$stmt->bind_param('i', $id);  // 'i' for integer type since $id is an integer
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the user data
    $user = $result->fetch_assoc();
} else {
    // If no matching user is found
    echo "User not found.";
    exit();
}

// Close the statement and the connection
$stmt->close();
$conn->close();

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

                                </a>
                                <ul class="dropdown-menu list-unstyled msg_list" role="menu"
                                    aria-labelledby="navbarDropdown1">

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
                                    <?php echo htmlspecialchars($user['client_name']); ?>
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
                                                <th scope="row">Company Name</th>
                                                <td>
                                                <?php echo htmlspecialchars($user['company_name']); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Position</th>
                                                <td>
                                                <?php echo htmlspecialchars($user['position']); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Address</th>
                                                <td>
                                                <?php echo htmlspecialchars($user['address']); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Contact Number</th>
                                                <td>
                                                <?php echo htmlspecialchars($user['contact_number']); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Email Address</th>
                                                <td>
                                                <?php echo htmlspecialchars($user['email_address']); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Username</th>
                                                <td>
                                                <?php echo htmlspecialchars($clientUsername); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Action</th>
                                                <td>
                                                    <a href="#" data-id="<?php echo $user['id']; ?>"
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
                    $('#editClientProfile').modal('show');
                    var id = $(this).data('id');
                    getRow(id);
                });
            });

            function getRow(id) {
                $.ajax({
                    type: 'GET',
                    url: 'fetch_client_editProfile.php',
                    data: { id: id },
                    dataType: 'json',
                    success: function (response) {
                        if (response.error) {
                            console.error('Error:', response.error);
                        } else {
                            $('.ID').val(response.id);
                            $('#Ecompany_name').val(response.company_name);
                            $('#Eclient_name').val(response.client_name);
                            $('#Eposition').val(response.position);
                            $('#Eaddress').val(response.address);
                            $('#Econtact_number').val(response.contact_number);
                            $('#Eemail_address').val(response.email_address);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });
            }

            $('#editClientProfile form').submit(function (e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: 'update_client_editProfile.php',
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
                                    $('#editClientProfile').modal('hide');
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

        </script>


</body>

</html>