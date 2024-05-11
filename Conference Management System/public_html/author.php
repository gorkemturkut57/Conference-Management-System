<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with LeadMark landing page.">
    <meta name="author" content="Devcrud">
    <title>Conference Management System</title>
    <!-- font icons -->
    <link rel="stylesheet" href="assets/vendors/themify-icons/css/themify-icons.css">
    <!-- Bootstrap + LeadMark main styles -->
	<link rel="stylesheet" href="assets/css/leadmark.css">
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">






<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["presentationFile"])) {
    $target_dir = "uploads/";

    // Conference Name'i header.txt dosyasına yaz
    if (isset($_POST['name'])) {
        $conference_name = $_POST['name'];
        if (!empty($conference_name)) {
            $target_file = $target_dir . "header.txt"; // Dosya adını header.txt olarak ayarlayın
            file_put_contents($target_file, $conference_name);
        } 
    }

    $target_file = $target_dir . "about_conference.txt"; // Dosya adını about_conference.txt olarak ayarlayın
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($_FILES["presentationFile"]["name"], PATHINFO_EXTENSION));

    // Sadece belirli dosya türlerine izin ver
    $allowedExtensions = array("pdf", "docx", "pptx", "ppt", "txt"); // kabul edilen dosya uzantıları
    if (empty($conference_name)) {
        echo "Conference Name cannot be empty.";
    }
     elseif(empty($_FILES['presentationFile']['tmp_name'])) { // Dosya seçilmediyse
        echo "Please select a file.";
        $uploadOk = 0;
    }
    elseif (!in_array($fileType, $allowedExtensions)) {
        echo "Only PDF, DOCX, PPTX, PPT or TXT files are allowed.";
        $uploadOk = 0;
    }
    

    // Dosyayı belirli bir konuma taşı
    elseif ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["presentationFile"]["tmp_name"], $target_file)) {
            echo "File uploaded successfully: " . htmlspecialchars(basename($_FILES["presentationFile"]["name"]));
        } else {
            echo "Error uploading file.";
        }
    }
}
?>











    <!-- page Navigation -->
    <nav class="navbar custom-navbar navbar-expand-md navbar-light fixed-top" data-spy="affix" data-offset-top="10">
        <div class="container">
            <a class="navbar-brand" href="author.php">
                <img src="assets/imgs/konferans.png" alt="">
            </a>
            <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">                     
                    <li class="nav-item">
                        <a class="nav-link" href="#service">Our Service</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#live-sessions">Live Sessions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#portfolio">Latest Articles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testmonial">Testmonials</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Upload Presentation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#myreviews">My Reviews</a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php" class="ml-4 nav-link btn btn-primary btn-sm rounded">Exit</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Of Second Navigation -->

    <!-- Page Header -->
    <header class="header">
        <div class="overlay">
            <h1 class="subtitle">Conference Management System</h1>
            <h1 class="title">We Are Creative</h1>  
        </div>  
        <div class="shape">
            <svg viewBox="0 0 1500 200">
                <path d="m 0,240 h 1500.4828 v -71.92164 c 0,0 -286.2763,-81.79324 -743.19024,-81.79324 C 300.37862,86.28512 0,168.07836 0,168.07836 Z"/>
            </svg>
        </div>  
        <div class="mouse-icon"><div class="wheel"></div></div>
    </header>
    <!-- End Of Page Header -->

    <!-- Our Services Section -->
    <section  id="service" class="section pt-0">
        <div class="container">
            <h6 class="section-title text-center">Our Services</h6>
            <h6 class="section-subtitle text-center mb-5 pb-3">All In One Platform</h6>

            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4 mb-md-0">
                        <div class="card-body">
                            <small class="text-primary font-weight-bold">01</small>
                            <h5 class="card-title mt-3"> Conference Planning and Management <h5>
                            <p class="mb-0">We specialize in planning and managing academic, professional, and corporate conferences, guiding you through every step with ease.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 mb-md-0">
                        <div class="card-body">
                            <small class="text-primary font-weight-bold">02</small>
                            <h5 class="card-title mt-3">User-Friendly Conference Setup<h5>
                            <p class="mb-0">We provide a user-friendly platform for customizing and organizing your conference details. Easily set up the title, description, venue, dates, and schedules.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" style="margin-bottom: 10px;">
                    <div class="card mb-4 mb-md-0">
                        <div class="card-body">
                            <small class="text-primary font-weight-bold">03</small>
                            <h5 class="card-title mt-3">Efficient Call for Papers Management<h5>
                            <p class="mb-0">Speed up the process by allowing authors to submit papers or abstracts through our online portal. Easily collect titles, abstracts, keywords, and file uploads.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 mb-md-0">
                        <div class="card-body">
                            <small class="text-primary font-weight-bold">04</small>
                            <h5 class="card-title mt-3">Streamlined Review Process<h5>
                            <p class="mb-0">We implement a double-blind review system to ensure unbiased feedback. By automatically or manually assigning papers to reviewers based on their expertise, we simplify the evaluation process.</p>
                        </div>
                    </div>
                </div>       
                <div class="col-md-4">
                    <div class="card mb-4 mb-md-0">
                        <div class="card-body">
                            <small class="text-primary font-weight-bold">05</small>
                            <h5 class="card-title mt-3">Comprehensive Program Scheduling: <h5>
                            <p class="mb-0">Our platform enables you to create detailed program schedules tailored to your conference. Organize sessions by themes, topics, or presentation types like keynotes, workshops, or posters.</p>
                        </div>
                    </div>
                </div>    
                <div class="col-md-4">
                    <div class="card mb-4 mb-md-0">
                        <div class="card-body">
                            <small class="text-primary font-weight-bold">06</small>
                            <h5 class="card-title mt-3">Seamless On-site Management<h5>
                            <p class="mb-0">We streamline the attendee experience from start to finish. Participants can easily register for the conference, select their preferred sessions, and securely complete payments, all in one place.</p>
                        </div>
                    </div>
                </div>         

            </div>
        </div>
    </section>
    <!-- End Of Our Services Section -->

    <!-- About Us Section -->
    <section class="section" id="about">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-6 pr-md-5 mb-4 mb-md-0">
                    <h6 class="section-title mb-0">About Us</h6>
                    <h6 class="section-subtitle mb-4">We provide you a User-Friendly management system</h6>
                    <p >Welcome to Conference Management System, where we specialize in revolutionizing conference management. With years of experience in the field, we are passionate about simplifying the complexities of organizing academic, professional, and corporate events.</p>
                    <img src="assets/imgs/about.jpg" alt="" class="w-100 mt-3 shadow-sm">
                </div>
                <div class="col-md-6 pl-md-5">
                    <div class="row">
                        <div class="col-6">
                            <img src="assets/imgs/about-1.jpg" alt="" class="w-100 shadow-sm">
                        </div>
                        <div class="col-6">
                            <img src="assets/imgs/about-2.jpg" alt="" class="w-100 shadow-sm">
                        </div>
                        <div class="col-12 mt-4">
                            <p>Our mission is to provide innovative solutions that empower organizers, reviewers, presenters, and attendees alike. From seamless registration processes to comprehensive program scheduling, we strive to make every aspect of conference management efficient and user-friendly.</p>
                            <p><b>Join us in redefining the conference experience. Let's work together to create memorable and impactful events that inspire, educate, and connect.</b><br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>              
        </div>
    </section>
    <!-- End OF About Section -->

    <!-- Live Sessions Section-->
