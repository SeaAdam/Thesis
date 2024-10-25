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

        #reviewForm {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
                        <a href="new_services.php" class="nav-item nav-link">Services and Requirements</a>
                        <a href="new_reviews.php" class="nav-item nav-link active">Reviews</a>
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
            <h1 class="display-2 text-white mb-3 animated slideInDown">Reviews</h1>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Testimonial Start -->
    <div class="container-fluid testimonial py-5">
        <div class="container pt-5">
            <div class="row gy-5 gx-0">
                <div class="col-lg-6 pe-lg-5 wow fadeIn" data-wow-delay="0.3s">
                    <h1 class="display-6 text-white mb-4">What Clients Say About Our Diagnostic Services!</h1>
                    <p class="text-white mb-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur tellus
                        augue, iaculis id elit eget, ultrices pulvinar tortor.</p>
                </div>
                <div class="col-lg-6 mb-n5 wow fadeIn" data-wow-delay="0.5s">
                    <div class="bg-white p-5">
                        <div class="owl-carousel testimonial-carousel wow fadeIn" data-wow-delay="0.1s">
                            <div class="testimonial-item">
                                <div class="icon-box-primary mb-4">
                                    <i class="bi bi-chat-left-quote text-dark"></i>
                                </div>
                                <p class="fs-5 mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur
                                    tellus augue, iaculis id elit eget, ultrices pulvinar tortor. Quisque vel lorem
                                    porttitor, malesuada arcu quis, fringilla risus. Pellentesque eu consequat augue.
                                </p>
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0" src="assets/download2.png" alt="">
                                    <div class="ps-3">
                                        <h5 class="mb-1">Client Name</h5>
                                        <span class="text-primary">Profession</span>
                                    </div>
                                </div>
                            </div>
                            <div class="testimonial-item">
                                <div class="icon-box-primary mb-4">
                                    <i class="bi bi-chat-left-quote text-dark"></i>
                                </div>
                                <p class="fs-5 mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur
                                    tellus augue, iaculis id elit eget, ultrices pulvinar tortor. Quisque vel lorem
                                    porttitor, malesuada arcu quis, fringilla risus. Pellentesque eu consequat augue.
                                </p>
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0" src="assets/download1.jpg" alt="">
                                    <div class="ps-3">
                                        <h5 class="mb-1">Client Name</h5>
                                        <span class="text-primary">Profession</span>
                                    </div>
                                </div>
                            </div>
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
        <form id="reviewForm" action="submit_review.php" method="POST">
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