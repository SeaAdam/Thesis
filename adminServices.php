<?php
session_start();
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

    <title>Admin Services</title>

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
                        <a href="index.php" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella
                                Alela!</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="images/img.jpg" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>John Doe</h2>
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
                                    <img src="images/img.jpg" alt="">John Doe
                                </a>
                                <div class="dropdown-menu dropdown-usermenu pull-right"
                                    aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="javascript:;"> Profile</a>
                                    <a class="dropdown-item" href="javascript:;">
                                        <span class="badge bg-red pull-right">50%</span>
                                        <span>Settings</span>
                                    </a>
                                    <a class="dropdown-item" href="javascript:;">Help</a>
                                    <a class="dropdown-item" href="login.php"><i class="fa fa-sign-out pull-right"></i>
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
                if (isset($_SESSION['successEditservices'])) {
                    echo "
                        <div class='alert alert-success alert-dismissable' id='alert' style='background: green;border-radius: 5px;padding:10px;color: #fff;margin:50px 0px 10px 0px;'>
                            <h4><i class='fa fa-check-circle' aria-hidden='true'></i> Success!</h4>
                            <p>Services is edited!;</p>
                        </div>
                    ";

                    unset($_SESSION['successEditservices']);
                }

                if (isset($_SESSION['saveServices'])) {
                    echo "
                        <div class='alert alert-success alert-dismissable' id='alert' style='background: green;border-radius: 5px;padding:10px;color: #fff;margin:50px 0px 10px 0px;'>
                            <h4><i class='fa fa-check-circle' aria-hidden='true'></i> Success!</h4>
                            <p>New Services added successfully!;</p>
                        </div>
                    ";

                    unset($_SESSION['saveServices']);
                }

                if (isset($_SESSION['errorServices'])) {
                    echo "
                        <div class='alert alert-danger alert-dismissable' id='alert' style='background: red;border-radius: 5px;padding:10px;color: #fff;margin:50px 0px 10px 0px;'>
                            <h4><i class='fa fa-exclamation-triangle'></i> Error!</h4>
                            <p>The selected service is already in the record!;</p>
                        </div>
                    ";

                    // Clear the alert message
                    unset($_SESSION['errorServices']);
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
                ?>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    New Services
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add New Services;</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="add_services.php" method="POST">
                                    <div class="mb-3">
                                        <label for="Service" class="form-label">Service :</label>
                                        <input type="text" class="form-control" id="Services" name="Services"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Cost" class="form-label">Cost :</label>
                                        <input type="number" class="form-control" id="Cost" name="Cost" step=0.01 required>
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
                            <th scope="col">#</th>
                            <th scope="col">Services</th>
                            <th scope="col">Cost</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'includes/dbconn.php';

                        $sql = "SELECT * FROM services_table";
                        $query = $conn->query($sql);
                        while ($row = $query->fetch_assoc()) {
                            ?>

                            <tr>
                                <th scope="row"><?php echo $row['ID']; ?></th>
                                <td><?php echo $row['Services'] ?></td>
                                <td><?php echo $row['Cost'] ?></td>

                                <td>
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
                    $('#editServices').modal('show');
                    var id = $(this).data('id');
                    getRow(id);
                });

                $('.delete').click(function (e) {
                    e.preventDefault();
                    $('#deleteServices').modal('show');
                    var id = $(this).data('id');
                    getRow(id);
                });

            });


            function getRow(id) {
                $.ajax({
                    type: 'POST',
                    url: 'booking_row_services.php',
                    data: { id: id },
                    dataType: 'json',
                    success: function (response) {
                        $('.ID').val(response.ID);
                        $('.Service').html(response.Services);
                        $('.Cost').html(response.Cost);
                        $('#editService').val(response.Services);
                        $('#editCost').val(response.Cost);
                    }
                });
            }
        </script>

</body>

</html>