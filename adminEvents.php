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

    <title>Admin Events</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">

    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.css' rel='stylesheet' />

    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.js'></script>

    <style>
        #calendar {
            width: 100%;
            float: left;
        }

        #legend,
        #holidays {
            width: 25%;
            float: right;
            margin: 10px;
        }

        #legend ul,
        #holidays ul {
            list-style-type: none;
            padding: 0;
        }

        #legend li,
        #holidays li {
            margin-bottom: 10px;
        }

        #legend span {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }

        .custom-button {
            display: block;
            margin: 5px auto;
            padding: 5px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .custom-button:hover {
            background-color: #0056b3;
        }

        .modals {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .editContent {
            background-color: #fefefe;
            margin: 10vh auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
        }

        .edit,
        .delete {
            width: 50%;
            margin: 5px auto;
        }

        .fc .fc-button:not(:disabled) {
            background-color: lemonchiffon;
            color: black;

        }

        .fc .fc-button-primary:disabled {
            background-color: lemonchiffon;
            color: black;
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
                            <img src="images\admin-icon.jpg" alt="..." class="img-circle profile_img">
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
                                <li><a href="adminDashboard.php"><i class="fa fa-home"></i> Dashboard </a>
                                </li>
                                <li><a href="adminEvents.php"><i class="fa fa-edit"></i> Events </a>
                                </li>
                                <li><a href="adminClients.php"><i class="fa fa-desktop"></i> Clients </a>
                                </li>
                                <li><a><i class="fa fa-table"></i> Client Appointment <span class="fa fa-chevron-down"></span>
                                    </a>
                                    <ul class="nav child_menu">
                                        <li><a href="apPendingClient.php">Pending</a></li>
                                        <li><a href="apApprovedClient.php">Approved</a></li>
                                        <li><a href="apCompletedClient.php">Completed</a></li>
                                        <li><a href="apRejectedClient.php">Rejected</a></li>
                                    </ul>
                                </li>
                                <li><a href="adminPatients.php"><i class="fa fa-desktop"></i> Patients </a>
                                </li>
                                <li><a><i class="fa fa-table"></i> Patients Appointment <span class="fa fa-chevron-down"></span>
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
                                        <li><a href="clientSchedule.php">Client Schedule</a></li>
                                        <li><a href="adminSchedule.php">Patient Schedule</a></li>
                                        <li><a href="adminHolidays.php">Holidays</a></li>
                                        <li><a href="adminServices.php">Services</a></li>
                                    </ul>
                                </li>
                                <li><a href="adminContacts.php"><i class="fa fa-table"></i> Contacts </a>
                                </li>
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
                                    <?php echo ($adminUsername) ?>
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

                if (isset($_SESSION['success'])) {
                    echo "
                    <div class='alert alert-success alert-dismissable' id='alert' style='background: green;border-radius: 5px;padding:10px;color: #fff;margin:50px 0px 10px 0px;'>
                        <h4><i class='fa fa-check-circle' aria-hidden='true'></i> Success!</h4>
                        " . $_SESSION["success"] . ";
                    </div>
                ";

                    // Clear the alert message
                    unset($_SESSION['success']);
                }


                if (isset($_SESSION['error'])) {
                    echo "
                    <div class='alert alert-danger alert-dismissable' id='alert' style='background: red;border-radius: 5px;padding:10px;color: #fff;margin:50px 0px 10px 0px;'>
                        <h4><i class='fa fa-exclamation-triangle'></i> Error!</h4>
                        " . $_SESSION["error"] . ";
                    </div>
                ";

                    // Clear the alert message
                    unset($_SESSION['error']);
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

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                Events Calendar
                            </div>

                            <div class="card-body">
                                <div id="calendar"></div>
                            </div>
                            <div id="eventModal" class="modals">
                                <div class="modal-content">
                                    <span class="close">&times;</span>
                                    <h2 id="modalTitle"></h2>
                                    <p id="modalDescription"></p>
                                    <p><strong>Start:</strong> <span id="modalStart"></span></p>
                                    <p><strong>End:</strong> <span id="modalEnd"></span></p>

                                    <!-- Single Edit button -->
                                    <a href="#" id="editEventButton" class="btn btn-primary edit">Edit</a>
                                    <button id="deleteEventButton" class="btn btn-secondary delete">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Add New Event</h5>
                                <form action="add_event.php" method="POST">
                                    <div class="mb-3">
                                        <label for="eventTitle" class="form-label">Event Title</label>
                                        <input type="text" class="form-control" id="eventTitle" name="eventTitle"
                                            placeholder="Enter event title" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="eventDescription" class="form-label">Description</label>
                                        <textarea class="form-control" id="eventDescription" name="eventDescription"
                                            rows="3" placeholder="Enter event description" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="startDate" class="form-label">Start Date</label>
                                        <input type="date" class="form-control" id="startDate" name="startDate"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="endDate" class="form-label">End Date</label>
                                        <input type="date" class="form-control" id="endDate" name="endDate" required>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <button type="reset" class="btn btn-secondary">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>


                <!-- footer content -->
                <footer>
                    <div class="pull-right">
                        Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->

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
                $('#edit').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });

        });

        function getRow(id) {
            $.ajax({
                type: 'POST',
                url: 'booking_row.php',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    $('.ID').val(response.ID);
                    $('.title').html(response.Title)
                    $('#edit_title').val(response.Title);
                    $('#edit_description').val(response.Descriptions);
                    $('#edit_startDate').val(response.Start_dates);
                    $('#edit_EndDate').val(response.End_date);
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


    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var eventModal = document.getElementById('eventModal');
            var span = document.getElementsByClassName('close')[0];
            var editButton = document.getElementById('editEventButton');
            var deleteButton = document.getElementById('deleteEventButton');

            var selectedEventId = null; // To store the ID of the selected event

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                events: 'events.php',
                eventDidMount: function (info) {
                    let button = document.createElement('button');
                    button.textContent = info.event.extendedProps.buttonText || 'View';
                    button.className = 'custom-button';
                    button.onclick = function () {
                        // Populate modal with event details
                        document.getElementById('modalTitle').textContent = info.event.title;
                        document.getElementById('modalDescription').textContent = info.event.extendedProps.description;
                        document.getElementById('modalStart').textContent = info.event.start.toLocaleString();
                        document.getElementById('modalEnd').textContent = info.event.end ? info.event.end.toLocaleString() : 'N/A';

                        // Store the ID of the selected event
                        selectedEventId = info.event.id;

                        // Update the edit button's data-id attribute
                        editButton.setAttribute('data-id', selectedEventId);

                        // Show the event modal
                        eventModal.style.display = 'block';
                    };
                    info.el.appendChild(button);
                }
            });
            calendar.render();

            // Close the event modal
            span.onclick = function () {
                eventModal.style.display = 'none';
            }
            window.onclick = function (event) {
                if (event.target == eventModal) {
                    eventModal.style.display = 'none';
                }
            }

            // Handle Delete button click
            deleteButton.onclick = function () {
                if (selectedEventId && confirm('Are you sure you want to delete this event?')) {
                    fetch('delete_event.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ id: selectedEventId })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                var event = calendar.getEventById(selectedEventId);
                                if (event) {
                                    event.remove();
                                }
                                eventModal.style.display = 'none';
                                alert('Event deleted successfully');
                            } else {
                                alert('Failed to delete event');
                            }
                        });
                }
            };
        });


    </script>
</body>

</html>