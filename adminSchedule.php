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

    <title>Admin Patient Schedule</title>

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
                if (isset($_SESSION['successEditSchedule'])) {
                    echo "
                        <div class='alert alert-success alert-dismissable' id='alert' style='background: green;border-radius: 5px;padding:10px;color: #fff;margin:50px 0px 10px 0px;'>
                            <h4><i class='fa fa-check-circle' aria-hidden='true'></i> Success!</h4>
                            <p>Schedule is edited!;</p>
                        </div>
                    ";

                    // Clear the alert message
                    unset($_SESSION['successEditSchedule']);
                }

                if (isset($_SESSION['save'])) {
                    echo "
                        <div class='alert alert-success alert-dismissable' id='alert' style='background: green;border-radius: 5px;padding:10px;color: #fff;margin:50px 0px 10px 0px;'>
                            <h4><i class='fa fa-check-circle' aria-hidden='true'></i> Success!</h4>
                            <p>Event added successfully!;</p>
                        </div>
                    ";

                    // Clear the alert message
                    unset($_SESSION['save']);
                }

                if (isset($_SESSION['deleted'])) {
                    echo "
                        <div class='alert alert-dark alert-dismissable' id='alert' style='background: gray;border-radius: 5px;padding:10px;color: #fff;margin:50px 0px 10px 0px;'>
                            <h4><i class='fa fa-check-circle' aria-hidden='true'></i> Deleted!</h4>
                            <p>Record has been deleted!;</p>
                        </div>
                    ";

                    // Clear the alert message
                    unset($_SESSION['deleted']);
                }

                if (isset($_SESSION['errorevent'])) {
                    echo "
                        <div class='alert alert-danger alert-dismissable' id='alert' style='background: red;border-radius: 5px;padding:10px;color: #fff;margin:50px 0px 10px 0px;'>
                            <h4><i class='fa fa-exclamation-triangle'></i> Error!</h4>
                            <p>The selected date range is already occupied by another event!;</p>
                        </div>
                    ";

                    // Clear the alert message
                    unset($_SESSION['errorevent']);
                }
                ?>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    New Schedule
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add New Schedule</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="add_sched_add_timeslots.php" method="POST">
                                    <!-- Slots (Readonly, Auto-generated) -->
                                    <div class="mb-3">
                                        <label for="Slots" class="form-label">Slots</label>
                                        <input type="number" class="form-control" id="Slots" name="Slots" readonly>
                                    </div>

                                    <!-- Slots Date -->
                                    <div class="mb-3">
                                        <label for="SlotsDate" class="form-label">Slots Date</label>
                                        <input type="date" class="form-control" id="SlotsDate" name="SlotsDate"
                                            required>
                                    </div>

                                    <!-- Start Time -->
                                    <div class="mb-3">
                                        <label for="StartTime" class="form-label">Start Time</label>
                                        <input type="time" class="form-control" id="StartTime" name="StartTime"
                                            required>
                                    </div>

                                    <!-- End Time -->
                                    <div class="mb-3">
                                        <label for="EndTime" class="form-label">End Time</label>
                                        <input type="time" class="form-control" id="EndTime" name="EndTime" required>
                                    </div>

                                    <!-- Durations -->
                                    <div class="mb-3">
                                        <label for="Durations" class="form-label">Durations (in minutes)</label>
                                        <input type="number" class="form-control" id="Durations" name="Durations"
                                            required>
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


                <table id="scheduleTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Date</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'includes/dbconn.php';

                        $sql = "SELECT * FROM client_schedule";
                        $query = $conn->query($sql);
                        while ($row = $query->fetch_assoc()) {
                            ?>
                            <tr>
                                <th scope="row"><?php echo $row['id']; ?></th>
                                <td><?php echo $row['schedule_date']; ?></td>
                                <td>
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
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


        <?php include "includes/booking_modal.php"; ?>

        <script>
            $(function () {
                $('.edit').click(function (e) {
                    e.preventDefault();
                    $('#editSchedule').modal('show');
                    var id = $(this).data('id');
                    getRow(id);
                });

                $('.delete').click(function (e) {
                    e.preventDefault();
                    $('#delete').modal('show');
                    var id = $(this).data('id');
                    getRow(id);
                });

            });



            function getRow(id) {
                $.ajax({
                    type: 'POST',
                    url: 'booking_row_sched.php',
                    data: { id: id },
                    dataType: 'json',
                    success: function (response) {
                        $('.ID').val(response.ID);
                        $('.Slots').html(response.Slots);
                        $('.Slots_Date').html(response.Slots_Date);
                        $('#editSlots').val(response.Slots);
                        $('#Slots_Date').val(response.Slots_Date);
                        $('#Start_Time').val(response.Start_Time);
                        $('#End_Time').val(response.End_Time);
                        $('#editDurations').val(response.Durations);

                    }
                });
            }


            $(document).ready(function () {
                window.setTimeout(function () {
                    $("#alert").fadeTo(1000, 0).slideUp(1000, function () {
                        $(this).remove();
                    });
                }, 5000);
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

            document.addEventListener('DOMContentLoaded', function () {
                const startTimeInput = document.getElementById('StartTime');
                const endTimeInput = document.getElementById('EndTime');
                const durationsInput = document.getElementById('Durations');
                const slotsInput = document.getElementById('Slots');

                function calculateSlots() {
                    const startTime = startTimeInput.value;
                    const endTime = endTimeInput.value;
                    const duration = parseInt(durationsInput.value, 10);

                    if (startTime && endTime && duration > 0) {
                        const start = new Date(`1970-01-01T${startTime}:00`);
                        const end = new Date(`1970-01-01T${endTime}:00`);

                        if (end > start) {
                            const totalMinutes = (end - start) / 60000; // Convert milliseconds to minutes
                            const slots = Math.floor(totalMinutes / duration);
                            slotsInput.value = slots; // Update the Slots input
                        } else {
                            slotsInput.value = 0; // Reset if end time is earlier than start time
                        }
                    } else {
                        slotsInput.value = 0; // Reset if fields are incomplete
                    }
                }

                // Attach event listeners
                startTimeInput.addEventListener('input', calculateSlots);
                endTimeInput.addEventListener('input', calculateSlots);
                durationsInput.addEventListener('input', calculateSlots);
            });

            $(document).ready(function () {
                $('#scheduleTable').DataTable({
                    "paging": true,       // Enable pagination
                    "searching": true,    // Enable searching
                    "ordering": true,     // Enable sorting
                    "info": true,         // Display info like "Showing 1 to 10 of 50 entries"
                    "pageLength": 10,     // Set the default page length
                    "order": [[0, 'asc']] // Set default sorting by the first column (ID) in ascending order
                });
            });


        </script>

</body>

</html>