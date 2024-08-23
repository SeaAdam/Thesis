<?php
// include 'login.php';
// $username = $_SESSION['username'];

include 'login.php';
// Get the username from the session
$username = $_SESSION['username'];

// Fetch the patient ID based on the username
$sql = "SELECT ID FROM registration_table WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $patientId = $row['ID'];

    // Fetch the full name based on the patient ID
    $sql = "SELECT CONCAT(FirstName, ' ', MI, ' ', LastName) AS fullName FROM registration_table WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $patientId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fullName = $row['fullName'];
    } else {
        $fullName = 'No patient found';
    }
} else {
    $fullName = 'No patient found';
}

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

    <title>User Dashboard</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">

    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.css' rel='stylesheet' />

    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.js'></script>

    <style>
        #calendar {
            width: 70%;
            float: left;
        }

        #events-calendar {
            width: 100%;
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

        .fc .fc-button:not(:disabled) {
            background-color: lemonchiffon;
            color: black;

        }

        .fc .fc-button-primary:disabled {
            background-color: lemonchiffon;
            color: black;
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

        .fc-h-event .fc-event-title {
            font-size: .8rem;
        }
    </style>


</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella
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
                            <h2><?php echo ($username); ?></h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>General</h3>
                            <ul class="nav side-menu">
                                <li><a href="userDashboard.php"><i class="fa fa-home"></i> Appointment </a>
                                </li>
                                <li><a href="userEvents.php"><i class="fa fa-edit"></i> Events </a>
                                </li>
                                <li><a href="userProfile.php"><i class="fa fa-desktop"></i> Profile </a>
                                </li>
                                <li><a href="userTransaction.php"><i class="fa fa-table"></i> Transaction </a>
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
                        <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
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
                if (isset($_SESSION['username'])) {
                    echo "
                        <div class='alert alert-success alert-dismissable' id='alert' style='background: green;border-radius: 5px;padding:10px;color: #fff;margin:50px 0px 10px 0px;'>
                            <h4><i class='fa fa-check-circle' aria-hidden='true'></i> Login Success!</h4>
                            <h6>Welcome to the User Dashboard!;</h6>
                        </div>
                    ";
                }
                ?>
                <div class="head-title">
                    <div>
                        <h1>Dashboard</h1>
                    </div>
                </div>

                <div class="container mt-2">
                    <div class="card">
                        <div class="card-header">
                            Booking Calendar
                        </div>
                        <div class="card-body">
                            <div id="calendar"></div>
                            <div id="legend">
                                <h3>Legend</h3>
                                <ul>
                                    <li><span style="background-color: green;"></span> Available</li>
                                    <li><span style="background-color: red;"></span> Fully Booked</li>
                                    <li><span style="background-color: gray;"></span> Holidays</li>
                                </ul>
                            </div>
                            <div id="holidays">
                                <h3>Holidays</h3>
                                <ul id="holidays-list">
                                    <?php
                                    include 'includes/dbconn.php';

                                    $sql = "SELECT holiday, dateHolidays FROM holidays";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<li>{$row['holiday']} - {$row['dateHolidays']}</li>";
                                        }
                                    } else {
                                        echo "No holidays found.";
                                    }
                                    ?>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTitle">Book for:</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p id="modalDate">Select a time slot:</p>
                                <div id="modalSlots"></div>


                                <button id="toggleSlotsButton" class="btn btn-secondary" style="margin-top: 15px;">Show
                                    Time Slots:</button>

                                <form id="bookingForm" method="POST" action="add_booking_user.php"
                                    style="display: none; margin-top: 15px;">
                                    <div class="mb-3">
                                        <label for="selectedTimeSlot" class="form-label">Selected Time Slot</label>
                                        <input type="text" class="form-control" id="selectedTimeSlot"
                                            name="selectedTimeSlot" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="patientName" class="form-label">Patient Name</label>
                                        <select class="form-control" id="patientName" name="patientName">
                                            <option value="<?php echo isset($patientId) ? $patientId : ''; ?>">
                                                <?php echo htmlspecialchars($fullName); ?>
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="serviceType" class="form-label">Service Type</label>
                                        <select class="form-control" id="serviceType" name="serviceType">
                                            <option>--SELECT--</option>
                                            <?php
                                            include 'includes/dbconn.php';
                                            $sql = "SELECT * FROM services_table";
                                            $query = $conn->query($sql);
                                            while ($row = $query->fetch_assoc()) {
                                                ?>
                                                <option value="<?php echo $row['ID']; ?>">
                                                    <?php echo $row['Services']; ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <input type="hidden" id="scheduleId" name="scheduleId">
                                    <input type="hidden" id="timeSlotId" name="timeSlotId">

                                    <button type="submit" class="btn btn-primary">Submit Booking</button>
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
            document.addEventListener('DOMContentLoaded', function () {
                var dashboardCalendarEl = document.getElementById('calendar');
                var eventModal = document.getElementById('eventModal');
                var toggleButton = document.getElementById('toggleSlotsButton');
                var modalSlots = document.getElementById('modalSlots');
                var bookingForm = document.getElementById('bookingForm');
                var modalTitle = document.getElementById('modalTitle');
                var modalDate = document.getElementById('modalDate');
                var selectedTimeSlot = document.getElementById('selectedTimeSlot');
                var scheduleIdField = document.getElementById('scheduleId');
                var timeSlotIdField = document.getElementById('timeSlotId');
                var serviceTypeSelect = document.getElementById('serviceType');

                // Initialize FullCalendar
                var dashboardCalendar = new FullCalendar.Calendar(dashboardCalendarEl, {
                    initialView: 'dayGridMonth',
                    selectable: true,
                    events: function (info, successCallback, failureCallback) {
                        var sources = ['schedule.php', 'fetch_events.php'];
                        var combinedEvents = [];

                        var fetchNext = function (index) {
                            if (index >= sources.length) {
                                successCallback(combinedEvents);
                                return;
                            }

                            fetch(sources[index])
                                .then(response => response.json())
                                .then(data => {
                                    // Add a source identifier to each event
                                    data.forEach(event => {
                                        event.source = sources[index]; // Assign the source filename
                                    });

                                    combinedEvents = combinedEvents.concat(data);
                                    fetchNext(index + 1);
                                })
                                .catch(error => {
                                    console.error('Error fetching events:', error);
                                    fetchNext(index + 1);
                                });
                        };

                        fetchNext(0);
                    },
                    eventDidMount: function (info) {
                        // Check if the event is from 'schedule.php'
                        if (info.event.extendedProps && info.event.extendedProps.source === 'schedule.php') {
                            let button = document.createElement('button');
                            button.textContent = info.event.extendedProps.buttonText || 'View Slots';
                            button.className = 'btn btn-primary';
                            button.onclick = function () {
                                modalTitle.textContent = `BOOK FOR: ${info.event.start.toLocaleDateString()}`;
                                modalDate.textContent = `SLOTS: ${info.event.title}`;

                                let scheduleId = info.event.extendedProps.schedule_id;
                                scheduleIdField.value = scheduleId; // Set the scheduleId field

                                fetch(`fetch_time_slots.php?schedule_id=${scheduleId}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        if (Array.isArray(data) && data.length > 0) {
                                            let slotsHtml = data.map(slot => {
                                                let buttonClass = slot.is_booked ? 'btn btn-outline-secondary disabled' : 'btn btn-outline-primary slot-button';
                                                let buttonText = slot.is_booked ? 'Unavailable' : `${slot.start_time} - ${slot.end_time}`;

                                                return `
                                        <li>
                                            <button class="${buttonClass}" 
                                                    data-id="${slot.id}" 
                                                    data-start="${slot.start_time}" 
                                                    data-end="${slot.end_time}"
                                                    data-slots="${slot.slots_remaining}">
                                                ${buttonText}
                                            </button>
                                        </li>`;
                                            }).join('');
                                            modalSlots.innerHTML = `Available Time Slots:<ul>${slotsHtml}</ul>`;

                                            document.querySelectorAll('.slot-button:not(.disabled)').forEach(button => {
                                                button.addEventListener('click', function () {
                                                    selectedTimeSlot.value = `${this.dataset.start} - ${this.dataset.end}`;
                                                    timeSlotIdField.value = this.dataset.id; // Set the timeSlotId field
                                                    bookingForm.style.display = 'block';
                                                    modalSlots.style.display = 'none';
                                                    toggleButton.style.display = 'inline-block';
                                                });
                                            });
                                        } else {
                                            modalSlots.innerHTML = 'No available time slots.';
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error fetching time slots:', error);
                                        modalSlots.textContent = 'Failed to load time slots.';
                                    });

                                // Show the modal
                                $(eventModal).modal('show');
                            };

                            info.el.appendChild(button);
                        }
                    }
                });

                dashboardCalendar.render();

                // Initially hide the toggle button and the booking form
                toggleButton.style.display = 'none';
                bookingForm.style.display = 'none';

                // Event listener for the toggle button
                toggleButton.addEventListener('click', function () {
                    if (modalSlots.style.display === 'none') {
                        // Show the time slots
                        modalSlots.style.display = 'block';
                        // Hide the booking form
                        bookingForm.style.display = 'none';
                        // Hide the toggle button again
                        toggleButton.style.display = 'none';
                    } else {
                        // Hide the time slots
                        modalSlots.style.display = 'none';
                        // Show the booking form
                        bookingForm.style.display = 'block';
                        // Show the toggle button
                        toggleButton.style.display = 'inline-block';
                    }
                });

                // Refresh page when the modal is closed
                $(eventModal).on('hidden.bs.modal', function () {
                    location.reload();
                });
            });

        </script>

</body>

</html>