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
                        <form>
                            <div class="form-group">
                                <input type="text" class="form-control" id="username" placeholder="Enter your username">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="password"
                                    placeholder="Enter your password">
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
                        <form class="formPatient">
                            <!-- First Row: First Name, Middle Initial, Last Name -->
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="firstName">First Name</label>
                                    <input type="text" class="form-control" id="firstName" placeholder="First Name"
                                        required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="middleInitial">M.I.</label>
                                    <input type="text" class="form-control" id="middleInitial" placeholder="M.I."
                                        maxlength="1">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lastName">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" placeholder="Last Name"
                                        required>
                                </div>
                            </div>

                            <!-- Second Row: Gender, Date of Birth, Age -->
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="gender">Gender</label>
                                    <select id="gender" class="form-control" required>
                                        <option value="" disabled selected>Choose...</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="dob">Date of Birth</label>
                                    <input type="date" class="form-control" id="dob" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="age">Age</label>
                                    <input type="number" class="form-control" id="age" placeholder="Age" required>
                                </div>
                            </div>

                            <!-- Third Row: Contact, Address -->
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="contact">Contact</label>
                                    <input type="text" class="form-control" id="contact" placeholder="Contact" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" placeholder="Address" required>
                                </div>
                            </div>

                            <!-- Fourth Row: Username -->
                            <div class="form-group" style="margin-left: 0; width: 100%;">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" placeholder="Username" required>
                            </div>

                            <!-- Fifth Row: Password, Confirm Password -->
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="Password"
                                        required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="confirmPassword">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirmPassword"
                                        placeholder="Confirm Password" required>
                                </div>
                            </div>

                            <!-- I agree to the terms checkbox -->
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="terms" required>
                                <label class="form-check-label" for="terms">I agree to the terms and conditions</label>
                            </div>

                            <!-- Register Button -->
                            <button type="submit" class="btn btn-primary">Register</button>
                        </form>

                        <div class="modal-footer">
                            <button type="button" id="closeModalBtnRegPatient" class="btn-dark button"
                                data-bs-dismiss="modal">Cancel</button>
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


    <script src="js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>

</body>

</html>