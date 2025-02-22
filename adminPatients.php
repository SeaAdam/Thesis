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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <title>Admin Patients</title>

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

                    <?php include('sidebar.php'); ?>
                </div>
            </div>

            <?php include 'top_nav_admin.php'; ?>

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
                <table id="registrationTable" class="table table-striped table-bordered">
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
                                <td><?php echo $row['FirstName'] . ' ' . $row['MI'] . ' ' . $row['LastName']; ?></td>
                                <td><?php echo $row['Gender']; ?></td>
                                <td><?php echo $row['Age']; ?></td>
                                <td><?php echo $row['DOB']; ?></td>
                                <td><?php echo $row['Contact']; ?></td>
                                <td><?php echo $row['PresentAddress']; ?></td>
                                <td>
                                    <a href="#" data-id="<?php echo $row['ID']; ?>" class="btn btn-info btn-sm view"><i
                                            class="fa fa-eye" aria-hidden="true"></i> View</a>
                                    <a href="#" data-id="<?php echo $row['ID']; ?>" class="btn btn-success btn-sm edit"><i
                                            class="fa fa-edit" aria-hidden="true"></i> Edit</a>
                                    <a href="#" data-id="<?php echo $row['ID']; ?>" class="btn btn-danger btn-sm delete"><i
                                            class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <button class="btn btn-info" id="registrationOverview" data-bs-toggle="tooltip" data-bs-html="true"
                    title="
    <div style='text-align: left; max-width: 270px; font-size: 14px; line-height: 1.5;'>
        <strong>🩺 Patient Registration Table Overview:</strong><br>
        <span style='color: #007bff;'>🔹</span> Displays <strong>Unique ID</strong>, <strong>Patient Name</strong>, <strong>Gender</strong>, <strong>Age</strong>, <strong>Date of Birth</strong>, and <strong>Contact Information</strong>.<br>
        <span style='color: #28a745;'>📍</span> Includes <strong>Present Address</strong> for easy reference.<br>
        <span style='color: #ffc107;'>⚡</span> Enables quick actions: <strong>View</strong>, <strong>Edit</strong>, and <strong>Delete</strong> records.<br>
        <span style='color: #17a2b8;'>🔍</span> Supports <em>searching, sorting, and pagination</em>.<br>
        <span style='color: #dc3545;'>❗</span> Ensures accurate patient record management.<br>
    </div>
">
                    Table Overview 🛈
                </button>


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
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

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

                        // Display email
                        $('.Email').text(response.email); // Add this line

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

            $(document).ready(function () {
                $('#registrationTable').DataTable({
                    "paging": true,       // Enable pagination
                    "searching": true,    // Enable searching
                    "ordering": true,     // Enable sorting
                    "info": true,         // Display info like "Showing 1 to 10 of 50 entries"
                    "pageLength": 10,     // Set the default page length
                    "order": [[0, 'asc']] // Set default sorting by the first column (Unique ID) in ascending order
                });

                // Enable Bootstrap Tooltip with Custom Styling
                $('[data-bs-toggle="tooltip"]').tooltip({
                    html: true,
                    placement: "right",
                    trigger: "hover",
                });
            });
        </script>

</body>

</html>