<?php
// Maintenance mode configuration file

// Set Istanbul timezone
date_default_timezone_set('Europe/Istanbul');

// Function to check maintenance mode status
function isMaintenanceMode()
{
    $maintenanceFile = 'maintenance_status.txt';

    if (file_exists($maintenanceFile)) {
        $status = trim(file_get_contents($maintenanceFile));
        return $status === 'active';
    }

    return false;
}

// Function to enable maintenance mode
function enableMaintenanceMode($reason = '', $estimatedTime = '30-45 minutes')
{
    $maintenanceFile = 'maintenance_status.txt';
    $maintenanceData = [
        'status' => 'active',
        'start_time' => date('Y-m-d H:i:s'),
        'reason' => $reason,
        'estimated_time' => $estimatedTime
    ];

    file_put_contents($maintenanceFile, 'active');
    file_put_contents('maintenance_info.json', json_encode($maintenanceData, JSON_PRETTY_PRINT));

    // Write maintenance start to log file
    $logEntry = "[" . date('Y-m-d H:i:s') . "] MAINTENANCE: Maintenance mode enabled. Reason: $reason\n";
    file_put_contents('logs.txt', $logEntry, FILE_APPEND | LOCK_EX);
}

// Function to disable maintenance mode
function disableMaintenanceMode()
{
    $maintenanceFile = 'maintenance_status.txt';

    if (file_exists($maintenanceFile)) {
        unlink($maintenanceFile);
    }

    if (file_exists('maintenance_info.json')) {
        unlink('maintenance_info.json');
    }

    // Write maintenance end to log file
    $logEntry = "[" . date('Y-m-d H:i:s') . "] MAINTENANCE: Maintenance mode disabled.\n";
    file_put_contents('logs.txt', $logEntry, FILE_APPEND | LOCK_EX);
}

// Function to get maintenance information
function getMaintenanceInfo()
{
    $infoFile = 'maintenance_info.json';

    if (file_exists($infoFile)) {
        $data = file_get_contents($infoFile);
        return json_decode($data, true) ?: [];
    }

    return [
        'status' => 'inactive',
        'start_time' => '',
        'reason' => '',
        'estimated_time' => ''
    ];
}

// Maintenance mode check and redirect - Only organizer can access
function checkMaintenanceMode()
{
    if (isMaintenanceMode()) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] !== 'organizer' && $_SESSION['user_role'] !== 'organizator')) {
            header('Location: maintenance.php');
            exit();
        }
    }
}

// Admin IPs (can access even in maintenance mode)
$adminIPs = [
    '127.0.0.1', // Localhost
    '::1',       // IPv6 localhost
    // You can add admin IPs here
];

// Admin check
function isAdminIP()
{
    global $adminIPs;
    $clientIP = $_SERVER['REMOTE_ADDR'] ?? '';
    return in_array($clientIP, $adminIPs);
}

// Admin check in maintenance mode
function checkMaintenanceWithAdminAccess()
{
    // Maintenance mode check removed - everyone can access
    return;
}
