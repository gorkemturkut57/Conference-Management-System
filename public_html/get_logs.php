<?php
session_start();

// Only organizers can access this page
if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] !== 'organizer' && $_SESSION['user_role'] !== 'organizator')) {
    header('HTTP/1.0 403 Forbidden');
    echo "Access denied. Only organizers can access this page.";
    exit();
}

$log_file = 'logs.txt';
if (file_exists($log_file)) {
    echo htmlspecialchars(file_get_contents($log_file));
} else {
    echo 'Log file not found.';
}
