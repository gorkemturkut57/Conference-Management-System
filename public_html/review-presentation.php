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
    session_start();
    $error = ""; // Error message will be empty at the start

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get mark and review fields
        $mark = isset($_POST['subject']) ? $_POST['subject'] : '';
        $review = isset($_POST['message']) ? $_POST['message'] : '';

        // Check if mark and review fields are filled
        if (!empty($mark) && !empty($review)) {

            if ($mark >= 0 && $mark <= 100) {
                // Specify the file path
                $file_path = "uploads/review.txt";

                // Clear previous content from the file
                file_put_contents($file_path, '');

                // Prepare the content to write to the file
                $content_to_write = "Mark: " . $mark . "\n" . "Review: " . $review . "\n\n";

                // Append the content to the file
                if (file_put_contents($file_path, $content_to_write, FILE_APPEND | LOCK_EX) !== false) {
                    // If writing to the file is successful, set the success message
                    $error = "Review successfully submitted!";
                } else {
                    // If writing to the file fails, set the error message
                    $error = "Error occurred while submitting the review.";
                }
            } else {
                $error = "Mark should be between 0 and 100!";
            }
        } else {
            // Set the error message if required fields are not filled
            $error = "Please fill both mark and review fields!";
        }
    }
    ?>

    <!-- You can use the $error variable in the PHP code to display the error message -->
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php
    ?>

    <!-- page Navigation -->
    <nav class="navbar custom-navbar navbar-expand-md navbar-light fixed-top" data-spy="affix" data-offset-top="10">
        <div class="container">
            <a class="navbar-brand" href="reviewer.php">
                <img src="assets/imgs/konferans.png" alt="">
            </a>
            <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" style="color: black;" href="#head">Conference</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: black;" href="#about">About The Conference</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: black;" href="#contact">Review Presentation</a>
                    </li>
                    <li class="nav-item">
                        <?php
                        $main_menu_link = 'index.php';
                        if (isset($_SESSION['user_role'])) {
                            switch ($_SESSION['user_role']) {
                                case 'author':
                                    $main_menu_link = 'author.php';
                                    break;
                                case 'reviewer':
                                    $main_menu_link = 'reviewer.php';
                                    break;
                                case 'organizer':
                                    $main_menu_link = 'organizator.php';
                                    break;
                                case 'participant':
                                    $main_menu_link = 'user.php';
                                    break;
                            }
                        }
                        ?>
                        <a href="<?php echo $main_menu_link; ?>" class="ml-4 nav-link btn btn-primary btn-sm rounded">
                            <span style="color: black;">Main Menu</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Of Second Navigation -->

    <!-- Page Header -->
    <header id="head" style="margin-left: 13%; margin-top: 100px;">
        <iframe width="1120" height="630" src="https://www.youtube.com/embed/XgKo9VeWnKo?si=XTStSG4G84YPbvVG" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </header>
    <!-- End Of Page Header -->



    <!-- About the conference -->
    <section class="section" id="about">
        <div class="container">
            <div class="row justify-content-between">
                <div>
                    <?php
                    // File path
                    $file_path = "uploads/header.txt";

                    // Check if the file exists
                    if (file_exists($file_path)) {
                        // Read the file and display the content
                        $conference_name = file_get_contents($file_path);
                        echo "<h4 class='mb-4'>$conference_name</h4>";
                    } else {
                        echo "<h4 class='mb-4'></h4>";
                    }
                    ?>
                    <?php
                    // File path
                    $file_path = "uploads/about_conference.txt";

                    // Check if the file exists
                    if (file_exists($file_path)) {
                        // Read the file and display the content
                        $content = file_get_contents($file_path);
                        echo "<p>" . nl2br($content) . "</p>"; // nl2br() fonksiyonu yeni satır karakterlerini <br> etiketlerine dönüştürür
                    } else {
                        echo "<p>No information about the conference has been added yet.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <!-- End OF About Conference -->




    <!-- Drop Us An Presentation Section -->
    <section id="contact" class="section has-img-bg pb-0">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5 my-3">
                    <h4 class="mb-0">Author Informations</h4>

                    <h6 class="mb-0">Name</h6>
                    <p class="mb-4">Gorkem Turkut</p>

                    <h6 class="mb-0">Phone</h6>
                    <p class="mb-4">+ 123-456-7890</p>

                    <h6 class="mb-0">Email</h6>
                    <p class="mb-0">info@website.com</p>
                    <p></p>
                </div>
                <div class="col-md-7">
                    <form method="post">
                        <h4 class="mb-4">Review</h4>
                        <div class="form-row">
                            <div class="form-group col-sm-4">
                                <input type="number" class="form-control text-white rounded-0 bg-transparent" name="subject" placeholder="Mark 0-100">
                            </div>
                            <div class="form-group col-12">
                                <textarea name="message" id="" cols="30" rows="4" class="form-control text-white rounded-0 bg-transparent" placeholder="Review"></textarea>
                            </div>
                            <!-- Submit button -->
                            <div class="form-group col-12 mb-0">
                                <button type="submit" class="btn btn-primary rounded w-md mt-3">Send</button>
                            </div>
                    </form>
                    <!-- Page Footer -->
                    <footer class="mt-5 py-4 border-top border-secondary">
                        <p class="mb-0 small">&copy; <script>
                                document.write(new Date().getFullYear())
                            </script>, Conference Management System Created By <a href="https://ege.edu.tr/tr-0/anasayfa.html" target="_blank">Ege University.</a> All rights reserved </p>
                    </footer>
                    <!-- End of Page Footer -->
                </div>
    </section>
    <!-- End Of Drop Us An Presentation Section -->

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