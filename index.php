<?php
session_start();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brain Master Diagnostic Center</title>
    <link href="css/index.css" rel="stylesheet">

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- bootstrap link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        input {
            text-transform: none;
        }
    </style>



</head>

<body>

    <!-- header section starts -->
    <header class="header fixed-top">

        <div class="container">

            <div class="row align-items-center justify-content-between">

                <a href="#home" class="logo">Brain Master<span> DC</span></a>

                <nav class="nav">
                    <a href="#home">Home</a>
                    <a href="about.php">About</a>
                    <a href="services.php">Services</a>
                    <a href="reviews.php">Reviews</a>
                    <a href="#contacts">Contacts</a>
                </nav>

                <div id="menu-btn" class="fas fa-bars"></div>
            </div>

        </div>

    </header>

    <!-- header section ends -->
    <?php
    if (isset($_SESSION['Registered'])) {
        echo "
                        <div class='alert alert-success alert-dismissable' id='alert' style='background: green;border-radius: 5px;padding:10px;color: #fff;margin:80px 0px 10px 0px;'>
                            <h4><i class='fa fa-check-circle' aria-hidden='true'></i> Success!</h4>
                            <p>Registered Successfully!;</p>
                        </div>
                    ";

        unset($_SESSION['Registered']);
    }


    if (isset($_SESSION['errorInformationAlreadyRegistered'])) {
        echo "
                        <div class='alert alert-dark alert-dismissable' id='alert' style='background: red;border-radius: 5px;padding:10px;color: #fff;margin:80px 0px 10px 0px;'>
                            <h4><i class='fa fa-check-circle' aria-hidden='true'></i> Error!</h4>
                            <p>Information Already Registered!;</p>
                        </div>
                    ";

        // Clear the alert message
        unset($_SESSION['errorInformationAlreadyRegistered']);
    }
    if (isset($_SESSION['InvalidPass'])) {
        echo "
                        <div class='alert alert-success alert-dismissable' id='alert' style='background: red;border-radius: 5px;padding:10px;color: #fff;margin:80px 0px 10px 0px;'>
                            <h4><i class='fa fa-check-circle' aria-hidden='true'></i> Error!</h4>
                            <p>Invalid Password!;</p>
                        </div>
                    ";

        unset($_SESSION['InvalidPass']);
    }


    if (isset($_SESSION['InvalidUser'])) {
        echo "
                        <div class='alert alert-dark alert-dismissable' id='alert' style='background: red;border-radius: 5px;padding:10px;color: #fff;margin:80px 0px 10px 0px;'>
                            <h4><i class='fa fa-check-circle' aria-hidden='true'></i> Error!</h4>
                            <p>No User Found!;</p>
                        </div>
                    ";

        // Clear the alert message
        unset($_SESSION['InvalidUser']);
    }
    ?>





    <!-- home start here -->

    <section class="home" id="home">
        <div class="content">
            <h1>
                <span class="fancy-text">B</span><span class="rest-text">RAIN</span>
                <span class="fancy-text">M</span><span class="rest-text">ASTER</span>
                <span class="fancy-text">D</span><span class="rest-text">IAGNOSTIC</span>
                <span class="fancy-text">C</span><span class="rest-text">ENTER</span>
                <span class="fancy-text">(B</span><span class="rest-text">MDC)</span>
                <span class="fancy-text">A</span><span class="rest-text">PPOINTMENT</span>
            </h1>

            <div>
                <button type="button" class="btn btn-danger button" data-toggle="modal" data-target="#termsModal">
                    REGISTER FOR APPOINTMENT
                </button>
                <button type="button" class="btn btn-success button" data-toggle="modal" data-target="#myModal">
                    LOGIN
                </button>
            </div>

            <!-- Modals -->

            <!-- modal login -->
            <div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Login Page</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img src="assets/download1.jpg" alt="Logo" class="login-logo">
                            <form id="loginForm" action="login.php" method="POST">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="usernameLogin" name="usernameLogin"
                                        placeholder="Enter your username" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="loginPassword"
                                            name="loginPassword" placeholder="Enter your password" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="toggleLoginPassword">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="loginType">Login as:</label>
                                    <select name="loginType" class="form-control" required>
                                        <option value="user">User</option>
                                        <option value="admin">Admin</option>
                                        <option value="clients">Client</option>
                                    </select>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="#">Forgot Password?</a>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary button">Login</button>
                                    <button type="button" class="btn btn-secondary button"
                                        data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal login -->

            <!-- modal register -->
            <div class="modal fade" id="myModalReg" data-backdrop="static" data-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Registration</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img src="assets/download1.jpg" alt="Logo" class="login-logo">
                            <div class="regButtons">
                                <button type="submit" id="patientButton" class="btn btn-danger button">
                                    REGISTER AS A PATIENT
                                </button>
                                <button type="submit" id="clientButton" class="btn btn-warning button">
                                    REGISTER AS A CLIENT
                                </button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark button" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal register -->

            <!-- modalregPatient -->
            <div class="modal fade" id="myModalRegPatient" data-backdrop="static" data-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Register As Patient</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="formPatient" id="registrationForm" action="registration.php" method="POST">
                                <!-- First Row: First Name, Middle Initial, Last Name -->
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="FirstName">First Name</label>
                                        <input type="text" class="form-control" id="FirstName" name="FirstName"
                                            placeholder="First Name" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="MI">M.I.</label>
                                        <input type="text" class="form-control" id="MI" name="MI" placeholder="M.I."
                                            maxlength="1">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="LastName">Last Name</label>
                                        <input type="text" class="form-control" id="LastName" name="LastName"
                                            placeholder="Last Name" required>
                                    </div>
                                </div>

                                <!-- Second Row: Gender, Date of Birth, Age -->
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="Gender">Gender</label>
                                        <select id="Gender" class="form-control" name="Gender" required>
                                            <option value="" disabled selected>Choose...</option>
                                            <option>Male</option>
                                            <option>Female</option>
                                            <option>Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="DOB">Date of Birth</label>
                                        <input type="date" class="form-control" id="DOB" name="DOB" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="Age">Age</label>
                                        <input type="number" class="form-control" id="Age" placeholder="Age" name="Age"
                                            required>
                                    </div>
                                </div>

                                <!-- Third Row: Contact, Address -->
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="Contact">Contact</label>
                                        <input type="text" class="form-control" id="Contact" placeholder="Contact"
                                            name="Contact" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="PresentAddress">Address</label>
                                        <input type="text" class="form-control" id="PresentAddress"
                                            placeholder="PresentAddress" name="PresentAddress" required>
                                    </div>
                                </div>

                                <!-- Fourth Row: Username -->
                                <div class="form-group" style="margin-left: 0; width: 100%;">
                                    <label for="Username">Username</label>
                                    <input type="text" class="form-control" id="Username" placeholder="Username"
                                        name="Username" autocomplete="off" required>
                                </div>

                                <!-- Fifth Row: Password, Confirm Password -->
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="Password">Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="Password" name="Password"
                                                placeholder="Password" required pattern="(?=.*\d)(?=.*[a-zA-Z]).{8,}"
                                                title="Password must be at least 8 characters long and contain both numbers and letters">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="togglePassword">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="ConfirmPassword">Confirm Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="ConfirmPassword"
                                                name="ConfirmPassword" placeholder="Confirm Password" required
                                                pattern="(?=.*\d)(?=.*[a-zA-Z]).{8,}"
                                                title="Password must be at least 8 characters long and contain both numbers and letters">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="toggleConfirmPassword">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="passwordError" class="text-danger"></div>
                                </div>

                                <!-- I agree to the terms checkbox -->
                                <div class="form-check" style="margin-bottom: 1rem ;">
                                    <input type="checkbox" class="form-check-input" id="terms" required>
                                    <label class="form-check-label" for="terms">Please Check to Confirm your Information;</label>
                                </div>

                                <div class="modal-footer">
                                    <!-- Register Button -->
                                    <button type="submit" class="btn btn-primary button">Register</button>
                                    <button type="button" class="btn btn-dark button"
                                        data-dismiss="modal">Cancel</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modalregPatient -->

            <!-- modalregClient-->
            <div class="modal fade" id="myModalRegClient" data-backdrop="static" data-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Register As Client</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="formClient" id="registrationFormClient" action="registration_client.php"
                                method="POST">

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="client_name">Client Name</label>
                                        <input type="text" class="form-control" id="client_name" name="client_name"
                                            placeholder="Client Name" required>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="position">Position</label>
                                        <input type="text" class="form-control" id="position" name="position"
                                            placeholder="Position" required>
                                    </div>
                                </div>


                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="company_name">Company Name</label>
                                        <input type="text" class="form-control" id="company_name" name="company_name"
                                            placeholder="Company Name" required>
                                        <!-- <select class="form-control" name="company_name" id="company_name">
                                        <option>--SELECT--</option>
                                        <option>Accenture</option>
                                    </select> -->
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="contact_number">Contact Number</label>
                                        <input type="text" class="form-control" id="contact_number"
                                            name="contact_number" placeholder="Contact Number" required>
                                    </div>
                                </div>


                                <div class="form-group" style="margin-left: 0; width: 100%;">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" placeholder="Address"
                                        name="address" required>
                                </div>


                                <div class="form-group" style="margin-left: 0; width: 100%;">
                                    <label for="email_address">Email Address</label>
                                    <input type="text" class="form-control" id="email_address" placeholder="@"
                                        name="email_address" autocomplete="off" required>
                                </div>

                                <div class="form-check" style="margin-bottom: 1rem ;">
                                    <input type="checkbox" class="form-check-input" id="terms" required>
                                    <label class="form-check-label" for="terms">Please Check to Confirm your Information;</label>
                                </div>

                                <div class="modal-footer">
                                    <!-- Register Button -->
                                    <button type="submit" class="btn-primary button">Register</button>
                                    <button type="button" class="btn btn-dark button"
                                        data-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modalregClient -->

            <!-- Terms and Conditions Modal -->
            <div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" id="termsModalLabel">Terms and Conditions</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body terms-body">
                            <p>
                                Welcome to our appointment scheduling system. Before proceeding with the registration
                                for an appointment,
                                it is crucial that you fully understand and agree to our terms and conditions.
                            </p>
                            <p>
                                By continuing, you acknowledge that you have reviewed all the necessary requirements and
                                instructions
                                related to our services. Please make sure you have read the detailed guidelines provided
                                on our
                                <a href="services.php" target="_blank" class="btn btn-link">Services Page</a>.
                            </p>
                            <p>
                                These terms include, but are not limited to, the following:
                            </p>
                            <ul>
                                <li>Eligibility criteria for appointment scheduling.</li>
                                <li>Required documents and information for the appointment.</li>
                                <li>Cancellation and rescheduling policies.</li>
                                <li>Any fees or charges associated with the services.</li>
                            </ul>
                            <p>
                                It is your responsibility to ensure that you meet all requirements and follow the
                                instructions provided.
                                Failure to do so may result in delays or inability to proceed with the appointment
                                registration.
                            </p>
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="agreeCheckbox">
                                <label class="form-check-label" for="agreeCheckbox">
                                    I have read, understood, and agree to the terms and conditions outlined above.
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary button" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </section>




    <!-- home ends here -->




    <!-- footer -->

    <section class="footer" id="contacts">

        <div class="box-container container">

            <div class="box">
                <i class="fas fa-phone"></i>
                <h3>Phone Number</h3>
                <p>+123-456-7890</p>
                <p>+123-456-7890</p>
            </div>

            <div class="box">
                <i class="fas fa-map-marker-alt"></i>
                <h3>Our Address</h3>
                <p>Manila, Philippines</p>
            </div>

            <div class="box">
                <i class="fas fa-clock"></i>
                <h3>Opening Hours</h3>
                <p>8:00 AM - 5:00 PM</p>
            </div>

            <div class="box">
                <i class="fas fa-envelope"></i>
                <h3>Email</h3>
                <p>qwerty@gmail.com</p>
            </div>

        </div>

        <div class="credit"> All Rights Reservered <span>System for Capstone @EARIST</span> </div>

    </section>

    <!-- footer -->


    <!-- Load jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Load Bootstrap JS (make sure it's after jQuery) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>

    <!-- Custom JS (your code) -->
    <script src="js/index.js"></script>



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
            // Clear previous error messages
            document.getElementById('passwordError').textContent = '';

            // Get password and confirm password values
            var password = document.getElementById('Password').value;
            var confirmPassword = document.getElementById('ConfirmPassword').value;

            // Check if passwords match
            if (password !== confirmPassword) {
                document.getElementById('passwordError').textContent = 'Passwords do not match.';
                event.preventDefault(); // Prevent form submission
            }
        });

        document.getElementById('loginForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission

            var formData = new FormData(this);
            fetch('login.php', { // Replace with your actual PHP script
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


    </script>



</body>

</html>