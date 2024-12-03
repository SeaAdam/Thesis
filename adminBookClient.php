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

    <title>Admin Book a Patient Client Appointment</title>

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

        .fc-daygrid-event {
            position: relative;
            background-color: transparent;
            /* Make sure background is transparent */
            border: none;
            /* Remove border if present */
        }

        .fc-event-main {
            padding: 0;
            /* Remove padding if present */
            margin: 0;
            /* Remove margin if present */
        }

        .book-appointment-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            margin-top: 5px;
            font-size: 12px;
            display: block;
            /* Ensure button is displayed as block element */
        }

        .book-appointment-btn:hover {
            background-color: #0056b3;
        }

        /* Style for btn-danger */
        .book-appointment-btn.btn-danger {
            background-color: #dc3545;
            /* Bootstrap danger color */
            color: white;
        }

        /* Style for btn-success */
        .book-appointment-btn.btn-success {
            background-color: #28a745;
            /* Bootstrap success color */
            color: white;
        }

        /* Style for btn-primary */
        .book-appointment-btn.btn-primary {
            background-color: #007bff;
            /* Bootstrap primary color */
            color: white;
        }

        .dropdown-item.unread {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .dropdown-item.read {
            background-color: #ffffff;
            font-weight: normal;
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

            <?php include 'top_nav_admin.php'; ?>


            <div class="right_col" role="main">
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
                                    <li><span style="background-color: #007bff;"></span> Available</li>
                                    <li><span style="background-color: red;"></span>Already Booked</li>
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
                                <form id="bookingForm" method="POST" action="process_booking_as_admin.php">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="clientName" class="form-label">Client Name</label>
                                            <select class="form-control" id="clientName" name="clientName">
                                                <option>--SELECT--</option>
                                                <?php
                                                include 'includes/dbconn.php';
                                                $sql = "SELECT id, client_name FROM clients_info";
                                                $query = $conn->query($sql);
                                                while ($row = $query->fetch_assoc()) {
                                                    ?>
                                                    <option value="<?php echo $row['id']; ?>">
                                                        <?php echo $row['client_name']; ?>
                                                    </option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label for="companyName" class="form-label">Company Name</label>
                                            <input type="text" class="form-control" id="companyName" name="companyName"
                                                readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4">
                                            <label for="address" class="form-label">Address</label>
                                            <input type="text" class="form-control" id="address" name="address"
                                                readonly>
                                        </div>

                                        <div class="col-4 mb-3">
                                            <label for="contact" class="form-label">Contact Number</label>
                                            <input type="text" class="form-control" id="contact" name="contact"
                                                readonly>
                                        </div>

                                        <div class="col-4 mb-3">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="text" class="form-control" id="email" name="email" readonly>
                                        </div>
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

                                    <button type="submit" class="btn btn-primary">Submit Booking</button>

                                    <input type="hidden" id="selectedDate" name="selectedDate">
                                </form>
                            </div>
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


    <?php include "includes/booking_modal.php"; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var modal = new bootstrap.Modal(document.getElementById('eventModal'));
            var modalTitle = document.getElementById('modalTitle');

            function isPastDate(dateStr) {
                const today = new Date();
                today.setHours(0, 0, 0, 0); // Set the time part to 00:00:00 for accurate comparison
                const eventDate = new Date(dateStr);
                return eventDate < today;
            }

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,

                events: function (info, successCallback, failureCallback) {
                    var sources = ['fetch_events.php', 'fetch_client_schedule.php'];
                    var combinedEvents = [];

                    var fetchNext = function (index) {
                        if (index >= sources.length) {
                            console.log('Combined Events:', combinedEvents); // Log all events
                            successCallback(combinedEvents);
                            calendar.render(); // Force re-render
                            return;
                        }

                        fetch(sources[index])
                            .then(response => response.json())
                            .then(data => {
                                data.forEach(event => {
                                    event.source = sources[index];
                                });
                                combinedEvents = combinedEvents.concat(data);
                                fetchNext(index + 1);
                            })
                            .catch(error => {
                                console.error('Error fetching events from source:', sources[index], error);
                                fetchNext(index + 1);
                            });
                    };

                    fetchNext(0);
                },
                eventDidMount: function (info) {
                    console.log('Event mounted:', info.event);

                    // Remove all child elements except the button
                    var mainFrame = info.el.querySelector('.fc-event-main-frame');
                    if (mainFrame) {
                        // Remove all children from .fc-event-main-frame
                        while (mainFrame.firstChild) {
                            mainFrame.removeChild(mainFrame.firstChild);
                        }
                    }

                    if (info.event.extendedProps.source === 'fetch_client_schedule.php') {
                        console.log('Adding button to event:', info.event);

                        // Check if the date is already booked
                        var isBooked = info.event.extendedProps.isBooked; // Check the 'isBooked' property
                        var isPast = isPastDate(info.event.startStr); // Check if the date is in the past

                        // Create the "Book Appointment" button
                        var bookButton = document.createElement('button');
                        bookButton.classList.add('btn', 'book-appointment-btn');

                        // Set button text and state based on booking status and date
                        if (info.event.extendedProps.status === 'Completed') {
                            bookButton.innerText = 'Appointment Completed';
                            bookButton.classList.add('btn-success'); // Use Bootstrap's success button style for completed
                            bookButton.disabled = true; // Disable the button for completed appointments
                        } else if (info.event.extendedProps.status === 'Pending' || info.event.extendedProps.status === 'Approved') {
                            // If status is Pending or Approved, show "Already Booked"
                            bookButton.innerText = 'Already Booked';
                            bookButton.classList.add('btn-danger'); // Use Bootstrap's danger button style for booked
                            bookButton.disabled = false; // Allow interaction for already booked
                        } else {
                            // For Rejected, Canceled, and any other scenario, show "Book Appointment" again
                            bookButton.innerText = 'Book Appointment';
                            bookButton.classList.add('btn-primary'); // Use Bootstrap's primary button style
                            bookButton.disabled = isPast; // Disable the button if the date is past
                        }

                        // Append the button to a parent element (for example, the event's container)
                        info.el.appendChild(bookButton);

                        bookButton.addEventListener('click', function () {
                            if (!isBooked && !isPast) {
                                var dateStr = info.event.startStr;
                                modalTitle.innerText = 'Book for: ' + dateStr;

                                // Update the hidden field with the selected date
                                document.getElementById('selectedDate').value = dateStr;

                                // Show the modal
                                modal.show();
                            }
                        });

                        // Append the button to the event's container
                        info.el.querySelector('.fc-event-main').appendChild(bookButton);
                    }
                }
            });

            calendar.render();

            // Optional: Refresh the calendar periodically or on specific actions
            function refreshCalendar() {
                calendar.refetchEvents();
            }
        });

        // Bind the form submit event
        $('#bookingForm').on('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission

            // Show confirmation SweetAlert
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to confirm the booking?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Confirm',
                cancelButtonText: 'No, Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, submit the form using AJAX
                    $.ajax({
                        url: 'process_booking_as_admin.php',  // Your server-side processing file
                        type: 'POST',
                        data: $('#bookingForm').serialize(),  // Serialize the form data
                        success: function (response) {
                            // Show a success alert
                            Swal.fire({
                                title: 'Success!',
                                text: response,
                                icon: 'success'
                            }).then(() => {
                                // Reload the page after the success alert
                                location.reload();
                            });
                        },
                        error: function (xhr, status, error) {
                            // Show an error alert
                            Swal.fire('Error!', 'There was an issue with the booking.', 'error');
                        }
                    });
                }
            });
        });

        $(document).ready(function () {
            // When the client name is selected
            $('#clientName').change(function () {
                var clientId = $(this).val();

                // Check if client is selected
                if (clientId) {
                    $.ajax({
                        url: 'fetch_client_details.php', // PHP script to fetch client details
                        type: 'GET',
                        data: { clientId: clientId },
                        dataType: 'json',
                        success: function (response) {
                            if (response) {
                                // Fill in the other fields with the fetched data
                                $('#companyName').val(response.company_name);
                                $('#address').val(response.address);
                                $('#contact').val(response.contact_number);
                                $('#email').val(response.email_address);
                            }
                        }
                    });
                } else {
                    // Reset all fields if no client is selected
                    $('#companyName, #address, #contact, #email').val('');
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