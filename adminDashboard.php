<?php

include 'login.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['loginType'] !== 'admin') {
    header('Location: index.php'); // Redirect to login page if not logged in as admin
    exit();
}

// Retrieve the admin username from the session
$adminUsername = $_SESSION['username'];


include 'count_Dashboard.php';
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

    <title>Admin Dashboard</title>

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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        .chart-container {
            position: relative;
            width: 100%;
            /* Adjust width as needed */
            height: 200px;
            /* Adjust height as needed */
        }

        #statusDoughnutChart {
            width: 100% !important;
            height: 100% !important;
        }

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
                            <img src="images\admin-icon.jpg" alt="..." class="img-circle profile_img">
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
                <div class="row">

                    <?php include 'status.php'; ?>

                    <div class="col-sm-3 py-3">
                        <div class="card h-100 text-white bg-primary">
                            <div class="card-body">
                                <h3 class="card-title"><?php echo $countPatient; ?></h3>
                                <p class="card-text">Total Patients</p>
                                <h1><i class="fa fa-user-md" aria-hidden="true"></i></h1>
                            </div>
                            <div class="card-footer bg-transparent border-light"><a href="adminPatients.php"
                                    class="btn btn-outline-light" style="float: right;">More Info <span><i
                                            class="fa fa-arrow-circle-right" aria-hidden="true"></i></span></a></div>
                        </div>
                    </div>


                    <div class="col-sm-3 py-3">
                        <div class="card h-100 text-white bg-success">
                            <div class="card-body">
                                <h3 class="card-title"><?php echo $countServices; ?></h3>
                                <p class="card-text">Services</p>
                                <h1><i class="fa fa-line-chart" aria-hidden="true"></i></h1>
                            </div>
                            <div class="card-footer bg-transparent border-light"><a href="adminServices.php"
                                    class="btn btn-outline-light" style="float: right;">More Info <span><i
                                            class="fa fa-arrow-circle-right" aria-hidden="true"> </i></a></div>

                        </div>
                    </div>
                    <div class="col-sm-3 py-3">
                        <div class="card h-100 text-white bg-dark">
                            <div class="card-body">
                                <h3 class="card-title"><?php echo $countSchedules; ?></h3>
                                <p class="card-text">Schedules</p>
                                <h1><i class="fa fa-calendar" aria-hidden="true"></i></h1>
                            </div>
                            <div class="card-footer bg-transparent border-light"><a href="adminSchedule.php"
                                    class="btn btn-outline-light" style="float: right;">More Info <span><i
                                            class="fa fa-arrow-circle-right" aria-hidden="true"> </i></a></div>
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
                                    Time Slots</button>

                                <form id="bookingForm" method="POST" action="add_booking.php"
                                    style="display: none; margin-top: 15px;">
                                    <div class="mb-3">
                                        <label for="selectedTimeSlot" class="form-label">Selected Time Slot</label>
                                        <input type="text" class="form-control" id="selectedTimeSlot"
                                            name="selectedTimeSlot" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="patientName" class="form-label">Patient Name</label>
                                        <select class="form-control" id="patientName" name="patientName">
                                            <option>--SELECT--</option>
                                            <?php
                                            include 'includes/dbconn.php';
                                            $sql = "SELECT ID, CONCAT(FirstName, ' ', MI, ' ', LastName) AS fullName FROM registration_table";
                                            $query = $conn->query($sql);
                                            while ($row = $query->fetch_assoc()) {
                                                ?>
                                                <option value="<?php echo $row['ID']; ?>">
                                                    <?php echo $row['fullName']; ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
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
                            const slotsRemaining = parseInt(info.el.querySelector('.fc-event-title').textContent, 10);

                            // Apply background color based on slot availability
                            if (slotsRemaining === undefined) {
                                console.error('slots_remaining is undefined for event:', info.event);
                            } else if (slotsRemaining === 0) {
                                // Change background color of the event to red
                                info.el.style.backgroundColor = 'red';
                                info.el.classList.add('event-unavailable');
                            } else {
                                // Change background color of the event to green
                                info.el.style.backgroundColor = 'green';
                                info.el.classList.add('event-available');
                            }

                            // Add the button for slot viewing
                            let button = document.createElement('button');
                            button.textContent = info.event.extendedProps.buttonText || 'View Slots';
                            button.className = 'btn btn-warning btn-sm';
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
                        } else {
                            // Reset background color for events not from 'schedule.php' (e.g., holidays)
                            info.el.style.backgroundColor = 'gray'; // Reset to default background color
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

            // Intercept form submission
            document.getElementById('bookingForm').addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent the default form submission

                // Display the SweetAlert confirmation
                Swal.fire({
                    title: 'Appointment Booked!',
                    text: 'Your appointment has been successfully booked.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If the user clicks 'OK', submit the form
                        this.submit();
                    }
                });
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