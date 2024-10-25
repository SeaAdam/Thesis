<a?php session_start(); ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>This is new index</title>

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Red+Rose:wght@600;700&display=swap"
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

        <style>
            input {
                text-transform: none;
            }

            .about {
                padding: 40px 0;
                background-color: #f9f9f9;
            }

            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 20px;
            }

            .about h2 {
                text-align: center;
                margin-bottom: 20px;
                font-size: 2rem;
                color: #2c3e50;

            }

            .about p {
                text-align: center;
                margin-bottom: 30px;
                font-size: 1.1rem;
                color: #34495e;
            }

            .business-model {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                gap: 20px;
            }

            .model-item {
                background-color: #ffffff;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 20px;
                flex: 1 1 30%;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s;
            }

            .model-item h4 {
                margin-bottom: 10px;
                color: #333;
            }

            .model-item p {
                color: #555;
            }

            .model-item:hover {
                transform: translateY(-5px);
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
                    <a href="new_index.php" class="h1 text-white mb-0">Brain Master <span class="text-dark">Diagnostic
                            Center (BMDC)</span> Appoinment</a>
                </div>
            </div>
        </div>

        <!-- Brand End -->


        <!-- Navbar Start -->
        <div class="container-fluid sticky-top">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light bg-white py-lg-0 px-lg-3">
                    <a href="new_index.php" class="navbar-brand d-lg-none">
                        <h1 class="text-primary m-0">Lab<span class="text-dark">sky</span></h1>
                    </a>
                    <button type="button" class="navbar-toggler me-0" data-bs-toggle="collapse"
                        data-bs-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <div class="navbar-nav">
                            <a href="new_index.php" class="nav-item nav-link active">Home</a>
                            <a href="new_services.php" class="nav-item nav-link">Services and Requirements</a>
                            <a href="new_reviews.php" class="nav-item nav-link">Reviews</a>
                            <a href="#footer" class="nav-item nav-link">Contacts</a>
                        </div>
                        <div class="ms-auto d-none d-lg-flex">
                            <button type="button" class="btn btn-primary me-2" data-toggle="modal"
                                data-target="#myModal">
                                Login
                            </button>
                            <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                data-target="#termsModal">
                                Register for Appoinment
                            </button>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Navbar End -->


        <!-- Page Header Start -->
        <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container text-center py-5 mt-4">
                <h1 class="display-2 text-white mb-3 animated slideInDown">Home</h1>
                <nav aria-label="breadcrumb animated slideInDown">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="new_index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="#about">About Us</a></li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header End -->


        <!-- About Start -->
        <div class="container-fluid py-5">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="row g-0">
                            <div class="col-6">
                                <img class="img-fluid" src="assets/features-1.webp">
                            </div>
                            <div class="col-6">
                                <img class="img-fluid" src="assets/new.webp">
                            </div>
                            <div class="col-6">
                                <img class="img-fluid" src="assets/brain.webp">
                            </div>
                            <div class="col-6">
                                <div
                                    class="bg-primary w-100 h-100 mt-n5 ms-n5 d-flex flex-column align-items-center justify-content-center">
                                    <div class="icon-box-light">
                                        <i class="bi bi-award text-dark"></i>
                                    </div>
                                    <h1 class="display-1 text-white mb-0" data-toggle="counter-up">25</h1>
                                    <small class="fs-5 text-white">Years Experience</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                        <h1 class="display-6 mb-4">Trusted Lab Experts and Latest Lab Technologies</h1>
                        <p class="mb-4">Welcome to Brain Master Diagnostic Center, a trusted provider of specialized
                            diagnostic services for over a decade. We pride ourselves on delivering high-quality,
                            reliable
                            diagnostic tests, including drug testing, neurological examinations, and psychological
                            assessments. Our center is equipped with advanced technology and staffed by a team of
                            skilled
                            professionals dedicated to providing accurate and comprehensive care.</p>
                        <div class="row g-4 g-sm-5 justify-content-center">
                            <div class="col-sm-6">
                                <div class="about-fact btn-square flex-column rounded-circle bg-primary ms-sm-auto">
                                    <p class="text-white mb-0">Diagnostic Centers</p>
                                    <h1 class="text-white mb-0" data-toggle="counter-up">3</h1>
                                </div>
                            </div>
                            <div class="col-sm-6 text-start">
                                <div class="about-fact btn-square flex-column rounded-circle bg-secondary me-sm-auto">
                                    <p class="text-white mb-0">Partnered Companies</p>
                                    <h1 class="text-white mb-0" data-toggle="counter-up">15</h1>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div
                                    class="about-fact mt-n130 btn-square flex-column rounded-circle bg-dark mx-sm-auto">
                                    <p class="text-white mb-0">Happy Clients</p>
                                    <h1 class="text-white mb-0" data-toggle="counter-up">1000</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->


        <!-- Features Start -->
        <div class="container-fluid feature my-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container">
                <div class="row g-0">
                    <div class="col-lg-6 pt-lg-5">
                        <div class="bg-white p-5 mt-lg-5">
                            <h1 class="display-6 mb-4 wow fadeIn" data-wow-delay="0.3s">Brain Master Diagnostic and
                                Medical
                                Center</h1>
                            <p class="mb-4 wow fadeIn" data-wow-delay="0.4s">Our services cater to individual patients
                                needing specialized diagnostics, healthcare providers referring patients, corporate
                                clients
                                requiring employee health assessments, and government agencies seeking certified
                                diagnostic
                                services.</p>
                            <div class="row g-5 pt-2 mb-5">
                                <div class="col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                                    <div class="icon-box-primary mb-4">
                                        <i class="bi bi-person-plus text-dark"></i>
                                    </div>
                                    <h5 class="mb-3">Experience Doctors</h5>
                                    <span>We have realible Doctors for your service needs.</span>
                                </div>
                                <div class="col-sm-6 wow fadeIn" data-wow-delay="0.4s">
                                    <div class="icon-box-primary mb-4">
                                        <i class="bi bi-check-all text-dark"></i>
                                    </div>
                                    <h5 class="mb-3">Well-Founded Diagnostic Center</h5>
                                    <span>
                                        At Brain Master Diagnostic Center, we pride ourselves on our commitment to
                                        excellence in diagnostic services.
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row h-100 align-items-end">
                            <div class="col-12">
                                <div class="bg-primary p-5">
                                    <div class="experience mb-4 wow fadeIn" data-wow-delay="0.3s">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-white">Diagnostic Accuracy</span>
                                            <span class="text-white">98%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-dark" role="progressbar" aria-valuenow="98"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="experience mb-4 wow fadeIn" data-wow-delay="0.4s">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-white">Patient Satisfaction</span>
                                            <span class="text-white">95%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-dark" role="progressbar" aria-valuenow="95"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="experience mb-0 wow fadeIn" data-wow-delay="0.5s">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-white">Turnaround Time</span>
                                            <span class="text-white">85%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-dark" role="progressbar" aria-valuenow="85"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Features End -->

        <section class="about" id="about">
            <div class="container">
                <h2>About Us</h2>

                <div class="business-model">
                    <div class="model-item">
                        <h4>Customer Segments</h4>
                        <p>We serve individual patients, healthcare providers, corporate clients, and government
                            agencies.
                        </p>
                    </div>

                    <div class="model-item">
                        <h4>Revenue Streams</h4>
                        <p>Revenue comes from diagnostic services, corporate contracts, and government projects.</p>
                    </div>

                    <div class="model-item">
                        <h4>Key Resources</h4>
                        <p>Our key resources include experienced staff, advanced equipment, and necessary
                            certifications.
                        </p>
                    </div>

                    <div class="model-item">
                        <h4>Key Activities</h4>
                        <p>We focus on conducting tests, maintaining compliance, and coordinating patient care.</p>
                    </div>

                    <div class="model-item">
                        <h4>Key Partnerships</h4>
                        <p>We collaborate with partner doctors, healthcare institutions, and government agencies.</p>
                    </div>
                </div>
            </div>
        </section>



        <!-- Footer Start -->
        <div class="container-fluid footer position-relative bg-dark text-white-50 py-5 wow fadeIn"
            data-wow-delay="0.1s" id="footer">
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
                                <a class="btn btn-link" href="new_index.php">Home</a>
                                <a class="btn btn-link" href="new_services.php">Services</a>
                                <a class="btn btn-link" href="new_services.php">Requirements</a>
                                <a class="btn btn-link" href="new_reviews.php">Reviews / Testimony</a>
                            </div>
                            <div class="col-sm-6">
                                <h4 class="text-light mb-4">Popular Links</h4>
                                <a class="btn btn-link" href="new_services.php">Services</a>
                                <a class="btn btn-link" href="new_services.php">Requirements</a>
                                <a class="btn btn-link" href="new_reviews.php">Reviews</a>
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





    </body>

    </html>