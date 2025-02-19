<?php
include 'includes/dbconn.php';

include 'login.php';


// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['loginType'] !== 'user') {
    header('Location: index.php'); // Redirect to login page if not logged in as admin
    exit();
}

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

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

include 'notification_functions.php'; // Create this file for the functions

$notifications = fetchNotifications($user_id);
$unread_count = countUnreadNotifications($user_id);
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

        .event-available .fc-event-title {
            background-color: green !important;
            /* Ensure green background for available slots */
        }

        .event-unavailable .fc-event-title {
            background-color: red !important;
            /* Ensure red background for unavailable slots */
        }

        .dropdown-item.unread {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .dropdown-item.read {
            background-color: #ffffff;
            font-weight: normal;
        }

        .alert {
            padding: 15px;
            margin: 10px 0;
            border: 1px solid transparent;
            border-radius: 5px;
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            display: none;
            /* Initially hidden */
        }
    </style>


</head>

<body class="nav-md">
    <?php
    if (isset($_SESSION['errorMessage'])) {
        $errorMessage = $_SESSION['errorMessage'];
        unset($_SESSION['errorMessage']); // Remove it immediately after setting
        echo "<div class='alert' id='error-alert'>$errorMessage</div>";
    }
    ?>
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="userDashboard.php" class="site_title"><i class="fa fa-plus-square"></i> <span>Brain
                                Master DC</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="images\icon-profile-user.png" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2><?php echo htmlspecialchars($username); ?></h2>
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

                                <li><a href="userMultipleTransaction.php"><i class="fa fa-table"></i> Multiple
                                        Transaction</a>

                                <li><a href="#"><i></i> HELP DESK </a>
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
                                    <span class="badge bg-green"><?php echo count($notifications); ?></span>
                                    <span class="badge bg-green"><?php echo $unread_count; ?></span>
                                </a>
                                <ul class="dropdown-menu list-unstyled msg_list" role="menu"
                                    aria-labelledby="navbarDropdown1">
                                    <?php foreach ($notifications as $notification): ?>
                                        <li class="nav-item">
                                            <a class="dropdown-item <?php echo $notification['read_status'] == 0 ? 'unread' : 'read'; ?>"
                                                href="#"
                                                onclick="markAsRead(<?php echo $notification['transaction_id']; ?>)">
                                                <i class="fa fa-info-circle"></i>
                                                Booking ID: <?php echo $notification['transaction_id']; ?> - Status:
                                                <?php echo $notification['status']; ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
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
                                    <li><span style="background-color: #ffc107;"></span> Available</li>
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
                                <form id="bookingForm" method="POST" action="add_booking_user.php"
                                    style="margin-top: 15px;">
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
                                        <select class="form-control" id="serviceType" name="serviceType"
                                            onchange="loadTimeSlots()">
                                            <option value="">--SELECT--</option>
                                            <?php
                                            include 'includes/dbconn.php';
                                            $sql = "SELECT * FROM services_table";
                                            $query = $conn->query($sql);
                                            while ($row = $query->fetch_assoc()) {
                                                ?>
                                                <option value="<?php echo $row['ID']; ?>"><?php echo $row['Services']; ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div id="modalSlots" class="mb-3">
                                        <p>Select a service to see available time slots.</p>
                                    </div>

                                    <input type="hidden" id="selectedTimeSlot" name="selectedTimeSlot">
                                    <input type="hidden" id="scheduleId" name="scheduleId">
                                    <input type="hidden" id="timeSlotId" name="timeSlotId">
                                    <input type="hidden" id="selectedDate" name="selectedDate">

                                    <button type="submit" class="btn btn-primary">Submit Booking</button>
                                </form>

                                <button type="button" class="btn btn-secondary" id="addMultipleBookingsBtn">Add
                                    Multiple Bookings</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- New Modal for Multiple Bookings -->
                <div class="modal fade" id="newEventModal" tabindex="-1" aria-labelledby="newEventModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="newEventModalLabel">Select Services for Multiple Bookings
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="multipleBookingForm">
                                    <div class="mb-3">
                                        <label for="multipleServiceTypeSelect" class="form-label">Select
                                            Services</label>
                                        <select class="form-control" id="multipleServiceTypeSelect"
                                            name="multipleServiceTypeSelect" multiple size="5">
                                            <!-- Options will be populated dynamically -->
                                        </select>
                                    </div>

                                    <div id="multipleModalSlots" class="mb-3"></div>
                                    <!-- New Schedule Selection -->
                                    <div class="mb-3" id="scheduleSelectDiv" style="display: none;">
                                        <label for="scheduleSelect" class="form-label">Select Schedule</label>
                                        <select class="form-control" id="scheduleSelect" name="scheduleSelect">
                                            <option value="AM">AM</option>
                                            <option value="PM">PM</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Confirm Multiple Bookings</button>
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
            $(document).ready(function () {
                window.setTimeout(function () {
                    $("#alert").fadeTo(1000, 0).slideUp(1000, function () {
                        $(this).remove();
                    });
                }, 5000);
            });

            document.addEventListener('DOMContentLoaded', function () {
                const dashboardCalendarEl = document.getElementById('calendar');
                const eventModal = document.getElementById('eventModal');
                const modalTitle = document.getElementById('modalTitle');
                const modalSlots = document.getElementById('modalSlots');
                const bookingForm = document.getElementById('bookingForm');
                const serviceTypeSelect = document.getElementById('serviceType');
                const selectedTimeSlotInput = document.getElementById('selectedTimeSlot');
                const addMultipleBookingsBtn = document.getElementById('addMultipleBookingsBtn');
                // Assuming you already have the necessary elements and variables initialized:
                const multipleServiceTypeSelect = document.getElementById('multipleServiceTypeSelect');
                const scheduleSelectDiv = document.getElementById('scheduleSelectDiv');
                const multipleModalSlots = document.getElementById('multipleModalSlots');  // For displaying the message
                const multipleBookingForm = document.getElementById('multipleBookingForm');

                let selectedScheduleId = null;
                let selectedTimeSlotId = null;
                let selectedServiceId = null;
                let selectedServiceIds = [];

                // Initialize FullCalendar
                const dashboardCalendar = new FullCalendar.Calendar(dashboardCalendarEl, {
                    initialView: 'dayGridMonth',
                    selectable: true,
                    events: function (info, successCallback, failureCallback) {
                        const sources = ['schedule.php', 'fetch_events.php'];
                        let combinedEvents = [];

                        const fetchEventsFromSources = async () => {
                            for (const source of sources) {
                                try {
                                    const response = await fetch(source);
                                    const data = await response.json();

                                    data.forEach(event => {
                                        event.source = source;
                                    });

                                    combinedEvents = combinedEvents.concat(data);
                                } catch (error) {
                                    console.error(`Error fetching events from ${source}:`, error);
                                }
                            }
                            successCallback(combinedEvents);
                        };

                        fetchEventsFromSources();
                    },
                    eventDidMount: function (info) {
                        const eventDate = new Date(info.event.start);
                        const currentDate = new Date();
                        currentDate.setHours(0, 0, 0, 0);

                        if (info.event.extendedProps?.source === 'schedule.php') {
                            const button = document.createElement('button');

                            if (eventDate < currentDate) {
                                button.textContent = 'Unavailable';
                                button.className = 'btn btn-secondary btn-sm disabled';
                                button.disabled = true;
                            } else {
                                button.textContent = 'Book Now';
                                button.className = 'btn btn-warning btn-sm';
                                button.onclick = () => openBookingModal(info.event);
                            }

                            info.el.appendChild(button);
                        } else {
                            info.el.style.backgroundColor = 'gray';
                        }
                    },
                });

                dashboardCalendar.render();

                function openBookingModal(event) {
                    selectedScheduleId = event.id;
                    document.getElementById('scheduleId').value = selectedScheduleId;

                    if (modalTitle) {
                        modalTitle.textContent = `BOOK FOR: ${event.start.toLocaleDateString()}`;
                    }

                    if (bookingForm) {
                        bookingForm.style.display = 'block';
                    }

                    // Now load services based on the selected schedule ID
                    loadServicesBasedOnSchedule(selectedScheduleId);
                    $(eventModal).modal('show');
                }

                function loadServicesBasedOnSchedule(scheduleId) {
                    // Clear previous services
                    serviceTypeSelect.innerHTML = '<option value="">--SELECT--</option>';

                    // Fetch services based on selected schedule ID
                    fetch(`fetch_services_by_schedule.php?schedule_id=${scheduleId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.services && data.services.length) {
                                data.services.forEach(service => {
                                    const option = document.createElement('option');
                                    option.value = service.ID;
                                    option.textContent = service.Services;
                                    serviceTypeSelect.appendChild(option);
                                });
                            } else {
                                const option = document.createElement('option');
                                option.textContent = 'No services available for this schedule.';
                                serviceTypeSelect.appendChild(option);
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching services:', error);
                            const option = document.createElement('option');
                            option.textContent = 'Error loading services.';
                            serviceTypeSelect.appendChild(option);
                        });
                }



                function loadTimeSlots(serviceId) {
                    if (serviceId && selectedServiceIds.length <= 4) {
                        modalSlots.innerHTML = 'Loading time slots...';

                        // Fetch time slots and slots_count for the selected service
                        fetch(`fetch_service_details.php?service_id=${serviceId}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.timeSlots?.length) {
                                    modalSlots.innerHTML = '';

                                    // Display slots_count
                                    const slotsCount = data.slotsCount; // Assuming you have slotsCount in the response
                                    modalSlots.innerHTML += `<p><strong>Total Slots:</strong> ${slotsCount}</p>`;

                                    // Check slots count to change the button text
                                    if (slotsCount === 0) {
                                        // Change button state if no slots are available
                                        const noSlotsButton = document.createElement('button');
                                        noSlotsButton.textContent = 'No Slots Available';
                                        noSlotsButton.className = 'btn btn-danger btn-sm disabled'; // Disabled and red button
                                        modalSlots.appendChild(noSlotsButton);
                                    } else {
                                        // Display the time slots if available
                                        data.timeSlots.forEach(slot => {
                                            const isBooked = slot.isBooked;
                                            createSlotButton(slot, isBooked);
                                        });
                                    }
                                } else {
                                    modalSlots.innerHTML = 'No available time slots for the selected service.';
                                }
                            })
                            .catch(error => {
                                console.error('Error fetching time slots:', error);
                                modalSlots.innerHTML = 'Failed to load time slots.';
                            });
                    } else if (selectedServiceIds.length > 4) {
                        modalSlots.innerHTML = 'Please select between 2 to 4 services.';
                        modalSlots.style.display = 'none';
                    } else {
                        modalSlots.style.display = 'block';
                    }
                }

                function createSlotButton(slot, isBooked) {
                    const slotButton = document.createElement('button');
                    slotButton.textContent = slot.time_slot;
                    slotButton.className = 'btn btn-outline-primary btn-sm m-1';
                    slotButton.type = 'button';
                    slotButton.dataset.id = slot.id; // Set the data-id attribute

                    if (isBooked) {
                        // If the slot is booked, disable the button and add the 'disabled' class
                        slotButton.classList.add('btn-secondary', 'disabled');
                        slotButton.disabled = true;
                    } else {
                        // If the slot is available, add a click handler
                        slotButton.onclick = () => {
                            selectedTimeSlotId = slot.id;
                            selectedTimeSlotInput.value = selectedTimeSlotId;
                        };
                    }

                    modalSlots.appendChild(slotButton);
                }

                // $(eventModal).on('hidden.bs.modal', () => location.reload());

                $('#eventModal').on('hidden.bs.modal', function () {
                    location.reload(); // This will reload the page
                });

                serviceTypeSelect.addEventListener('change', () => {
                    const serviceId = serviceTypeSelect.value;

                    if (serviceId) {
                        loadTimeSlots(serviceId);
                    }
                });

                // Show Confirmation Modal before form submission
                function showConfirmationModal(event) {
                    // Get selected service and time slot
                    const selectedService = document.getElementById('serviceType').value;
                    const selectedTimeSlot = document.getElementById('selectedTimeSlot').value;

                    if (selectedService && selectedTimeSlot) {
                        // Create booking summary
                        const serviceName = document.querySelector(`#serviceType option[value="${selectedService}"]`).text;
                        const timeSlotButton = document.querySelector(`button[data-id="${selectedTimeSlot}"]`);
                        const timeSlotText = timeSlotButton ? timeSlotButton.textContent : 'No time slot selected';

                        const bookingSummary = `
            <p><strong>Service:</strong> ${serviceName}</p>
            <p><strong>Time Slot:</strong> ${timeSlotText}</p>
        `;

                        // Display summary in a confirmation modal
                        Swal.fire({
                            title: 'Confirm Your Booking',
                            html: bookingSummary,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Confirm Booking',
                            cancelButtonText: 'Cancel',
                        }).then(result => {
                            if (result.isConfirmed) {
                                // Submit the form if confirmed
                                event.target.submit();

                                // Call the success alert after the form is submitted
                                showSuccessAlert();
                            } else {
                                // If cancelled, show cancellation message
                                Swal.fire('Cancelled', 'Your booking has been cancelled.', 'info');
                            }
                        });
                    } else {
                        // If no service or time slot is selected, show an error alert
                        Swal.fire({
                            title: 'Error!',
                            text: 'Please select both a service and a time slot before submitting.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                        });
                    }
                }

                // Success Confirmation Alert
                function showSuccessAlert() {
                    Swal.fire({
                        title: 'Booking Confirmed!',
                        text: 'Your booking has been successfully confirmed.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                    }).then(result => {
                        if (result.isConfirmed) {
                            // Redirect to another page (optional)
                            window.location.href = 'userDashboard.php'; // Change this URL to wherever you'd like to go
                        }
                    });
                }

                // Bind the form submission event to show the confirmation modal
                document.getElementById('bookingForm').addEventListener('submit', function (e) {
                    e.preventDefault();
                    showConfirmationModal(e); // Call the confirmation modal function
                });


            });

            // Open New Modal for Multiple Bookings
            addMultipleBookingsBtn.addEventListener('click', () => {
                // Disable page reload on modal close temporarily
                $('#eventModal').off('hidden.bs.modal'); // Remove event listener for reloading the page

                // Load services for multiple bookings
                fetchServicesForMultipleBookings();

                // Close the previous modal if it is open
                $('#eventModal').modal('hide');

                // Show the new modal
                $(newEventModal).modal('show');
            });

            // Optionally, restore the reload behavior for #eventModal after new modal is closed
            $('#newEventModal').on('hidden.bs.modal', function () {
                // Reload the page when #newEventModal is closed
                location.reload();

                // Restore the reload trigger for #eventModal
                $('#eventModal').on('hidden.bs.modal', function () {
                    location.reload(); // Reload the page when #eventModal is closed
                });
            });



            function fetchServicesForMultipleBookings() {
                fetch('fetch_service.php')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();  // Parse the response as JSON
                    })
                    .then(data => {
                        console.log('Services fetched:', data);
                        // Call the function to populate the select element with fetched services
                        populateServicesSelect(data);
                    })
                    .catch(error => {
                        console.error('Error fetching services:', error);
                    });
            }

            function populateServicesSelect(services) {
                // Get the select element by its ID
                const selectElement = document.getElementById('multipleServiceTypeSelect');

                // Clear any existing options
                selectElement.innerHTML = '';

                // Loop through the services and create an option for each
                services.forEach(service => {
                    const option = document.createElement('option');
                    option.value = service.ID;  // Service ID as value
                    option.textContent = service.Services;  // Service name as text
                    selectElement.appendChild(option);
                });

                // Optionally, you can trigger the modal here if it's not already triggered
                $('#newEventModal').modal('show');
            }


            // Handle Service Selection Change
            multipleServiceTypeSelect.addEventListener('change', () => {
                const selectedOptions = Array.from(multipleServiceTypeSelect.selectedOptions);
                selectedServiceIds = selectedOptions.map(option => option.value);  // Get selected service IDs

                if (selectedServiceIds.length >= 2 && selectedServiceIds.length <= 4) {
                    // Show the AM/PM schedule selection dropdown
                    scheduleSelectDiv.style.display = 'block';
                    multipleModalSlots.innerHTML = '';  // Clear any previous messages
                } else {
                    // Hide the AM/PM schedule selection if not between 2 and 4 services
                    scheduleSelectDiv.style.display = 'none';
                    multipleModalSlots.innerHTML = 'Please select between 2 and 4 services.';
                }


            });

            document.getElementById('multipleBookingForm').addEventListener('submit', function (e) {
                e.preventDefault();  // Prevent the form from submitting normally

                // Get the selected AM/PM schedule
                const selectedSchedule = document.getElementById('scheduleSelect').value;

                // Get selected service IDs
                const selectedServiceIds = Array.from(multipleServiceTypeSelect.selectedOptions).map(option => option.value);

                // Validate the selected services
                if (selectedServiceIds.length < 2 || selectedServiceIds.length > 4) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please select between 2 and 4 services before confirming.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                    }).then(() => {
                        location.reload();  // Reload the page after clicking OK
                    });
                    return;
                }

                // Debugging inputs
                console.log('Selected Service IDs:', selectedServiceIds);
                console.log('Selected Schedule:', selectedSchedule);

                // Prepare FormData
                const formData = new FormData();
                formData.append('serviceIds', JSON.stringify(selectedServiceIds));
                formData.append('schedule', selectedSchedule);

                fetch('save_multiple_bookings_user.php', {
                    method: 'POST',
                    body: formData,
                })
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.text();
                    })
                    .then(responseText => {
                        console.log('Raw response:', responseText);
                        const data = JSON.parse(responseText);
                        if (data.success) {
                            Swal.fire({
                                title: 'Multiple Bookings Confirmed!',
                                text: `You have selected ${selectedServiceIds.length} services for booking.`,
                                icon: 'success',
                                confirmButtonText: 'OK',
                            }).then(() => {
                                window.location.href = 'userDashboard.php';
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.error || 'Unknown error occurred.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'An unexpected error occurred. Please try again later.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                        });
                    });
            });

















            function markAsRead(transaction_id) {
                fetch(`mark_notification_read.php?transaction_id=${transaction_id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update the notification's class to 'read'
                            document.querySelector(`a[onclick='markAsRead(${transaction_id})']`).classList.remove('unread');
                            document.querySelector(`a[onclick='markAsRead(${transaction_id})']`).classList.add('read');

                            // Update the count (reload can be omitted if updating count manually)
                            location.reload();
                        }
                    });
            }

            function markAllAsRead() {
                fetch('mark_all_notifications_read.php')
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
                const errorAlert = document.getElementById('error-alert');
                if (errorAlert) {
                    errorAlert.style.display = 'block'; // Show the alert
                    setTimeout(() => {
                        errorAlert.style.display = 'none'; // Hide it after 5 seconds
                    }, 5000);
                }
            });

        </script>


</body>

</html>