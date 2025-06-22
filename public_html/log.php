<?php
session_start();

// Only organizers can access this page
if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] !== 'organizer' && $_SESSION['user_role'] !== 'organizator')) {
    header('HTTP/1.0 403 Forbidden');
    echo "Access denied. Only organizers can access this page.";
    exit();
}

// Log watching page
$log_file = 'logs.txt';
$log_content = '';
if (file_exists($log_file)) {
    $log_content = file_get_contents($log_file);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Watching Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Log Watching Page</h1>
        <p>This page will display the system logs.</p>
        <pre id="log-content" style="background-color: #f8f9fa; border: 1px solid #dee2e6; padding: 10px; height: 500px; overflow-y: scroll;"><?php echo htmlspecialchars($log_content); ?></pre>
    </div>

    <script>
        function fetchLogs() {
            fetch('get_logs.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('log-content').textContent = data;
                });
        }

        setInterval(fetchLogs, 5000); // Fetch logs every 5 seconds
    </script>
</body>

</html>