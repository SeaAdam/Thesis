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

    <title>Admin Patients</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

            <div class="right_col" role="main">
                <?php
                if (isset($_SESSION['AddednewClients'])) {
                    echo "
                                    <div class='alert alert-success alert-dismissable' id='alert' style='background: green;border-radius: 5px;padding:10px;color: #fff;margin:50px 0px 10px 0px;'>
                                        <h4><i class='fa fa-check-circle' aria-hidden='true'></i> Success!</h4>
                                        <p>Added New Clients Successfully!;</p>
                                    </div>
                                ";

                    unset($_SESSION['AddednewClients']);
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

                if (isset($_SESSION['deletedClient'])) {
                    echo "
                                    <div class='alert alert-dark alert-dismissable' id='alert' style='background: green;border-radius: 5px;padding:10px;color: #fff;margin:50px 0px 10px 0px;'>
                                        <h4><i class='fa fa-check-circle' aria-hidden='true'></i> Success</h4>
                                        <p>Patients Record Deleted!;</p>
                                    </div>
                                ";

                    // Clear the alert message
                    unset($_SESSION['deletedClient']);
                }

                if (isset($_SESSION['successEditClient'])) {
                    echo "
                                    <div class='alert alert-dark alert-dismissable' id='alert' style='background: green;border-radius: 5px;padding:10px;color: #fff;margin:50px 0px 10px 0px;'>
                                        <h4><i class='fa fa-check-circle' aria-hidden='true'></i> Success</h4>
                                        <p>Patients Record Edited Successfully!;</p>
                                    </div>
                                ";

                    // Clear the alert message
                    unset($_SESSION['successEditClient']);
                }
                ?>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    + New Client
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add New Client;</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="registrationForm" action="add_clients.php" method="POST">
                                    <!-- First Row: First Name, Middle Initial, Last Name -->
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="client_name">Client Name</label>
                                            <input type="text" class="form-control" id="ClientName" name="client_name"
                                                placeholder="Client Name" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="CompanyName">Company Name</label>
                                            <input type="text" class="form-control" id="CompanyName" name="company_name"
                                                placeholder="Company Name">
                                        </div>

                                    </div>

                                    <div class="form-row mb-3">
                                        <div class="col">
                                            <label for="position">Position</label>
                                            <input type="text" class="form-control" id="Position" name="position"
                                                placeholder="Position" required>
                                        </div>
                                    </div>


                                    <!-- Third Row: Contact, Address -->
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="contact_number">Contact Number</label>
                                            <input type="text" class="form-control" id="ContactNumber"
                                                placeholder="Contact Number" name="contact_number" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="address">Address</label>
                                            <input type="text" class="form-control" id="Address" placeholder="Address"
                                                name="address" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="email_address">Email Address</label>
                                            <input type="text" class="form-control" id="email_address" placeholder="@"
                                                name="email_address" required>
                                        </div>

                                    </div>


                                    <!-- Fifth Row: Password, Confirm Password -->
                                    <div class="form-row">

                                        <div class="form-group col-md-6">
                                            <label for="Username">Username</label>
                                            <input type="text" class="form-control" id="Username" placeholder="Username"
                                                name="Username" autocomplete="off" required>
                                        </div>

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
                <?php
                require 'autoloader.php'; 

                use PHPMailer\PHPMailer\PHPMailer;
                use PHPMailer\PHPMailer\Exception as PHPMailerException;

                function notifyClientByEmail($to, $subject, $message)
                {
                    // Use PHPMailer for email sending
                    $mail = new PHPMailer(true);
                    try {
                        // Server settings
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
                        $mail->SMTPAuth = true; // Enable SMTP authentication
                        $mail->Username = 'brainmasterdc@gmail.com'; // SMTP username
                        $mail->Password = 'xmpu aewf sozv wibb'; // SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
                        $mail->Port = 587; // TCP port to connect to
                
                        // Recipients
                        $mail->setFrom('brainmasterdc@gmail.com', 'Brain Master Diagnostic Center');
                        $mail->addAddress($to); // Add a recipient
                
                        // Content
                        $mail->isHTML(true); // Set email format to HTML
                        $mail->Subject = $subject;
                        $mail->Body = $message;

                        // Send the email
                        $mail->send();
                        return true;
                    } catch (Exception $e) {
                        // Handle error
                        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
                        return false;
                    }
                }

                // Your existing code for approval/rejection
                include 'includes/dbconn.php';

                if (isset($_GET['action']) && isset($_GET['id'])) {
                    $action = $_GET['action'];
                    $client_id = $_GET['id'];

                    if ($action == 'approve') {
                        // Fetch client details
                        $sql = "SELECT * FROM clients_info WHERE id = $client_id";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();

                            // Generate a username (avoid spaces)
                            $username = strtolower(preg_replace("/[^a-zA-Z0-9]/", "", $row['client_name'])) . rand(1000, 9999);
                            $password = bin2hex(random_bytes(4)); // Create a random password
                
                            // Insert into clients_account table
                            $insert_sql = "INSERT INTO clients_account (client_id, Username, Password) 
                           VALUES ('$client_id', '$username', '$password')";

                            if ($conn->query($insert_sql) === TRUE) {
                                // Update client status to approved
                                $update_sql = "UPDATE clients_info SET status = 'approved' WHERE id = $client_id";
                                if ($conn->query($update_sql) === TRUE) {
                                    // Send approval email
                                    $client_email = $row['email_address']; // Assuming the client's email is in the database
                                    $subject = "Your Client Account has been Approved!";
                                    $message = "Your account has been approved. Your login credentials are:<br>Username: $username<br>Password: $password";
                                    notifyClientByEmail($client_email, $subject, $message);

                                    // SweetAlert success with username and password
                                    echo "<script>
                        Swal.fire({
                            title: 'Client Approved!',
                            text: 'Client username: $username\\nPassword: $password',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'adminClients.php'; // Reload the page
                            }
                        });
                    </script>";
                                } else {
                                    // Error updating client status
                                    echo "<script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to update client status.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    </script>";
                                }
                            } else {
                                // Error inserting into clients_account
                                echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to create client account.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                </script>";
                            }
                        }
                    } elseif ($action == 'reject') {
                        // Update client status to rejected
                        $update_sql = "UPDATE clients_info SET status = 'rejected' WHERE id = $client_id";
                        if ($conn->query($update_sql) === TRUE) {
                            // Send rejection email
                            $client_email = $row['client_email']; // Assuming the client's email is in the database
                            $subject = "Your Client Account has been Rejected";
                            $message = "We regret to inform you that your account application has been rejected.";
                            notifyClientByEmail($client_email, $subject, $message);

                            // SweetAlert rejection
                            echo "<script>
                Swal.fire({
                    title: 'Client Rejected!',
                    text: 'The client has been rejected.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'adminClients.php'; // Reload the page
                    }
                });
            </script>";
                        } else {
                            // Error rejecting client
                            echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to reject client.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>";
                        }
                    }
                }
                ?>


                <!-- Your table structure starts here -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Client Name</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Position</th>
                            <th scope="col">Address</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Email</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM clients_info";
                        $query = $conn->query($sql);
                        while ($row = $query->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['client_name']; ?></td>
                                <td><?php echo $row['company_name']; ?></td>
                                <td><?php echo $row['position']; ?></td>
                                <td><?php echo $row['address']; ?></td>
                                <td><?php echo $row['contact_number']; ?></td>
                                <td><?php echo $row['email_address']; ?></td>

                                <!-- Display the status -->
                                <td>
                                    <?php
                                    if ($row['status'] == 'approved') {
                                        echo '<span class="badge badge-success">Approved</span>';
                                    } elseif ($row['status'] == 'pending') {
                                        echo '<span class="badge badge-warning">Pending</span>';
                                    } elseif ($row['status'] == 'rejected') {
                                        echo '<span class="badge badge-danger">Rejected</span>';
                                    }
                                    ?>

                                    <!-- Show Approve and Reject buttons only if status is 'pending' -->
                                    <?php if ($row['status'] == 'pending') { ?>
                                        <a href="adminClients.php?action=approve&id=<?php echo $row['id']; ?>"
                                            class="btn btn-success btn-sm">Approve</a>
                                        <a href="adminClients.php?action=reject&id=<?php echo $row['id']; ?>"
                                            class="btn btn-danger btn-sm">Reject</a>
                                    <?php } else { ?>
                                        <span class="text-muted">Action Completed</span>
                                    <?php } ?>
                                </td>

                                <!-- Actions (view, edit, delete) -->
                                <td>
                                    <a href="#" data-id="<?php echo $row['id']; ?>" class="btn btn-info btn-sm view"><i
                                            class="fa fa-edit" aria-hidden="true"></i> View</a>
                                    <a href="#" data-id="<?php echo $row['id']; ?>" class="btn btn-success btn-sm edit"><i
                                            class="fa fa-edit" aria-hidden="true"></i> Edit</a>
                                    <a href="#" data-id="<?php echo $row['id']; ?>" class="btn btn-danger btn-sm delete"><i
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
                    $('#editClients').modal('show');
                    var id = $(this).data('id');
                    getRow(id);
                });

                $('.delete').click(function (e) {
                    e.preventDefault();
                    $('#deleteClients').modal('show');
                    var id = $(this).data('id');
                    getRow(id);
                });

                $('.view').click(function (e) {
                    e.preventDefault();
                    $('#viewClients').modal('show');
                    var id = $(this).data('id');
                    getRow(id);
                });

            });


            function getRow(id) {
                $.ajax({
                    type: 'POST',
                    url: 'booking_row_clients.php',
                    data: { id: id },
                    dataType: 'json',
                    success: function (response) {
                        $('.client_name').text(response.client_name);
                        $('.ID').val(response.id);
                        $('.company_name').text(response.company_name);
                        $('.position').text(response.position);
                        $('.contact_number').text(response.contact_number);
                        $('.address').text(response.address);
                        $('.email_address').text(response.email_address);
                        $('.Username').text(response.Username);

                        $('#Eclient_name').val(response.client_name);
                        $('#Ecompany_name').val(response.company_name);
                        $('#Eposition').val(response.position);
                        $('#Econtact_number').val(response.contact_number);
                        $('#Eaddress').val(response.address);
                        $('#Eemail_address').val(response.email_address);

                        // Populate the Username and Password fields
                        $('#EUUsername').val(response.Username); // Set Username
                        $('#EUPassword').val(response.Password); // Set Password (unhashed)


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
        </script>

</body>

</html>