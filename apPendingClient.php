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

    <title>Appointments Pending</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">

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

            <?php include 'top_nav_admin.php'; ?>

            <div class="right_col" role="main">
                <h2>Pending Transactions</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Status</th>
                            <th scope="col">Transaction No.</th>
                            <th scope="col">Services</th>
                            <th scope="col">Date Appointment</th>
                            <th scope="col">Actions</th>
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
            cb.services AS services_ids, 
            cb.date_appointment
        FROM 
            client_booking cb
        WHERE 
            cb.status = 'Pending'";

                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                // Split the services_ids into an array
                                $servicesIds = explode(',', $row['services_ids']);

                                // Initialize an array to hold the service names
                                $serviceNames = [];

                                // Fetch each service name
                                foreach ($servicesIds as $serviceId) {
                                    // Query to get the service name for each service ID
                                    $serviceQuery = "SELECT service_name FROM company_services WHERE id = ?";
                                    $serviceStmt = $conn->prepare($serviceQuery);
                                    $serviceStmt->bind_param('i', $serviceId);
                                    $serviceStmt->execute();
                                    $serviceResult = $serviceStmt->get_result();
                                    if ($serviceResult && $serviceRow = $serviceResult->fetch_assoc()) {
                                        $serviceNames[] = $serviceRow['service_name']; // Add the service name to the array
                                    }
                                    $serviceStmt->close();
                                }

                                // Join the service names into a comma-separated string
                                $servicesDisplay = implode(', ', $serviceNames);

                                echo "<tr>
                <td>{$row['id']}</td>
                <td><span class='bg-dark text-white'>{$row['status']}</span></td>
                <td>{$row['booking_no']}</td>
                <td>{$servicesDisplay}</td> <!-- Display the services here -->
                <td>{$row['date_appointment']}</td>
                <td>
                    <button class='btn btn-primary btn-sm' onclick='confirmAction({$row['id']}, \"Approved\")'>Approve</button>
                    <button class='btn btn-success btn-sm' onclick='confirmAction({$row['id']}, \"Completed\")'>Complete</button>
                    <button class='btn btn-danger btn-sm' onclick='confirmAction({$row['id']}, \"Rejected\")'>Reject</button>
                </td>
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
            function updateTransactionStatus(id, status) {
                // Use SweetAlert for the confirmation and status update
                Swal.fire({
                    title: `Are you sure you want to ${status.toLowerCase()} this transaction?`,
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: `Yes, ${status.toLowerCase()} it!`
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

                        // AJAX request to update the transaction status and send notification
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "update_status_client.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                        xhr.onreadystatechange = function () {
                            if (xhr.readyState == 4 && xhr.status == 200) {
                                // Hide the loading spinner
                                Swal.close();

                                if (xhr.responseText.trim() === 'Success') {
                                    Swal.fire(
                                        `${status}!`,
                                        `The transaction has been ${status.toLowerCase()} successfully.`,
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
                });
            }

            function confirmAction(clientBookingID, action) {
                // This function now just triggers the update with SweetAlert
                updateTransactionStatus(clientBookingID, action);
            }

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