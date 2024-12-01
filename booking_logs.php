<?php
include 'login.php';
include 'includes/dbconn.php';

// Fetch logs from the database
$sql = "SELECT * FROM booking_logs ORDER BY timestamp DESC";
$result = $conn->query($sql);

if (!isset($_SESSION['username']) || $_SESSION['loginType'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$adminUsername = $_SESSION['username'];

include 'notification_functions.php';
$notificationsAdmin = fetchNotificationsAdmin();
$unread_count = countUnreadNotificationsAdmin();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />
    <title>Admin Booking Logs</title>

    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="build/css/custom.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .read {
            background-color: #f0f0f0;
        }

        .unread {
            background-color: #e0e0e0;
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

                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="images/admin-icon.jpg" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2><?php echo htmlspecialchars($adminUsername); ?></h2>
                        </div>
                    </div>

                    <br />

                    <?php include('sidebar.php'); ?>
                </div>
            </div>

            <?php include 'top_nav_admin.php'; ?>

            <div class="right_col" role="main">
                <!-- Action buttons for Print and Delete All Data -->
                <div class="mb-3">
                    <button class="btn btn-primary" id="printData">Print Logs</button>
                    <button class="btn btn-danger" id="deleteLogs">Delete All Logs</button>
                </div>

                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Timestamp</th>
                            <th>Log Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['timestamp']) ?></td>
                                    <td><?= htmlspecialchars($row['message']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2" class="text-center">
                                    <div class="alert alert-warning" role="alert">
                                        No logs found.
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <script src="build/js/custom.min.js"></script>

    <script>
        // Print All Data
        document.getElementById('printData').addEventListener('click', function () {
            window.print();
        });


        // SweetAlert for Delete All Logs Button
        document.getElementById('deleteLogs').addEventListener('click', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete all the booking logs.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Make an AJAX call to delete the logs from the database
                    $.ajax({
                        url: 'delete_booking_logs.php', // PHP script that handles deletion
                        method: 'POST',
                        success: function (response) {
                            Swal.fire(
                                'Deleted!',
                                'All booking logs have been deleted.',
                                'success'
                            ).then(() => {
                                location.reload(); // Reload the page to reflect changes
                            });
                        },
                        error: function () {
                            Swal.fire(
                                'Error!',
                                'There was an issue deleting the logs.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>