<?php
include 'includes/dbconn.php';

include 'login.php';

if (!isset($_SESSION['username']) || $_SESSION['loginType'] !== 'client') {
    header('Location: index.php'); // Redirect to login page if not logged in as admin
    exit();
}

// Retrieve the admin username from the session
$clientUsername = $_SESSION['username'];

$sql = "SELECT client_id FROM clients_account WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $clientUsername);
$stmt->execute();
$result = $stmt->get_result();

// Check if a record was found
if ($result->num_rows > 0) {
    // Fetch the client_id from the database
    $row = $result->fetch_assoc();
    $id = $row['client_id'];
} else {
    // Handle the case where no user was found (optional)
    echo "No client found with this username.";
    exit();
}

// Query to select client information
$sql = "SELECT id, client_name, company_name, address, contact_number, email_address FROM clients_info WHERE id = '$id'";
$query = $conn->query($sql);

// Initialize variables for options
$clientNameOptions = '';
$companyNameOptions = '';
$addressOptions = '';
$contactOptions = '';
$emailAddress = '';

// Fetch the client information
while ($row = $query->fetch_assoc()) {
    $clientNameOptions .= '<option value="' . htmlspecialchars($row['id']) . '">'
        . htmlspecialchars($row['client_name']) . '</option>';
    $companyNameOptions .= '<option value="' . htmlspecialchars($row['company_name']) . '">'
        . htmlspecialchars($row['company_name']) . '</option>';
    $addressOptions .= '<option value="' . htmlspecialchars($row['address']) . '">'
        . htmlspecialchars($row['address']) . '</option>';
    $contactOptions .= '<option value="' . htmlspecialchars($row['contact_number']) . '">'
        . htmlspecialchars($row['contact_number']) . '</option>';
    $emailAddress .= '<option value="' . htmlspecialchars($row['email_address']) . '">'
        . htmlspecialchars($row['email_address']) . '</option>';
}

// Fallback if no client found
if (empty($clientNameOptions)) {
    $clientNameOptions = '<option value="">No client found</option>';
}
if (empty($companyNameOptions)) {
    $companyNameOptions = '<option value="">No company name found</option>';
}
if (empty($addressOptions)) {
    $addressOptions = '<option value="">No address found</option>';
}
if (empty($contactOptions)) {
    $contactOptions = '<option value="">No contact number found</option>';
}

// Close the statement and the database connection
$stmt->close();
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
    </style>


</head>

<body class="nav-md">
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
                            <h2><?php echo htmlspecialchars($clientUsername); ?></h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>General</h3>
                            <ul class="nav side-menu">
                                <li><a href="clientDashboard.php"><i class="fa fa-home"></i> Appointment </a>
                                </li>
                                <li><a href="clientEvents.php"><i class="fa fa-edit"></i> Events </a>
                                </li>
                                <li><a href="clientProfile.php"><i class="fa fa-desktop"></i> Profile </a>
                                </li>
                                <li><a href="clientTransaction.php"><i class="fa fa-table"></i> Transaction </a>

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
                                </a>
                                <div class="dropdown-menu dropdown-usermenu pull-right"
                                    aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="index.php"><i class="fa fa-sign-out pull-right"></i>
                                        Log Out</a>
                                </div>
                            </li>

                            <li role="presentation" class="nav-item dropdown open">
                                <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1"
                                    data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-envelope-o"></i>

                                </a>
                                <ul class="dropdown-menu list-unstyled msg_list" role="menu"
                                    aria-labelledby="navbarDropdown1">

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
                                <form id="bookingForm" method="POST" action="add_booking_as_client.php">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="clientName" class="form-label">Client Name</label>
                                            <select class="form-control" id="clientName" name="clientName">
                                                <?php echo $clientNameOptions; ?>
                                            </select>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label for="companyName" class="form-label">Company Name</label>
                                            <select class="form-control" id="companyName" name="companyName">
                                                <?php echo $companyNameOptions; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4">
                                            <label for="address" class="form-label">Address</label>
                                            <select class="form-control" id="address" name="address">
                                                <?php echo $addressOptions; ?>
                                            </select>
                                        </div>

                                        <div class="col-4 mb-3">
                                            <label for="contact" class="form-label">Contact Number</label>
                                            <select class="form-control" id="contact" name="contact">
                                                <?php echo $contactOptions; ?>
                                            </select>
                                        </div>

                                        <div class="col-4 mb-3">
                                            <label for="email" class="form-label">Email Address</label>
                                            <select class="form-control" id="email" name="email">
                                                <?php echo $emailAddress; ?>
                                            </select>
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
                var calendarEl = document.getElementById('calendar');
                var modal = new bootstrap.Modal(document.getElementById('eventModal'));
                var modalTitle = document.getElementById('modalTitle');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    selectable: true,
                    events: function (info, successCallback, failureCallback) {
                        var sources = ['fetch_events.php', 'fetch_client_schedule.php'];
                        var combinedEvents = [];

                        var fetchNext = function (index) {
                            if (index >= sources.length) {
                                successCallback(combinedEvents);
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

                            // Create the "Book Appointment" button
                            var bookButton = document.createElement('button');
                            bookButton.innerText = 'Book Appointment';
                            bookButton.classList.add('book-appointment-btn');


                            bookButton.addEventListener('click', function () {
                                var dateStr = info.event.startStr;
                                modalTitle.innerText = 'Book for: ' + dateStr;

                                // Update the hidden field with the selected date
                                document.getElementById('selectedDate').value = dateStr;

                                // Show the modal
                                modal.show();
                            });


                            // Append the button to the event's container
                            info.el.querySelector('.fc-event-main').appendChild(bookButton);
                        }
                    }
                });

                calendar.render();
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
        </script>


</body>

</html>