<!-- Live Sessions Section -->
<section class="section" id="live-sessions">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h6 class="section-title text-center">Live Sessions</h6>
                <h6 class="section-subtitle text-center mb-5">Join our live sessions to learn and engage!</h6>
            </div>
        </div>
        <div class="row">
            <!-- Live Session 1 -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="assets/imgs/1.jpg" alt="" class="card-img-top">
                    <div class="card-body">
                        <span class="badge badge-warning">Live</span> 
                        <h5 class="card-title">Introduction to Conference Planning</h5>
                        <p class="card-text">Join us for an in-depth discussion on effective conference planning strategies.</p>
                        <a href="presentation.php" class="btn btn-primary">Join Now</a>
                    </div>
                </div>
            </div>
            <!-- Live Session 2 -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="assets/imgs/2.jpg" alt="" class="card-img-top">
                    <div class="card-body">
                        <span class="badge badge-warning">Live</span> 
                        <h5 class="card-title">Keynote Presentation on Innovation</h5>
                        <p class="card-text">Listen to renowned speakers share insights on driving innovation in conferences.</p>
                        <a href="presentation.php" class="btn btn-primary">Join Now</a>
                    </div>
                </div>
            </div>
            <!-- Live Session 3 -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="assets/imgs/3.jpg" alt="" class="card-img-top">
                    <div class="card-body">
                        <span class="badge badge-warning"> Live</span> 
                        <h5 class="card-title">Workshop: Effective Paper Submission</h5>
                        <p class="card-text">Participate in a workshop to learn best practices for submitting papers.</p>
                        <a href="presentation.php" class="btn btn-primary">Join Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End of Live Sessions Section -->

    <!-- End of Live Sessions Section-->

    <!-- Latest Articles Section -->
    <section class="section" id="portfolio">
        <div class="container">
            <h6 class="section-title mb-0 text-center">Latest Articles</h6>
            <h6 class="section-subtitle mb-5 text-center">Latest articles published by our users</h6>

            <div class="row">
                <div class="col-md-4">
                    <div class="card border-0 mb-4">
                        <img src="assets/imgs/blog-1.jpg" alt="" class="card-img-top w-100">
                        <div class="card-body">                         
                            <h6 class="card-title">How to Use Colors Effectively ?</h6>
                            <p>Colors are essential for good art! So how do you use these colors correctly?</p>
                            <a href="javascript:void(0)" class="small text-muted">Go To The Article</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 mb-4">
                        <img src="assets/imgs/blog-2.jpg" alt="" class="card-img-top w-100">
                        <div class="card-body">                         
                            <h6 class="card-title"> The Impact of Art On Our Lives</h5>
                            <p>The impact of art on our lives is greater than you think.</p>
                            <a href="javascript:void(0)" class="small text-muted">Go To The Article</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 mb-4">
                        <img src="assets/imgs/blog-3.jpg" alt="" class="card-img-top w-100">
                        <div class="card-body">                         
                            <h6 class="card-title">The Future of Artificial Intelligence</h6>
                            <p>Is artificial intelligence a fad or the most important technology of the future?</p>
                            <a href="javascript:void(0)" class="small text-muted">Go To The Article</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End of Latest Articles Section -->

    <!-- Testmonial Section -->
    <section class="section" id="testmonial">
        <div class="container">
            <h6 class="section-title text-center mb-0">Testmonials</h6>
            <h6 class="section-subtitle mb-5 text-center">What Our Clients Says</h6>
            <div class="row">
                <div class="col-md-4 my-3 my-md-0">
                    <div class="card">
                        <div class="card-body">
                            <div class="media align-items-center mb-3">
                                <img class="mr-3" src="assets/imgs/avatar.jpg" alt="">
                                <div class="media-body">
                                    <h6 class="mt-1 mb-0">John Doe</h6>
                                    <small class="text-muted mb-0">Business Analyst</small>     
                                </div>
                            </div>
                            <p class="mb-0">They provide confidence and ease at every step. Great convenience in organizing events and managing participants.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 my-3 my-md-0">
                    <div class="card">
                        <div class="card-body">
                            <div class="media align-items-center mb-3">
                                <img class="mr-3" src="assets/imgs/avatar-1.jpg" alt="">
                                <div class="media-body">
                                    <h6 class="mt-1 mb-0">Maria Garcia</h6>
                                    <small class="text-muted mb-0">Author</small>      
                                </div>
                            </div>
                            <p class="mb-0">Submitting papers and following the program is enjoyable. A current and user-friendly platform, thanks!</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 my-3 my-md-0">
                    <div class="card">
                        <div class="card-body">
                            <div class="media align-items-center mb-3">
                                <img class="mr-3" src="assets/imgs/avatar-2.jpg" alt="">
                                <div class="media-body">
                                    <h6 class="mt-1 mb-0">Mason Miller</h6>
                                    <small class="text-muted mb-0">Residential Appraiser</small>        
                                </div>
                            </div>
                            <p class="mb-0">Quick and simple registration, ease in attending desired sessions. Thank you for the convenience!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End of Testmonial Section -->

