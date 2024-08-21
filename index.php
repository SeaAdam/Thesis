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
            <img src="assets/download1.jpg" alt="BMDC Logo" class="logo">

            <div>
                <button id="openModalBtnReg" type="button" class="btn btn-danger button">REGISTER NOW</button>
                <button id="openModalBtn" type="button" class="btn btn-success button">LOGIN</button>
            </div>

            <!-- The Modal -->
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Login Page</h2>
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
                                    <input type="password" class="form-control" id="loginPassword" name="loginPassword"
                                        placeholder="Enter your password" required>
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
                                </select>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="#">Forgot Password?</a>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn-primary button">Login</button>
                                <button type="button" id="closeModalBtn" class="btn-dark button"
                                    data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div id="myModalReg" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Register As Page</h2>
                    </div>
                    <div class="modal-body">
                        <img src="assets/download1.jpg" alt="Logo" class="login-logo">
                        <div class="regButtons">
                            <button id="modalRegPatient" type="submit" class="btn btn-danger button">REGISTER AS A
                                PATIENT</button>
                            <button id="modalRegClient" type="submit" class="btn btn-warning button">REGISTER AS A
                                CLIENT</button>

                        </div>

                        <div class="modal-footer">
                            <button type="button" id="closeModalBtnReg" class="btn-dark button"
                                data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="myModalRegPatient" class="modal">
                <div class="modal-content regForm">
                    <div class="modal-header">
                        <h2 class="modal-title">Register As Patient</h2>
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
                                <div class="form-group col-md-2">
                                    <label for="MI">M.I.</label>
                                    <input type="text" class="form-control" id="MI" name="MI" placeholder="M.I."
                                        maxlength="1">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="LastName">Last Name</label>
                                    <input type="text" class="form-control" id="LastName" name="LastName"
                                        --placeholder="Last Name" required>
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
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="terms" required>
                                <label class="form-check-label" for="terms">I agree to the terms and conditions</label>
                            </div>

                            <div class="modal-footer">
                                <!-- Register Button -->
                                <button type="submit" class="btn-primary button">Register</button>
                                <button type="button" id="closeModalBtnRegPatient" class="btn-dark button"
                                    data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
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


    <script src="js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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
    </script>



</body>

</html>