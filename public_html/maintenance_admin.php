<?php
session_start();
require_once 'maintenance_config.php';

// Set Istanbul timezone
date_default_timezone_set('Europe/Istanbul');

// Only users with organizer role can access
if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] !== 'organizer' && $_SESSION['user_role'] !== 'organizator')) {
    header('HTTP/1.0 403 Forbidden');
    echo "Access denied. Only organizers can access this page.";
    exit();
}

$message = '';
$messageType = '';

// When form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'enable':
                $reason = $_POST['reason'] ?? '';
                $estimatedTime = $_POST['estimated_time'] ?? '30-45 minutes';
                enableMaintenanceMode($reason, $estimatedTime);
                $message = "Management mode has been successfully enabled.";
                $messageType = 'success';
                break;

            case 'disable':
                disableMaintenanceMode();
                $message = "Management mode has been successfully disabled.";
                $messageType = 'success';
                break;
        }
    }
}

$maintenanceInfo = getMaintenanceInfo();
$isMaintenanceActive = isMaintenanceMode();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Conference Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
        }

        .admin-container {
            max-width: 800px;
            margin: 2rem auto;
        }

        .status-card {
            border-left: 4px solid;
        }

        .status-active {
            border-left-color: #dc3545;
        }

        .status-inactive {
            border-left-color: #28a745;
        }

        .quick-actions .col-md-3 {
            display: flex;
            flex-direction: column;
        }

        .quick-actions .btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: unset;
            height: 100%;
            padding: 10px;
            font-size: 0.95rem;
        }

        .quick-actions .alert {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 80px;
            max-height: 80px;
            margin-bottom: 0;
            font-size: 0.9rem;
            text-align: center;
            padding: 10px;
        }

        .quick-actions .alert i {
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .quick-actions .alert strong {
            font-size: 0.95rem;
            margin-bottom: 2px;
            display: block;
        }

        .quick-actions .alert small {
            font-size: 0.8rem;
            display: block;
        }
    </style>
</head>

<body>
    <div class="container admin-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-cogs"></i> Admin Panel</h1>
            <a href="organizator.php" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Home
            </a>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <!-- Current Status -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-info-circle"></i> Current Status</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="status-card <?php echo $isMaintenanceActive ? 'status-active' : 'status-inactive'; ?> card p-3">
                            <h6>Maintenance Mode Status</h6>
                            <span class="badge badge-<?php echo $isMaintenanceActive ? 'danger' : 'success'; ?> badge-pill">
                                <?php echo $isMaintenanceActive ? 'ACTIVE' : 'INACTIVE'; ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-3">
                            <h6>Last Update</h6>
                            <p class="mb-0"><?php echo date('d.m.Y H:i:s'); ?> (Istanbul Time)</p>
                        </div>
                    </div>
                </div>

                <?php if ($isMaintenanceActive && !empty($maintenanceInfo)): ?>
                    <div class="mt-3">
                        <h6>Maintenance Info:</h6>
                        <ul class="list-unstyled">
                            <li><strong>Start:</strong> <?php echo $maintenanceInfo['start_time']; ?></li>
                            <li><strong>Reason:</strong> <?php echo $maintenanceInfo['reason'] ?: 'Not specified'; ?></li>
                            <li><strong>Estimated Time:</strong> <?php echo $maintenanceInfo['estimated_time']; ?></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Maintenance Mode Controls -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h5><i class="fas fa-power-off"></i> Enable Maintenance Mode</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="action" value="enable">

                            <div class="form-group">
                                <label for="reason">Maintenance Reason:</label>
                                <textarea class="form-control" id="reason" name="reason" rows="3"
                                    placeholder="Enter the reason for maintenance..."></textarea>
                            </div>

                            <div class="form-group">
                                <label for="estimated_time">Estimated Time:</label>
                                <select class="form-control" id="estimated_time" name="estimated_time">
                                    <option value="15-30 minutes">15-30 minutes</option>
                                    <option value="30-45 minutes" selected>30-45 minutes</option>
                                    <option value="1-2 hours">1-2 hours</option>
                                    <option value="2-4 hours">2-4 hours</option>
                                    <option value="4-8 hours">4-8 hours</option>
                                    <option value="1 day">1 day</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-danger btn-block"
                                onclick="return confirm('Are you sure you want to enable maintenance mode?')"
                                <?php if ($isMaintenanceActive) echo 'disabled style="opacity:0.6;cursor:not-allowed;"'; ?>>
                                <i class="fas fa-exclamation-triangle"></i> Start Maintenance Mode
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5><i class="fas fa-check-circle"></i> Disable Maintenance Mode</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($isMaintenanceActive): ?>
                            <form method="POST">
                                <input type="hidden" name="action" value="disable">

                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Attention:</strong> This action will completely disable maintenance mode and allow users to access the system normally.
                                </div>

                                <button type="submit" class="btn btn-success btn-block"
                                    onclick="return confirm('Are you sure you want to disable maintenance mode?')">
                                    <i class="fas fa-check"></i> End Maintenance Mode
                                </button>
                            </form>
                        <?php else: ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i>
                                <strong>System Normal</strong>
                                <small>Maintenance inactive</small>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mt-4">
            <div class="card-header">
                <h5><i class="fas fa-bolt"></i> Quick Actions</h5>
            </div>
            <div class="card-body quick-actions">
                <div class="row">
                    <div class="col-md-3">
                        <?php if ($isMaintenanceActive): ?>
                            <a href="maintenance.php" class="btn btn-outline-primary btn-block" target="_blank">
                                <i class="fas fa-eye"></i> View Maintenance
                            </a>
                        <?php else: ?>
                            <div class="alert alert-success d-flex align-items-center justify-content-center" style="height: 100%; min-height: 80px;">
                                <i class="fas fa-check-circle mr-2"></i>
                                <div>
                                    <strong>System Normal</strong>
                                    <small class="d-block">Maintenance inactive</small>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-3">
                        <a href="rapor.php" class="btn btn-outline-success btn-block">
                            <i class="fas fa-chart-bar"></i> View Report
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="log.php" class="btn btn-outline-info btn-block">
                            <i class="fas fa-file-alt"></i> View Log
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="user_management.php" class="btn btn-outline-warning btn-block">
                            <i class="fas fa-users-cog"></i> User Management
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Info -->
        <div class="card mt-4">
            <div class="card-header">
                <h5><i class="fas fa-server"></i> System Info</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Server IP:</strong> <?php echo $_SERVER['SERVER_ADDR'] ?? 'Unknown'; ?></p>
                        <p><strong>Client IP:</strong> <?php echo $_SERVER['REMOTE_ADDR'] ?? 'Unknown'; ?></p>
                        <p><strong>PHP Version:</strong> <?php echo PHP_VERSION; ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Server Time:</strong> <?php echo date('Y-m-d H:i:s'); ?> (Istanbul)</p>
                        <p><strong>Timezone:</strong> <?php echo date_default_timezone_get(); ?></p>
                        <p><strong>Admin Access:</strong>
                            <span class="badge badge-<?php echo isAdminIP() ? 'success' : 'danger'; ?>">
                                <?php echo isAdminIP() ? 'YES' : 'NO'; ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>