<!-- Drop Us An Presentation Section -->
<section id="contact" class="section has-img-bg pb-0">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-5 my-3">
                <h6 class="mb-0">Phone</h6>
                <p class="mb-4">+ 123-456-7890</p>

                <h6 class="mb-0">Address</h6>
                <p class="mb-4">12345 Fake ST NoWhere TR Country</p>

                <h6 class="mb-0">Email</h6>
                <p class="mb-0">info@website.com</p>
                <p></p>
            </div>
            <div class="col-md-7">
                <form method="post" enctype="multipart/form-data">
                    <h4 class="mb-4">Drop Us An Presentation</h4>
                    <div class="form-row">
                        <div class="form-group col-sm-4">
                            <input type="text" class="form-control text-white rounded-0 bg-transparent" name="name" placeholder="Conference Name">
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="form-group col-lg-3">
                            <input id="presentationFile" type="file" name="presentationFile" style="border: none;">
                            <button type="submit" name="submit" class="btn btn-primary rounded w-md mt-3">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Page Footer -->
        <footer class="mt-5 py-4 border-top border-secondary">
            <p class="mb-0 small">&copy; <script>document.write(new Date().getFullYear())</script>, Conference Management System Created By <a href="https://ege.edu.tr/tr-0/anasayfa.html" target="_blank">Ege University.</a>  All rights reserved </p>
        </footer>
        <!-- End of Page Footer -->
    </div>
