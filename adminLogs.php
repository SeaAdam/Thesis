<?php
include 'login.php';
include 'includes/dbconn.php';

if (!isset($_SESSION['username']) || $_SESSION['loginType'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$adminUsername = $_SESSION['username'];

include 'notification_functions.php';
$notificationsAdmin = fetchNotificationsAdmin();
$unread_count = countUnreadNotificationsAdmin();

$sql = "SELECT * FROM action_logs ORDER BY timestamp DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_all'])) {
    $delete_sql = "DELETE FROM action_logs";
    $conn->query($delete_sql);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />
    <title>Login Logs</title>

    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="build/css/custom.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

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

                <div class="button-container">
                    <button class="btn btn-primary" id="printData">Print All Data</button>
                    <button class="btn btn-danger" id="deleteData">Delete All Data</button>
                </div>

                <table id="logTable" class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>User ID</th>
                            <th>Action</th>
                            <th>Details</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($log = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($log['user_id']) ?></td>
                                    <td><?= htmlspecialchars($log['action']) ?></td>
                                    <td><?= htmlspecialchars($log['details']) ?></td>
                                    <td><?= htmlspecialchars($log['timestamp']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">
                                    <div class="alert alert-warning" role="alert">
                                        No action logs found.
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <button class="btn btn-info" id="logTableOverview" data-bs-toggle="tooltip" data-bs-html="true" title="
    <div style='text-align: left; max-width: 260px; font-size: 14px; line-height: 1.5;'>
        <strong>📜 Log Table Overview:</strong><br>
        <span style='color: #007bff;'>🔹</span> Records <strong>user activities</strong> in the system.<br>
        <span style='color: #28a745;'>📌</span> Includes <strong>User ID, Action, Details, Timestamp</strong>.<br>
        <span style='color: #17a2b8;'>🔍</span> Helps track <strong>security & system usage</strong>.<br>
        <span style='color: #dc3545;'>⚠️</span> Logs cannot be <strong>modified</strong> once recorded.<br>
    </div>
">
    Table Overview 🛈
</button>


            </div>
        </div>
    </div>

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <script src="build/js/custom.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        // Print All Data
        document.getElementById('printData').addEventListener('click', function () {
            window.print();
        });

        // Delete All Data with SweetAlert Confirmation
        document.getElementById('deleteData').addEventListener('click', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action will delete all logs permanently!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete all!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform deletion via AJAX
                    $.ajax({
                        url: 'delete_login_logs.php',
                        type: 'POST',
                        success: function (response) {
                            Swal.fire(
                                'Deleted!',
                                'All logs have been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function () {
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting logs.',
                                'error'
                            );
                        }
                    });
                }
            });
        });

        $(document).ready(function () {
            $('#logTable').DataTable({
                "paging": true,       // Enable pagination
                "searching": true,    // Enable searching
                "ordering": true,     // Enable sorting
                "info": true,         // Display info like "Showing 1 to 10 of 50 entries"
                "pageLength": 10,     // Set the default page length
                "order": [[3, 'desc']] // Sort by the "Timestamp" column in descending order
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