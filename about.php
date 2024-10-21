<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brain Master</title>
    <link href="css/about.css" rel="stylesheet">

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
                    <a href="index.php">Home</a>
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

    <section class="about">
        <div class="container">
            <div class="content">
                <h2>About Us</h2>
                <p>Welcome to Brain Master Diagnostic Center, a trusted provider of specialized diagnostic services for
                    over
                    a decade. We pride ourselves on delivering high-quality, reliable diagnostic tests, including drug
                    testing, neurological examinations, and psychological assessments. Our center is equipped with
                    advanced
                    technology and staffed by a team of skilled professionals dedicated to providing accurate and
                    comprehensive care.</p>

                <h3>Our Business Model</h3>

                <div class="business-model">
                
                    <div class="model-item">
                        <div class="model-text">
                            <h4>Customer Segments</h4>
                            <p>Our services cater to individual patients needing specialized diagnostics, healthcare
                                providers referring patients, corporate clients requiring employee health assessments,
                                and
                                government agencies seeking certified diagnostic services.</p>
                        </div>
                        <div class="model-image">
                            <img src="assets/download1.jpg" alt="Customer Segments">
                        </div>
                    </div>

                    <div class="model-item">
                        <div class="model-text">
                            <h4>Revenue Streams</h4>
                            <p>We generate revenue through diagnostic services, corporate contracts, and government
                                projects, providing valuable services that meet various needs.</p>
                        </div>
                        <div class="model-image">
                            <img src="assets/download1.jpg" alt="Revenue Streams">
                        </div>
                    </div>

                    <div class="model-item">
                        <div class="model-text">
                            <h4>Key Resources</h4>
                            <p>Our key resources include experienced staff, advanced diagnostic equipment, and necessary
                                certifications from regulatory bodies, all ensuring the highest standards of service.
                            </p>
                        </div>
                        <div class="model-image">
                            <img src="assets/download1.jpg" alt="Key Resources">
                        </div>
                    </div>

                    <div class="model-item">
                        <div class="model-text">
                            <h4>Key Activities</h4>
                            <p>We focus on conducting diagnostic tests, maintaining compliance, and coordinating patient
                                care, ensuring smooth and effective service delivery.</p>
                        </div>
                        <div class="model-image">
                            <img src="assets/download1.jpg" alt="Key Activities">
                        </div>
                    </div>

                    <div class="model-item">
                        <div class="model-text">
                            <h4>Key Partnerships</h4>
                            <p>We collaborate with partner doctors, healthcare institutions, and government agencies to
                                enhance our service offerings and maintain regulatory standards.</p>
                        </div>
                        <div class="model-image">
                            <img src="assets/download1.jpg" alt="Key Partnerships">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




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

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>

    <script>
        let menu = document.querySelector('#menu-btn');
        let navbar = document.querySelector('.header .nav');
        let header = document.querySelector('.header');

        menu.onclick = () => {
            menu.classList.toggle('fa-times');
            navbar.classList.toggle('active');
        }

        window.onscroll = () => {
            menu.classList.toggle('fa-times');
            navbar.classList.toggle('active');

            if (window.scrollY > 0) {
                header.classList.add('active');
            } else {
                header.classList.remove('active');
            }
        }
    </script>

</body>

</html>