</section>
<!-- End Of Drop Us An Presentation Section -->

<!-- My Reviews Section -->
<section class="section" id="myreviews">
        <div class="container">
            <h6 class="section-title text-center mb-0">My Reviews</h6>
            <h6 class="section-subtitle mb-5 text-center">See what authors write about you</h6>
            <div class="row">
                <div class="col-md-4 my-3 my-md-0">
                    <div class="card">
                    <a href="review.php">
                        <div class="card-body">
                            <div class="media align-items-center mb-3">
                                <img class="mr-3" src="assets/imgs/avatar.jpg" alt="">
                                <div class="media-body">
                                    <h6 style="color: black;" class="mt-1 mb-0">John Doe</h6>
                                    <small class="text-muted mb-0">Author</small>     
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 my-3 my-md-0">
                    <div class="card">
                    <a href="review.php">
                        <div class="card-body">
                            <div class="media align-items-center mb-3">
                                <img class="mr-3" src="assets/imgs/avatar-1.jpg" alt="">
                                <div class="media-body">
                                    <h6 style="color: black;" class="mt-1 mb-0">Maria Garcia</h6>
                                    <small class="text-muted mb-0">Author</small>      
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 my-3 my-md-0">
                    <div class="card">
                        <a href="review.php">
                        <div class="card-body">
                            <div class="media align-items-center mb-3">
                                <img class="mr-3" src="assets/imgs/avatar-2.jpg" alt="">
                                <div class="media-body">
                                    <h6 style="color: black;" class="mt-1 mb-0">Mason Miller</h6>
                                    <small class="text-muted mb-0">Author</small>        
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End of My Reviews Section -->


	<!-- core  -->
    <script src="assets/vendors/jquery/jquery-3.4.1.js"></script>
    <script src="assets/vendors/bootstrap/bootstrap.bundle.js"></script>

    <!-- bootstrap 3 affix -->
	<script src="assets/vendors/bootstrap/bootstrap.affix.js"></script>

    <!-- Isotope -->
    <script src="assets/vendors/isotope/isotope.pkgd.js"></script>

    <!-- LeadMark js -->
    <script src="assets/js/leadmark.js"></script>

</body>
</html>
