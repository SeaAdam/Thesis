<?php
session_start();
// Include the database connection
include 'includes/dbconn.php';

// Fetch reviews from the database
$sql = "SELECT * FROM reviews ORDER BY created_at DESC";
$result = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brain Master DC</title>

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Red+Rose:wght@600;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">

    <!-- Libraries Stylesheet -->
    <link href="./ui/animate.min.css" rel="stylesheet">
    <link href="./ui/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="./ui/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="./ui/style.css" rel="stylesheet">


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        input {
            text-transform: none;
        }

        #reviewForm {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .star {
            font-size: 1.5em;
            cursor: pointer;
            color: gray;
        }

        .star.selected {
            color: gold;
        }

        .stars {
            display: inline-block;
        }

        .review-item {
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        .review-item h5 {
            font-size: 1.2em;
        }
    </style>



</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>
    <!-- Spinner End -->


    <!-- Topbar Start -->
    <div class="container-fluid py-2 d-none d-lg-flex" id="top">
        <div class="container">
            <div class="d-flex justify-content-between">
                <div>
                    <small class="me-3"><i class="fa fa-map-marker-alt me-2"></i>303, Sujeco Building, 1754 E
                        Rodriguez
                        Sr. Ave, Immaculate Conception, Quezon City, 1111 Metro Manila</small>
                </div>
                <nav class="breadcrumb mb-0">
                    <small class="me-3"><i class="fa fa-clock me-2"></i>Mon-Fri 8am-5pm, Sun Closed</small>
                </nav>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Brand Start -->
    <div class="container-fluid bg-primary text-white pt-4 pb-5 d-none d-lg-flex">
        <div class="container pb-2">
            <div class="d-flex justify-content-center">
                <a href="index.php" class="h1 text-white mb-0">Brain Master <span class="text-dark">Diagnostic
                        Center (BMDC)</span> Appointment</a>
            </div>
        </div>
    </div>

    <!-- Brand End -->


    <!-- Navbar Start -->
    <div class="container-fluid sticky-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-white py-lg-0 px-lg-3">
                <a href="index.php" class="navbar-brand d-lg-none">
                    <h1 class="text-primary m-0">Brain Master<span class="text-dark">Diagnostic
                            Center (BMDC)</span></h1>
                </a>
                <button type="button" class="navbar-toggler me-0" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav">
                        <a href="index.php" class="nav-item nav-link">Home</a>
                        <a href="services.php" class="nav-item nav-link">Services and Requirements</a>
                        <a href="reviews.php" class="nav-item nav-link active">Reviews</a>
                        <a href="#footer" class="nav-item nav-link">Contacts</a>
                    </div>
                    <div class="ms-auto d-none d-lg-flex">
                        <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal"
                            data-bs-target="#myModal">
                            Login
                        </button>
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#termsModal">
                            Register for Appointment
                        </button>

                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->

    <!-- Modals -->

    <!-- modal login -->
    <div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Login Page</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="assets/brainn.png" alt="Logo" class="login-logo mb-3" style="width: 150px; height: auto;">
                    <form id="loginForm" action="login.php" method="POST">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="usernameLogin" name="usernameLogin"
                                placeholder="Enter your username" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <input type="password" class="form-control" id="loginPassword" name="loginPassword"
                                    placeholder="Enter your password" required>
                                <button class="btn btn-outline-secondary" type="button" id="toggleLoginPassword">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="loginType">Login as:</label>
                            <select name="loginType" class="form-control" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                                <option value="clients">Client</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <a href="#">Forgot Password?</a>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Login</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- modal login -->

    <!-- modal register -->
    <div class="modal fade" id="myModalReg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Registration</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="assets/download1.jpg" alt="Logo" class="login-logo mb-3">
                    <div class="d-grid gap-2">
                        <button type="button" id="patientButton" class="btn btn-danger">REGISTER AS A
                            PATIENT</button>
                        <button type="button" id="clientButton" class="btn btn-warning">REGISTER AS A
                            CLIENT</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal register -->

    <!-- modalregPatient -->
    <div class="modal fade" id="myModalRegPatient" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Register As Patient</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="formPatient" id="registrationForm" action="registration.php" method="POST"
                        onsubmit="return showSuccessAlert('Patient Registration');">
                        <!-- First Row: First Name, Middle Initial, Last Name -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="FirstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="FirstName" name="FirstName"
                                        placeholder="First Name" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="MI" class="form-label">M.I.</label>
                                    <input type="text" class="form-control" id="MI" name="MI" placeholder="M.I."
                                        maxlength="1">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="LastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="LastName" name="LastName"
                                        placeholder="Last Name" required>
                                </div>
                            </div>
                        </div>

                        <!-- Second Row: Gender, Date of Birth, Age -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="Gender" class="form-label">Gender</label>
                                    <select id="Gender" class="form-select" name="Gender" required>
                                        <option value="" disabled selected>Choose...</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="DOB" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="DOB" name="DOB" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="Age" class="form-label">Age</label>
                                    <input type="number" class="form-control" id="Age" placeholder="Age" name="Age"
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- Third Row: Contact, Address -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="Contact" class="form-label">Contact</label>
                                    <input type="text" class="form-control" id="Contact" placeholder="Contact"
                                        name="Contact" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="PresentAddress" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="PresentAddress"
                                        placeholder="Present Address" name="PresentAddress" required>
                                </div>
                            </div>
                        </div>

                        <!-- Fourth Row: Username -->
                        <div class="mb-3">
                            <label for="Username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="Username" placeholder="Username" name="Username"
                                autocomplete="off" required>
                        </div>

                        <!-- Fifth Row: Password, Confirm Password -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="Password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="Password" name="Password"
                                            placeholder="Password" required pattern="(?=.*\d)(?=.*[a-zA-Z]).{8,}"
                                            title="Password must be at least 8 characters long and contain both numbers and letters">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ConfirmPassword" class="form-label">Confirm Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="ConfirmPassword"
                                            name="ConfirmPassword" placeholder="Confirm Password" required
                                            pattern="(?=.*\d)(?=.*[a-zA-Z]).{8,}"
                                            title="Password must be at least 8 characters long and contain both numbers and letters">
                                        <button class="btn btn-outline-secondary" type="button"
                                            id="toggleConfirmPassword">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div id="passwordError" class="text-danger"></div>
                        </div>

                        <!-- I agree to the terms checkbox -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label" for="terms">Please Check to Confirm your
                                Information;</label>
                        </div>

                        <div class="modal-footer">
                            <!-- Register Button -->
                            <button type="submit" class="btn btn-primary">Register</button>
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- modalregPatient -->

    <!-- modalregClient -->
    <div class="modal fade" id="myModalRegClient" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Register As Client</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="formClient" id="registrationFormClient" action="registration_client.php" method="POST"
                        onsubmit="return showSuccessAlert('Client Registration');">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_name" class="form-label">Client Name</label>
                                    <input type="text" class="form-control" id="client_name" name="client_name"
                                        placeholder="Client Name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="position" class="form-label">Position</label>
                                    <input type="text" class="form-control" id="position" name="position"
                                        placeholder="Position" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="company_name" class="form-label">Company Name</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name"
                                        placeholder="Company Name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="contact_number" class="form-label">Contact Number</label>
                                    <input type="text" class="form-control" id="contact_number" name="contact_number"
                                        placeholder="Contact Number" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" placeholder="Address" name="address"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="email_address" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email_address" placeholder="Email Address"
                                name="email_address" autocomplete="off" required>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms_client" required>
                            <label class="form-check-label" for="terms_client">Please Check to Confirm your
                                Information;</label>
                        </div>

                        <div class="modal-footer">
                            <!-- Register Button -->
                            <button type="submit" class="btn btn-primary">Register</button>
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- modalregClient -->


    <!-- Terms and Conditions Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="termsModalLabel">Terms and Conditions</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body terms-body px-4">
                    <p class="mb-3">
                        Welcome to our appointment scheduling system. Before proceeding with the registration for an
                        appointment, it is crucial that you fully understand and agree to our terms and conditions.
                    </p>
                    <p class="mb-3">
                        By continuing, you acknowledge that you have reviewed all the necessary requirements and
                        instructions related to our services. Please make sure you have read the detailed guidelines
                        provided on our
                        <a href="services.php" target="_blank" class="btn btn-link p-0">Services Page</a>.
                    </p>
                    <p class="mb-3">
                        These terms include, but are not limited to, the following:
                    </p>
                    <ul class="mb-3 ps-4">
                        <li>Eligibility criteria for appointment scheduling.</li>
                        <li>Required documents and information for the appointment.</li>
                        <li>Cancellation and rescheduling policies.</li>
                        <li>Any fees or charges associated with the services.</li>
                    </ul>
                    <p class="mb-3">
                        It is your responsibility to ensure that you meet all requirements and follow the
                        instructions
                        provided. Failure to do so may result in delays or inability to proceed with the appointment
                        registration.
                    </p>
                    <div class="form-check d-flex align-items-center mt-4">
                        <input class="form-check-input me-2" type="checkbox" id="agreeCheckbox">
                        <label class="form-check-label" for="agreeCheckbox">
                            I have read, understood, and agree to the terms and conditions outlined above.
                        </label>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5 mt-4">
            <h1 class="display-2 text-white mb-3 animated slideInDown">Reviews</h1>

            <!-- Buttons visible on smaller screens -->
            <div class="d-lg-none mt-4">
                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#myModal">
                    Login
                </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#termsModal">
                    Register for Appointment
                </button>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Testimonial Start -->
    <div class="container-fluid testimonial py-5">
        <div class="container pt-5">
            <div class="row gy-5 gx-0">
                <div class="col-lg-6 pe-lg-5 wow fadeIn" data-wow-delay="0.3s">
                    <h1 class="display-6 text-white mb-4">What Clients Say About Our Diagnostic Services!</h1>
                    <p class="text-white mb-5">"At our Clinic, we prioritize accurate results and compassionate care.
                        Our patients consistently appreciate the thoroughness of our diagnostic testing and the
                        expertise of our medical professionals. We are committed to providing timely, reliable results
                        to ensure that each patient receives the best possible care."</p>
                </div>
                <div class="col-lg-6 mb-n5 wow fadeIn" data-wow-delay="0.5s">
                    <div class="bg-white p-5">
                        <div class="owl-carousel testimonial-carousel wow fadeIn" data-wow-delay="0.1s">
                            <?php
                            // Fetch and display reviews from database
                            while ($row = $result->fetch_assoc()) {
                                $rating = $row['rating'];
                                echo '<div class="testimonial-item">';
                                echo '<div class="icon-box-primary mb-4">';
                                echo '<i class="bi bi-chat-left-quote text-dark"></i>';
                                echo '</div>';
                                echo '<p class="fs-5 mb-4">' . $row['review'] . '</p>';
                                echo '<div class="d-flex align-items-center">';
                                echo '<img class="flex-shrink-0" src="images/icon-profile-user.png" alt="">'; // You can change the image if needed
                                echo '<div class="ps-3">';
                                echo '<h5 class="mb-1">' . $row['name'] . '</h5>';
                                echo '<span class="text-primary">' . $row['profession'] . '</span>';
                                echo '</div>';
                                echo '</div>';
                                echo '<div class="stars">';
                                // Display stars based on rating
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $rating) {
                                        echo '<span class="star">&#9733;</span>';
                                    } else {
                                        echo '<span class="star">&#9734;</span>';
                                    }
                                }
                                echo '</div>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->


    <!-- Review Submission Start -->
    <div class="container py-5">
        <h2 class="text-center mb-4">Share Your Review</h2>
        <form id="reviewForm" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="profession" class="form-label">Your Profession</label>
                <input type="text" class="form-control" id="profession" name="profession" required>
            </div>
            <div class="mb-3">
                <label for="review" class="form-label">Your Review</label>
                <textarea class="form-control" id="review" name="review" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label for="rating">Your Rating (0-5):</label>
                <input type="number" id="ratingInput" name="rating" class="form-control" min="0" max="5" step="0.1"
                    value="0" required>
                <small>Rate between 0 to 5 with decimal points allowed (e.g., 4.5)</small>
            </div>
            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>
    </div>
    <!-- Review Submission End -->



    <!-- Footer Start -->
    <div class="container-fluid footer position-relative bg-dark text-white-50 py-5 wow fadeIn" data-wow-delay="0.1s"
        id="footer">
        <div class="container">
            <div class="row g-5 py-5">
                <div class="col-lg-6 pe-lg-5">
                    <a href="index.html" class="navbar-brand">
                        <h1 class="h1 text-primary mb-0">Brain Master <span class="text-white">DC</span></h1>
                    </a>
                    <p class="fs-5 mb-4">You are free to contact us anytime! We are please to serve you.</p>
                    <p><i class="fa fa-map-marker-alt me-2"></i>303, Sujeco Building, 1754 E Rodriguez Sr. Ave,
                        Immaculate Conception, Quezon City, 1111 Metro Manila</p>
                    <p><i class="fa fa-phone-alt me-2"></i>+0921 2854 178</p>
                    <p><i class="fa fa-envelope me-2"></i>brainmasterdc@gmail.com</p>
                </div>
                <div class="col-lg-6 ps-lg-5">
                    <div class="row g-5">
                        <div class="col-sm-6">
                            <h4 class="text-light mb-4">Quick Links</h4>
                            <a class="btn btn-link" href="index.php">Home</a>
                            <a class="btn btn-link" href="services.php">Services</a>
                            <a class="btn btn-link" href="services.php">Requirements</a>
                            <a class="btn btn-link" href="reviews.php">Reviews / Testimony</a>
                        </div>
                        <div class="col-sm-6">
                            <h4 class="text-light mb-4">Popular Links</h4>
                            <a class="btn btn-link" href="services.php">Services</a>
                            <a class="btn btn-link" href="services.php">Requirements</a>
                            <a class="btn btn-link" href="reviews.php">Reviews</a>
                        </div>
                        <div class="col-sm-12">
                            <h4 class="text-light mb-4">Newsletter</h4>
                            <div class="w-100">
                                <div class="input-group">
                                    <input type="text" class="form-control border-0 py-3 px-4"
                                        style="background: rgba(255, 255, 255, .1);"
                                        placeholder="Your Email Address"><button class="btn btn-primary px-4">Sign
                                        Up</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Copyright Start -->
    <div class="container-fluid copyright bg-dark text-white-50 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; <a href="#">BrainMasterDC.com</a>. All Rights Reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                    <p class="mb-0">Designed by SEA Coder</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->

    <!-- Back to Top -->
    <a href="#top" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i
            class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./ui/wow.min.js"></script>
    <script src="./ui/easing.min.js"></script>
    <script src="./ui/waypoints.min.js"></script>
    <script src="./ui/counterup.min.js"></script>
    <script src="./ui/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="./ui/main.js"></script>

    <script>
        $(document).ready(function () {
            window.setTimeout(function () {
                $("#alert").fadeTo(1000, 0).slideUp(1000, function () {
                    $(this).remove();
                });
            }, 5000);
        });

        $(document).ready(function () {
            $('#togglePassword').click(function () {
                const passwordField = $('#Password');
                const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
                passwordField.attr('type', type);
                $(this).find('i').toggleClass('fa-eye fa-eye-slash');
            });

            $('#toggleConfirmPassword').click(function () {
                const confirmPasswordField = $('#ConfirmPassword');
                const type = confirmPasswordField.attr('type') === 'password' ? 'text' : 'password';
                confirmPasswordField.attr('type', type);
                $(this).find('i').toggleClass('fa-eye fa-eye-slash');
            });

            $('#toggleLoginPassword').click(function () {
                const passwordField = $('#loginPassword');
                const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
                passwordField.attr('type', type);
                $(this).find('i').toggleClass('fa-eye fa-eye-slash');
            });

        });



        document.getElementById('registrationForm').addEventListener('submit', function (event) {
            document.getElementById('passwordError').textContent = '';

            var password = document.getElementById('Password').value;
            var confirmPassword = document.getElementById('ConfirmPassword').value;


            if (password !== confirmPassword) {
                document.getElementById('passwordError').textContent = 'Passwords do not match.';
                event.preventDefault();
            }
        });

        document.getElementById('loginForm').addEventListener('submit', function (event) {
            event.preventDefault();

            var formData = new FormData(this);
            fetch('login.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(result => {
                    if (result.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: result.message,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            window.location.href = result.redirect;
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: result.message,
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred. Please try again later.',
                    });
                });
        });

        function showSuccessAlert(role) {
            Swal.fire({
                icon: 'success',
                title: 'Registration Successful',
                text: `You have registered as ${role}.`,
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If the alert is confirmed, submit the form
                    document.getElementById(role === 'Patient Registration' ? 'registrationForm' : 'registrationFormClient').submit();
                }
            });
            return false; // Prevent the default form submission for now
        }



        document.addEventListener('DOMContentLoaded', function () {
            const patientButton = document.getElementById('patientButton');
            const clientButton = document.getElementById('clientButton');
            const termsModal = document.getElementById('agreeCheckBox');

            if (patientButton) {
                patientButton.addEventListener('click', function () {
                    // Hide the Terms modal
                    $('#myModalReg').modal('hide');

                    // Show the next modal
                    $('#myModalRegPatient').modal('show');
                });
            }

            if (clientButton) {
                clientButton.addEventListener('click', function () {
                    // Hide the Terms modal
                    $('#myModalReg').modal('hide');

                    // Show the next modal
                    $('#myModalRegClient').modal('show');
                });
            }

            if (termsModal) {
                termsModal.addEventListener('change', function () {
                    if (this.checked) {
                        // Hide the Terms modal
                        $('#termsModal').modal('hide');

                        // Show the next modal
                        $('#nextModal').modal('show');
                    }

                });
            }
        });

        // When the checkbox is checked, trigger the second modal
        document.getElementById('agreeCheckbox').addEventListener('change', function () {
            if (this.checked) {
                // Hide the Terms modal
                $('#termsModal').modal('hide');

                // Show the next modal
                $('#myModalReg').modal('show');
            }
        });

        // Reset checkbox when the terms modal is opened
        $('#termsModal').on('shown.bs.modal', function () {
            // Uncheck the checkbox when the modal is shown
            document.getElementById('agreeCheckbox').checked = false;
        });

        const ratingInput = document.getElementById('ratingInput');
        ratingInput.addEventListener('input', function () {
            let rating = parseFloat(ratingInput.value);
            if (rating < 0) rating = 0;  // Restrict to a minimum of 0
            if (rating > 5) rating = 5;  // Restrict to a maximum of 5
            ratingInput.value = rating.toFixed(1); // Show one decimal place
        });


        // AJAX to submit the review without reloading the page
        $('#reviewForm').submit(function (e) {
            e.preventDefault(); // Prevent the form from submitting normally

            $.ajax({
                type: 'POST',
                url: 'submit_review.php',
                data: $(this).serialize(),
                success: function (response) {
                    // Display a SweetAlert success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Review Submitted!',
                        text: 'Thank you for your feedback.',
                        confirmButtonText: 'Close'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // After confirming the success message, reload the page
                            location.reload(); // This will reload the page
                        }
                    });
                },
                error: function () {
                    alert('Something went wrong. Please try again.');
                }
            });
        });

    </script>
</body>

</html>