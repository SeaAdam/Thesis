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

    <title>Admin Patients</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">

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
                                <li><a href="adminDashboard.php"><i class="fa fa-home"></i> Dashboad </a>
                                </li>
                                <li><a href="adminEvents.php"><i class="fa fa-edit"></i> Events </a>
                                </li>
                                <li><a href="adminPatients.php"><i class="fa fa-desktop"></i> Patients </a>
                                </li>
                                <li><a><i class="fa fa-table"></i> Appointment <span class="fa fa-chevron-down"></span>
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
                                        <li><a href="adminSchedule.php">Schedule</a></li>
                                        <li><a href="adminHolidays.php">Holidays</a></li>
                                        <li><a href="adminServices.php">Services</a></li>
                                    </ul>
                                </li>
                                <li><a href="adminContacts.php"><i class="fa fa-table"></i> Contacts </a>
                                </li>
                                <li><a><i class="fa fa-table"></i> Database <span class="fa fa-chevron-down"></span>
                                    </a>
                                    <ul class="nav child_menu">
                                        <li><a href="#">Backup</a></li>
                                        <li><a href="#">Restore</a></li>
                                    </ul>
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
                <?php
                if (isset($_SESSION['AddednewPatients'])) {
                    echo "
                                    <div class='alert alert-success alert-dismissable' id='alert' style='background: green;border-radius: 5px;padding:10px;color: #fff;margin:50px 0px 10px 0px;'>
                                        <h4><i class='fa fa-check-circle' aria-hidden='true'></i> Success!</h4>
                                        <p>Added New Patient Successfully!;</p>
                                    </div>
                                ";

                    unset($_SESSION['AddednewPatients']);
                }


                if (isset($_SESSION['errorUserAlreadyAdded'])) {
                    echo "
                                    <div class='alert alert-dark alert-dismissable' id='alert' style='background: red;border-radius: 5px;padding:10px;color: #fff;margin:50px 0px 10px 0px;'>
                                        <h4><i class='fa fa-check-circle' aria-hidden='true'></i> Error!</h4>
                                        <p>User Information Already Registered!;</p>
                                    </div>
                                ";

                    // Clear the alert message
                    unset($_SESSION['errorUserAlreadyAdded']);
                }

                if (isset($_SESSION['deletedPatients'])) {
                    echo "
                                    <div class='alert alert-dark alert-dismissable' id='alert' style='background: green;border-radius: 5px;padding:10px;color: #fff;margin:50px 0px 10px 0px;'>
                                        <h4><i class='fa fa-check-circle' aria-hidden='true'></i> Success</h4>
                                        <p>Patients Record Deleted!;</p>
                                    </div>
                                ";

                    // Clear the alert message
                    unset($_SESSION['deletedPatients']);
                }

                if (isset($_SESSION['successEditPatients'])) {
                    echo "
                                    <div class='alert alert-dark alert-dismissable' id='alert' style='background: green;border-radius: 5px;padding:10px;color: #fff;margin:50px 0px 10px 0px;'>
                                        <h4><i class='fa fa-check-circle' aria-hidden='true'></i> Success</h4>
                                        <p>Patients Record Edited Successfully!;</p>
                                    </div>
                                ";

                    // Clear the alert message
                    unset($_SESSION['successEditPatients']);
                }
                ?>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    + New Patient
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add New Patient;</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="registrationForm" action="add_patients.php" method="POST">
                                    <!-- First Row: First Name, Middle Initial, Last Name -->
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="FirstName">First Name</label>
                                            <input type="text" class="form-control" id="FirstName" name="FirstName"
                                                placeholder="First Name" required>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="MI">M.I.</label>
                                            <input type="text" class="form-control" id="MI" name="MI" placeholder="M.I."
                                                maxlength="1">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="LastName">Last Name</label>
                                            <input type="text" class="form-control" id="LastName" name="LastName"
                                                --placeholder="Last Name" required>
                                        </div>
                                    </div>

                                    <!-- Second Row: Gender, Date of Birth, Age -->
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="Gender">Gender</label>
                                            <select id="Gender" class="form-control" name="Gender" required>
                                                <option value="" disabled selected>Choose...</option>
                                                <option>Male</option>
                                                <option>Female</option>
                                                <option>Other</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="DOB">Date of Birth</label>
                                            <input type="date" class="form-control" id="DOB" name="DOB" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="Age">Age</label>
                                            <input type="number" class="form-control" id="Age" placeholder="Age"
                                                name="Age" required>
                                        </div>
                                    </div>

                                    <!-- Third Row: Contact, Address -->
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="Contact">Contact</label>
                                            <input type="text" class="form-control" id="Contact" placeholder="Contact"
                                                name="Contact" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="PresentAddress">Address</label>
                                            <input type="text" class="form-control" id="PresentAddress"
                                                placeholder="PresentAddress" name="PresentAddress" required>
                                        </div>
                                    </div>

                                    <!-- Fourth Row: Username -->
                                    <div class="form-group" style="margin-left: 0; width: 100%;">
                                        <label for="Username">Username</label>
                                        <input type="text" class="form-control" id="Username" placeholder="Username"
                                            name="Username" autocomplete="off" required>
                                    </div>

                                    <!-- Fifth Row: Password, Confirm Password -->
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="Password">Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="Password"
                                                    name="Password" placeholder="Password" required
                                                    pattern="(?=.*\d)(?=.*[a-zA-Z]).{8,}"
                                                    title="Password must be at least 8 characters long and contain both numbers and letters">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="togglePassword">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="ConfirmPassword">Confirm Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="ConfirmPassword"
                                                    name="ConfirmPassword" placeholder="Confirm Password" required
                                                    pattern="(?=.*\d)(?=.*[a-zA-Z]).{8,}"
                                                    title="Password must be at least 8 characters long and contain both numbers and letters">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="toggleConfirmPassword">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="passwordError" class="text-danger"></div>
                                    </div>

                                    <!-- I agree to the terms checkbox -->
                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" id="terms" required>
                                        <label class="form-check-label" for="terms">I agree to the terms and
                                            conditions</label>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Unique ID</th>
                            <th scope="col">Patient Name</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Age</th>
                            <th scope="col">Date of Birth</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Address</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'includes/dbconn.php';

                        $sql = "SELECT * FROM registration_table";
                        $query = $conn->query($sql);
                        while ($row = $query->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $row['ID']; ?></td>
                                <td> <?php
                                echo $row['FirstName'] . ' ' . $row['MI'] . ' ' . $row['LastName'];
                                ?></td>
                                <td><?php echo $row['Gender']; ?></td>
                                <td><?php echo $row['Age']; ?></td>
                                <td><?php echo $row['DOB']; ?></td>
                                <td><?php echo $row['Contact']; ?></td>
                                <td><?php echo $row['PresentAddress']; ?></td>

                                <td>
                                    <a href="#" data-id="<?php echo $row['ID']; ?>" class="btn btn-info btn-sm view"><i
                                            class="fa fa-edit" aria-hidden="true"></i>
                                        View</a>
                                    <a href="#" data-id="<?php echo $row['ID']; ?>" class="btn btn-success btn-sm edit"><i
                                            class="fa fa-edit" aria-hidden="true"></i>
                                        Edit</a>
                                    <a href="#" data-id="<?php echo $row['ID']; ?>" class="btn btn-danger btn-sm delete"><i
                                            class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                                </td>
                            </tr>
                            <?php
                        }
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

        <?php include "includes/booking_modal.php"; ?>

        <script>
            $(document).ready(function () {
                window.setTimeout(function () {
                    $("#alert").fadeTo(1000, 0).slideUp(1000, function () {
                        $(this).remove();
                    });
                }, 5000);
            });

            $(function () {
                $('.edit').click(function (e) {
                    e.preventDefault();
                    $('#editPatients').modal('show');
                    var id = $(this).data('id');
                    getRow(id);
                });

                $('.delete').click(function (e) {
                    e.preventDefault();
                    $('#deletePatients').modal('show');
                    var id = $(this).data('id');
                    getRow(id);
                });

                $('.view').click(function (e) {
                    e.preventDefault();
                    $('#viewPatients').modal('show');
                    var id = $(this).data('id');
                    getRow(id);
                });

            });


            function getRow(id) {
                $.ajax({
                    type: 'POST',
                    url: 'booking_row_patients.php',
                    data: { id: id },
                    dataType: 'json',
                    success: function (response) {
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

                        $('#EFirstName').val(response.FirstName);
                        $('#EMI').val(response.MI);
                        $('#ELastName').val(response.LastName);
                        $('#EGender').val(response.Gender);
                        $('#EAge').val(response.Age);
                        $('#EDOB').val(response.DOB);
                        $('#EContact').val(response.Contact);
                        $('#EPresentAddress').val(response.PresentAddress);
                        $('#EUsername').val(response.Username);
                        $('#EPassword').val(response.Password);
                        $('#EConfirmPassword').val(response.ConfirmPassword);
                    }
                });
            }

            $(document).ready(function () {
                $('#togglePassword').click(function () {
                    const passwordField = $('#Password');
                    const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
                    passwordField.attr('type', type);
                    $(this).find('i').toggleClass('fa-eye fa-eye-slash');
                });

                $('#toggleConfirmPassword').click(function () {
                    const confirmPasswordField = $('#ConfirmPassword');
                    const type = confirmPasswordField.attr('type') === 'password' ? 'text' : 'password';
                    confirmPasswordField.attr('type', type);
                    $(this).find('i').toggleClass('fa-eye fa-eye-slash');
                });

                $('#toggleLoginPassword').click(function () {
                    const passwordField = $('#loginPassword');
                    const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
                    passwordField.attr('type', type);
                    $(this).find('i').toggleClass('fa-eye fa-eye-slash');
                });

            });

            document.getElementById('registrationForm').addEventListener('submit', function (event) {
                // Clear previous error messages
                document.getElementById('passwordError').textContent = '';

                // Get password and confirm password values
                var password = document.getElementById('Password').value;
                var confirmPassword = document.getElementById('ConfirmPassword').value;

                // Check if passwords match
                if (password !== confirmPassword) {
                    document.getElementById('passwordError').textContent = 'Passwords do not match.';
                    event.preventDefault(); // Prevent form submission
                }
            });
        </script>

</body>

</html>