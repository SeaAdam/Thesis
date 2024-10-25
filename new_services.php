<?php
session_start();


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

    <style>
        input {
            text-transform: none;
        }

        /* Exclusive styling for Business Accreditation and Protocols section */
        #accreditation-protocols.accreditation-section {
            padding: 50px 0;
            background-color: #f8f9fa;
        }

        .accreditation-container {
            max-width: 1200px;
            /* Sets a maximum width for the container */
            margin: 0 auto;
            /* Centers the container */
            padding: 0 20px;
            /* Adds horizontal padding */
        }

        .accreditation-title {
            text-align: center;
            /* Centers the title text */
            font-size: 32px;
            margin-bottom: 30px;
            color: #333;
        }

        .accreditation-row {
            display: flex;
            flex-wrap: wrap;
            /* Allows items to wrap onto the next line if needed */
            justify-content: center;
            /* Centers the items horizontally */
            gap: 20px;
            /* Adds space between the columns */
        }

        .accreditation-content,
        .protocols-content {
            flex: 0 0 45%;
            /* Adjusted width for better spacing */
            max-width: 45%;
            /* Ensure the columns do not exceed this width */
            padding: 15px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Add margin-bottom for responsive spacing */
        .accreditation-content,
        .protocols-content {
            margin-bottom: 20px;
            /* Ensures space below each column */
        }

        .accreditation-heading,
        .protocols-heading {
            font-size: 24px;
            margin-bottom: 15px;
            color: #007bff;
        }

        .accreditation-content p,
        .protocols-content ul {
            font-size: 16px;
            color: #555;
        }

        .protocols-content ul {
            list-style: none;
            padding-left: 0;
        }

        .protocols-content ul li {
            margin-bottom: 10px;
        }

        .protocols-content ul li strong {
            color: #007bff;
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
                        <a href="new_index.php" class="nav-item nav-link">Home</a>
                        <a href="new_services.php" class="nav-item nav-link active">Services and Requirements</a>
                        <a href="new_reviews.php" class="nav-item nav-link">Reviews</a>
                        <a href="#footer" class="nav-item nav-link">Contacts</a>
                    </div>
                    <div class="ms-auto d-none d-lg-flex">
                        <button type="button" class="btn btn-primary me-2" data-toggle="modal" data-target="#myModal">
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
    <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5 mt-4">
            <h1 class="display-2 text-white mb-3 animated slideInDown">Services & Requirements</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#services">Services</a></li>
                    <li class="breadcrumb-item"><a href="#requirements">Requirements</a></li>
                    <li class="breadcrumb-item"><a href="#accreditation-protocols">Business Accreditation and Operation
                            Protocols</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Service Start -->
    <div class="container-fluid container-service py-5" id="services">
        <div class="container py-5">
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="display-6 mb-3">Reliable & High-Quality Diagnostic Service</h1>
                <p class="mb-5">At Brain Master Diagnostic Center, we are committed to providing accurate and timely
                    diagnostic services. Our experienced team and state-of-the-art technology ensure that you receive
                    the best care and results, helping you make informed health decisions with confidence.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item">
                        <div class="icon-box-primary mb-4">
                            <i class="bi bi-capsule text-dark"></i>
                        </div>
                        <h5 class="mb-3">Toxicology Tests</h4>
                            <p class="mb-4">We provide comprehensive toxicology tests focusing on drug testing, ensuring
                                accurate and timely results for various needs including employment and legal
                                requirements.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item">
                        <div class="icon-box-primary mb-4">
                            <i class="bi bi-prescription2 text-dark"></i>
                        </div>
                        <h5 class="mb-3">Neurological Tests & Examinations</h4>
                            <p class="mb-4">Our center offers thorough neurological examinations to assess and diagnose
                                neurological conditions, using state-of-the-art technology and expert analysis.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item">
                        <div class="icon-box-primary mb-4">
                            <i class="bi bi-clipboard2-pulse text-dark"></i>
                        </div>
                        <h5 class="mb-3">Psychological Tests & Assessments</h4>
                            <p class="mb-4">We conduct detailed psychological assessments through our partner doctors to
                                evaluate mental health and provide accurate diagnoses and recommendations.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item">
                        <div class="icon-box-primary mb-4">
                            <i class="bi bi-file-medical text-dark"></i>
                        </div>
                        <h5 class="mb-3">Post-Examination Test & Interviews</h4>
                            <p class="mb-4">Our post-examination interviews offer valuable insights and follow-up
                                discussions to ensure comprehensive understanding and care after diagnostic tests</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->

    <!-- Requirements Section Start -->
    <div class="container-fluid py-5" id="requirements">
        <div class="container py-5">
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="display-6 mb-3">Requirements for Availing Our Services</h1>
                <p class="mb-5">Ensure that you meet the following requirements before availing our diagnostic services
                    to guarantee a smooth and hassle-free experience.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="requirement-item p-4 bg-light rounded">
                        <h5 class="mb-3">Valid ID</h5>
                        <p>A government-issued ID is required for identity verification when availing any of our
                            services.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="requirement-item p-4 bg-light rounded">
                        <h5 class="mb-3">Medical Referral</h5>
                        <p>A referral from a licensed doctor is required for specialized diagnostic tests such as
                            neurological exams and psychological assessments.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="requirement-item p-4 bg-light rounded">
                        <h5 class="mb-3">Appointment Confirmation</h5>
                        <p>Please bring a printed or digital confirmation of your appointment to ensure you are
                            accommodated on the scheduled date and time.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="requirement-item p-4 bg-light rounded">
                        <h5 class="mb-3">Payment Proof</h5>
                        <p>Ensure that you have a receipt or proof of payment for any prior transactions made online or
                            via our partner banks.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.9s">
                    <div class="requirement-item p-4 bg-light rounded">
                        <h5 class="mb-3">Health Declaration Form</h5>
                        <p>Fill out and submit our health declaration form before availing of any tests, particularly
                            during pandemic periods for safety measures.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Requirements Section End -->



    <section id="accreditation-protocols" class="section accreditation-section">
        <div class="container accreditation-container">
            <h2 class="section-title accreditation-title">Business Accreditation and Operation Protocols</h2>
            <div class="row accreditation-row">
                <div class="col-md-6 accreditation-content">
                    <h3 class="accreditation-heading">Business Accreditation</h3>
                    <p>
                        At Brain Master Diagnostic Center, we pride ourselves on maintaining the highest standards of
                        quality and reliability.
                        We are accredited by esteemed healthcare organizations, which ensures our diagnostic services
                        meet industry-leading benchmarks.
                        Our certifications validate our commitment to excellence, accuracy, and compliance with all
                        regulatory bodies.
                        This level of accreditation guarantees that you receive trusted and dependable healthcare
                        services.
                    </p>
                </div>
                <div class="col-md-6 protocols-content">
                    <h3 class="protocols-heading">Business Operation Protocols</h3>
                    <ul>
                        <li><strong>Comprehensive Staff Training:</strong> Our team undergoes continuous training to
                            stay updated with the latest medical advancements and diagnostic technologies.</li>
                        <li><strong>Regular Equipment Maintenance:</strong> We maintain and update all diagnostic
                            equipment to ensure it performs at optimal efficiency, minimizing the risk of errors.</li>
                        <li><strong>Compliance with Best Practices:</strong> Our protocols align with current healthcare
                            best practices, ensuring we meet the highest standards of diagnostic accuracy and patient
                            care.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>





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