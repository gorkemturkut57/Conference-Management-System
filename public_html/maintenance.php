<?php
// Get maintenance information
require_once 'maintenance_config.php';
$maintenanceInfo = getMaintenanceInfo();
$isMaintenanceActive = isMaintenanceMode();

// Set Istanbul timezone
date_default_timezone_set('Europe/Istanbul');

// If maintenance mode is not active, redirect to organizer page
if (!$isMaintenanceActive) {
    header('Location: organizator.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Mode - Conference Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .maintenance-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 90%;
            backdrop-filter: blur(10px);
        }

        .maintenance-icon {
            font-size: 5rem;
            color: #ffc107;
            margin-bottom: 2rem;
            animation: wrench 2s ease-in-out infinite;
        }

        @keyframes wrench {

            0%,
            100% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(15deg);
            }

            75% {
                transform: rotate(-15deg);
            }
        }

        .progress-bar {
            height: 8px;
            border-radius: 4px;
            background: #e9ecef;
            margin: 2rem 0;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #28a745, #20c997);
            width: 65%;
            animation: progress 3s ease-in-out infinite;
        }

        @keyframes progress {

            0%,
            100% {
                width: 65%;
            }

            50% {
                width: 75%;
            }
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: #ffc107;
            color: #212529;
            border-radius: 25px;
            font-weight: bold;
            margin: 1rem 0;
        }

        .contact-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin-top: 2rem;
        }

        .social-links {
            margin-top: 2rem;
        }

        .social-links a {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            background: #007bff;
            color: white;
            border-radius: 50%;
            margin: 0 0.5rem;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .social-links a:hover {
            transform: scale(1.1);
        }

        .refresh-btn {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: bold;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .refresh-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
        }
    </style>
</head>

<body>
    <div class="maintenance-container">
        <div class="maintenance-icon">
            <i class="fas fa-tools"></i>
        </div>

        <h1 class="mb-4">Maintenance Mode</h1>

        <div class="status-badge">
            <i class="fas fa-clock"></i> System Under Maintenance
        </div>

        <p class="lead mb-4">
            The Conference Management System is currently under maintenance.<br>
            We are updating our system to serve you better.
        </p>

        <div class="progress-bar">
            <div class="progress-fill"></div>
        </div>

        <div class="row text-center">
            <div class="col-md-4">
                <h5><i class="fas fa-clock text-primary"></i></h5>
                <p class="text-muted">Estimated Time</p>
                <strong><?php echo $maintenanceInfo['estimated_time'] ?: '30-45 minutes'; ?></strong>
            </div>
            <div class="col-md-4">
                <h5><i class="fas fa-calendar text-success"></i></h5>
                <p class="text-muted">Start</p>
                <strong><?php echo $maintenanceInfo['start_time'] ? date('H:i', strtotime($maintenanceInfo['start_time'])) : date('H:i'); ?></strong>
            </div>
            <div class="col-md-4">
                <h5><i class="fas fa-percentage text-warning"></i></h5>
                <p class="text-muted">Completion</p>
                <strong>65%</strong>
            </div>
        </div>

        <?php if (!empty($maintenanceInfo['reason'])): ?>
            <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle"></i>
                <strong>Reason for Maintenance:</strong> <?php echo htmlspecialchars($maintenanceInfo['reason']); ?>
            </div>
        <?php endif; ?>

        <div class="contact-info">
            <h5><i class="fas fa-info-circle text-info"></i> Information</h5>
            <p>If you have any questions, please contact the system administrator.</p>
        </div>

        <div class="social-links">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>

        <button class="refresh-btn" onclick="window.location.reload();">
            <i class="fas fa-sync-alt"></i> Refresh Page
        </button>

        <div class="mt-4">
            <small class="text-muted">
                Last update: <?php echo date('d.m.Y H:i:s'); ?> (Istanbul Time)
            </small>
        </div>
    </div>

    <script>
        // Auto page refresh (every 30 seconds)
        setTimeout(function() {
            location.reload();
        }, 30000);

        // Progress bar animation
        let progress = 65;
        setInterval(function() {
            progress += Math.random() * 2;
            if (progress > 95) progress = 95;
            document.querySelector('.progress-fill').style.width = progress + '%';
        }, 5000);
    </script>
</body>

</html>