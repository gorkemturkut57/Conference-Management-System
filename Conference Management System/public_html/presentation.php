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
$error = ""; // Başlangıçta hata mesajı boş olacak

// Formun gönderilip gönderilmediğini kontrol et
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mark ve review alanlarını al
    $mark = isset($_POST['subject']) ? $_POST['subject'] : '';
    $review = isset($_POST['message']) ? $_POST['message'] : '';

    // Mark ve review alanlarının dolu olup olmadığını kontrol et
    if (!empty($mark) && !empty($review)) {

        if ($mark >= 0 && $mark <= 100){
                    // Dosya yolunu belirt
        $file_path = "uploads/review.txt";

        // Dosyadan önceki içeriği sil
        file_put_contents($file_path, '');

        // Dosyaya yazılacak içeriği hazırla
        $content_to_write = "Mark: " . $mark . "\n" . "Review: " . $review . "\n\n";

        // Dosyaya içeriği ekle, append modunda aç
        if (file_put_contents($file_path, $content_to_write, FILE_APPEND | LOCK_EX) !== false) {
            // Dosyaya yazma başarılıysa başarı mesajını ayarla
            $error = "Review successfully submitted!";
        } else {
            // Dosyaya yazma başarısızsa hata mesajını ayarla
            $error = "Error occurred while submitting the review.";
        }
        }
        else{
            $error = "Mark should be between 0 and 100!";
        }

    } else {
        // Gerekli alanlar doldurulmamışsa hata mesajını ayarla
        $error = "Please fill both mark and review fields!";
    }
}
?>

<!-- Hata mesajını göstermek için PHP kodu içinde yer alan $error değişkenini kullanabilirsiniz -->
<?php if (!empty($error)): ?>
    <p class="error"><?php echo $error; ?></p>
<?php endif; ?>



    <!-- page Navigation -->
    <nav class="navbar custom-navbar navbar-expand-md navbar-light fixed-top" data-spy="affix" data-offset-top="10">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="assets/imgs/konferans.png" alt="">
            </a>
            <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">                     
                    <li class="nav-item">
                        <a class="nav-link" style="color: black;"href="#head">Conference</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: black;"href="#about">About The Conference</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: black;" href="#contact">Review Presentation</a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php" class="ml-4 nav-link btn btn-primary btn-sm rounded"><x style="color: black;">Exit</x></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Of Second Navigation -->

    <!-- Page Header -->
    <header id="head" style="margin-left: 13%; margin-top: 100px;">
        <iframe width="1120" height="630" src="https://www.youtube.com/embed/XgKo9VeWnKo?si=XTStSG4G84YPbvVG" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>    </header>
    <!-- End Of Page Header -->

    

    <!-- About the conference -->
<section class="section" id="about">
    <div class="container">
        <div class="row justify-content-between">
            <div>
                <?php
                // Dosya yolu
                $file_path = "uploads/header.txt";

                // Dosyanın var olup olmadığını kontrol et
                if (file_exists($file_path)) {
                    // Dosyayı oku ve içeriğini ekrana yazdır
                    $conference_name = file_get_contents($file_path);
                    echo "<h4 class='mb-4'>$conference_name</h4>";
                } else {
                    echo "<h4 class='mb-4'></h4>";
                }
                ?>
                <?php
                // Dosya yolu
                $file_path = "uploads/about_conference.txt";

                // Dosyanın var olup olmadığını kontrol et
                if (file_exists($file_path)) {
                    // Dosyayı oku ve içeriğini ekrana yazdır
                    $content = file_get_contents($file_path);
                    echo "<p>" . nl2br($content) . "</p>"; // nl2br() fonksiyonu yeni satır karakterlerini <br> etiketlerine dönüştürür
                } else {
                    echo "<p>Henüz konferans hakkında bilgi eklenmemiş.</p>";
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
