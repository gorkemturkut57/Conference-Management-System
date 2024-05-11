<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form by Colorlib</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["signup"])) {
        // Kayıt işlemi
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["pass"];
        $confirmPassword = $_POST["re_pass"];
        $role = isset($_POST["role"]) ? $_POST["role"] : '';

        $agreeTerm = isset($_POST["agree-term"]);

        $errors = [];

        // Name validation
        if (empty($name)) {
            $errors[] = "Please enter your name.";
        }

        // Email validation
        if (empty($email)) {
            $errors[] = "Please enter your email.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Please enter a valid email address.";
        }

        // Password validation
        if (empty($password)) {
            $errors[] = "Please enter your password.";
        }

        // Confirm Password validation
        if ($password !== $confirmPassword) {
            $errors[] = "Passwords do not match.";
        }

        // Role validation
        if ($role=="Choose Member Type") {
            $errors[] = "Please select member type.";
        }

        // Agreement validation
        if (!$agreeTerm) {
            $errors[] = "Please agree to the Terms of Service.";
        }

        // If there are no errors, write data to users.json
        if (empty($errors)) {
            $userData = array(
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'role' => $role
            );

            // Read existing users from users.json
            $usersData = file_get_contents('users.json');
            $users = json_decode($usersData, true);

            // Add new user to the array
            $users[] = $userData;

            // Encode users array to json format
            $jsonData = json_encode($users, JSON_PRETTY_PRINT);

            // Write json data into users.json file
            if (file_put_contents('users.json', $jsonData)) {
                echo "<p>Form submitted successfully! Data written to users.json</p>";
            } else {
                echo "<p>Failed to write data to users.json</p>";
            }
        } else {
            // If there are errors, display them
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
        }
    } elseif (isset($_POST["signin"])) {
        // Giriş işlemi
        $email = $_POST["your_name"]; // Email ile giriş
        $password = $_POST["your_pass"];

        // JSON dosyasından kullanıcı verilerini oku
        $usersData = file_get_contents('users.json');
        $users = json_decode($usersData, true);

        // Kullanıcı verileri varsa
        if ($users) {
            // Kullanıcı email ve şifre kontrolü
            $loggedIn = false;
            foreach ($users as $user) {
                if ($user['email'] === $email && $user['password'] === $password) {
                    $loggedIn = true;
                    break;
                }
            }

            // Giriş başarılıysa
            if ($loggedIn) {
                echo "<p>Login successful!</p>";
                // Kullanıcıyı doğru sayfaya yönlendir
                switch ($user['role']) {
                    case 'author':
                        header('Location: ../author.php');
                        break;
                    case 'reviewer':
                        header('Location: ../reviewer.php');
                        break;
                    case 'organizator':
                        header('Location: ../organizator.php');
                        break;
                    case 'participant':
                        header('Location: ../user.php');
                        break;
                    default:
                        header('Location: ../user.php');
                        break;
                }
            } else {
                echo "<p>Incorrect email or password.</p>";
            }
        } else {
            echo "<p>No users found. Please sign up first.</p>";
        }
    }
}
?>







    <div class="main">
        <!-- Sign in  Form -->
        <section class="sign-in" id="signin">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/signin-image.jpg" alt="sing up image"></figure>
                        <a id="nav-link" href="#signup" class="signup-image-link">Create an account</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Sign In</h2>
                        <form method="POST" class="register-form" id="login-form">
                                <div class="form-group">
                                    <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                    <input type="text" name="your_name" id="your_name" placeholder="Your Email"/>
                                </div>
                                <div class="form-group">
                                    <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                    <input type="password" name="your_pass" id="your_pass" placeholder="Password"/>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                                    <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                                </div>
                                <div class="form-group form-button">
                                    <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                                </div>
                        </form>
                        <div class="social-login">
                            <span class="social-label">Or login with</span>
                            <ul class="socials">
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <br><br>
        <!-- Sign up form -->
        <section class="signup" id="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <form method="POST" class="register-form" id="register-form">
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" placeholder="Your Name"/>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email"/>
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="pass" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="re_pass" id="re_pass" placeholder="Repeat your password"/>
                            </div>
                            <div class="form-group">
                            </div>
                            <div class="form-group">
                                <select name="role" id="role">
                                    <option selected>Choose Member Type</option>
                                    <option value="author">Author</option>
                                    <option value="reviewer">Reviewer</option>
                                    <option value="organizator">Organizator</option>
                                    <option value="participant">Participant</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/signup-image.jpg" alt="sing up image"></figure>
                        <a id="nav-link" href="#signin" class="signin-image-link" style="color: black;" >I am already member</a>
                    </div>
                </div>
            </div>
        </section>



    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>

<script>
    // Smooth scrolling to a specific section
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            const target = document.querySelector(this.getAttribute('href'));

            window.scrollTo({
                top: target.offsetTop,
                behavior: 'smooth'
            });
        });
    });
</script>

