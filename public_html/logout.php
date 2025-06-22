<?php
session_start();

// Clear session
session_unset();
session_destroy();

// Ana sayfaya yönlendir
header('Location: index.php');
exit();
