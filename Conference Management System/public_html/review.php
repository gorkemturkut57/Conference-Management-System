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

    <!-- Page Navigation -->
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
                        <a class="nav-link" style="color: black;"href="#about">Review</a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php" class="ml-4 nav-link btn btn-primary btn-sm rounded"><x style="color: black;">Exit</x></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Of Page Navigation -->

    <!-- Page Header -->
    <header id="head" style="margin-left: 13%; margin-top: 100px;">
    <!-- End Of Page Header -->

    

    <!-- About the conference -->
<section class="section" id="about">
    <div class="container">
        <div class="row justify-content-between">
            <div>
                <?php
                // Dosya yolu
                $file_path = "uploads/review.txt";

                // Dosyanın var olup olmadığını kontrol et
                if (file_exists($file_path)) {
                    // Dosyayı satır satır oku ve içeriğini ekrana yazdır
                    $file_handle = fopen($file_path, "r");
                    while (!feof($file_handle)) {
                        $line = fgets($file_handle);
                        // "Mark" kelimesini içeren satırları bul ve yazdır
                        if (strpos($line, "Mark") !== false) {
                            echo "<h4 class='mb-4'>$line</h4>";
                        } else {
                            echo "<p>" . nl2br($line) . "</p>";
                        }
                    }
                    fclose($file_handle);
                } else {
                    echo "<p>Henüz review eklenmemiş</p>";
                }
                ?>
            </div>
        </div>              
    </div>
</section>
<!-- End OF About Conference -->

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
