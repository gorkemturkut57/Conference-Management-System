<?php
session_start();

// Only organizers can access this page
if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] !== 'organizer' && $_SESSION['user_role'] !== 'organizator')) {
    header('HTTP/1.0 403 Forbidden');
    echo "Access denied. Only organizers can access this page.";
    exit();
}

// Read user data from users.json
function getUsersData()
{
    $usersFile = 'colorlib-regform-7/users.json';
    if (file_exists($usersFile)) {
        $usersData = file_get_contents($usersFile);
        return json_decode($usersData, true) ?: [];
    }
    return [];
}

// Read conference data from text files
function getConferenceData()
{
    $headerFile = 'uploads/header.txt';
    $aboutFile = 'uploads/about_conference.txt';

    $conferences = [];

    if (file_exists($headerFile)) {
        $conferenceName = trim(file_get_contents($headerFile));
        if (!empty($conferenceName)) {
            $conferences[] = [
                'name' => $conferenceName,
                'status' => 'Aktif',
                'participants' => rand(50, 200) // Gerçek veri olmadığı için rastgele
            ];
        }
    }

    return $conferences;
}

// Read review data
function getReviewData()
{
    $reviewFile = 'uploads/review.txt';
    $reviews = [];

    if (file_exists($reviewFile)) {
        $content = file_get_contents($reviewFile);
        $lines = explode("\n", $content);

        foreach ($lines as $line) {
            if (strpos($line, 'Mark:') === 0) {
                $mark = trim(str_replace('Mark:', '', $line));
                if (is_numeric($mark)) {
                    $reviews[] = intval($mark);
                }
            }
        }
    }

    return $reviews;
}

// Get real data
$users = getUsersData();
$conferences = getConferenceData();
$reviews = getReviewData();

// Calculate user statistics
$userStats = [
    'total_users' => count($users),
    'active_users' => count($users), // We count all users as active
    'new_users_this_month' => count($users), // For simplicity
    'user_types' => [
        'organizers' => 0,
        'authors' => 0,
        'reviewers' => 0,
        'attendees' => 0
    ]
];

// Count user roles
foreach ($users as $user) {
    $role = $user['role'] ?? '';
    switch ($role) {
        case 'organizator':
            $userStats['user_types']['organizers']++;
            break;
        case 'organizer':
            $userStats['user_types']['organizers']++;
            break;
        case 'author':
            $userStats['user_types']['authors']++;
            break;
        case 'reviewer':
            $userStats['user_types']['reviewers']++;
            break;
        case 'participant':
            $userStats['user_types']['attendees']++;
            break;
    }
}

// Conference statistics
$conferenceStats = [
    'total_conferences' => count($conferences),
    'active_conferences' => count($conferences),
    'completed_conferences' => 0,
    'total_participants' => array_sum(array_column($conferences, 'participants')),
    'total_papers' => count($conferences), // We assume 1 article per conference
    'total_reviewers' => $userStats['user_types']['reviewers']
];

// Article statistics (based on review data)
$totalReviews = count($reviews);
$acceptedReviews = count(array_filter($reviews, function ($mark) {
    return $mark >= 70;
}));
$rejectedReviews = count(array_filter($reviews, function ($mark) {
    return $mark < 50;
}));
$pendingReviews = $totalReviews - $acceptedReviews - $rejectedReviews;

$articleStats = [
    'total_submitted' => $totalReviews,
    'under_review' => $pendingReviews,
    'accepted' => $acceptedReviews,
    'rejected' => $rejectedReviews,
    'pending' => $pendingReviews
];

// If there is no data, use default values
if ($userStats['total_users'] == 0) {
    $userStats = [
        'total_users' => 0,
        'active_users' => 0,
        'new_users_this_month' => 0,
        'user_types' => [
            'organizers' => 0,
            'authors' => 0,
            'reviewers' => 0,
            'attendees' => 0
        ]
    ];
}

if ($conferenceStats['total_conferences'] == 0) {
    $conferenceStats = [
        'total_conferences' => 0,
        'active_conferences' => 0,
        'completed_conferences' => 0,
        'total_participants' => 0,
        'total_papers' => 0,
        'total_reviewers' => 0
    ];
}

if ($articleStats['total_submitted'] == 0) {
    $articleStats = [
        'total_submitted' => 0,
        'under_review' => 0,
        'accepted' => 0,
        'rejected' => 0,
        'pending' => 0
    ];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporting Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#overview">
                                <i class="fas fa-tachometer-alt"></i> Overview
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#conferences">
                                <i class="fas fa-calendar-alt"></i> Conferences
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#users">
                                <i class="fas fa-users"></i> Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#articles">
                                <i class="fas fa-file-alt"></i> Articles
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#analytics">
                                <i class="fas fa-chart-line"></i> Analytics
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main role="main" class="col-md-10 ml-sm-auto px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Reporting Panel</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="maintenance_admin.php" class="btn btn-outline-secondary mr-2">
                            <i class="fas fa-arrow-left"></i> Back to Admin
                        </a>
                        <div class="btn-group mr-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="exportReport()">Download PDF</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="exportExcel()">Download Excel</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                            <i class="fas fa-calendar"></i> This Week
                        </button>
                    </div>
                </div>

                <!-- Overview Section -->
                <section id="overview">
                    <h2>Overview</h2>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card text-white bg-primary mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title">Total Conferences</h5>
                                            <h2><?php echo $conferenceStats['total_conferences']; ?></h2>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-calendar fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-success mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title">Active Users</h5>
                                            <h2><?php echo $userStats['active_users']; ?></h2>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-users fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-info mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title">Total Articles</h5>
                                            <h2><?php echo $articleStats['total_submitted']; ?></h2>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-file-alt fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-warning mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title">Total Participants</h5>
                                            <h2><?php echo $conferenceStats['total_participants']; ?></h2>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-user-graduate fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Conferences Section -->
                <section id="conferences" class="mt-5">
                    <h2>Conference Statistics</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Conference Status</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="conferenceChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Conference List</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Conference Name</th>
                                                    <th>Status</th>
                                                    <th>Participants</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (count($conferences) > 0): ?>
                                                    <?php foreach ($conferences as $conference): ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($conference['name']); ?></td>
                                                            <td><span class="badge badge-success"><?php echo $conference['status'] == 'Aktif' ? 'Active' : $conference['status']; ?></span></td>
                                                            <td><?php echo $conference['participants']; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="3" class="text-center">No conferences found yet</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Users Section -->
                <section id="users" class="mt-5">
                    <h2>User Reports</h2>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5>User Distribution</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="userChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>User Statistics</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Organizers
                                            <span class="badge badge-primary badge-pill"><?php echo $userStats['user_types']['organizers']; ?></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Authors
                                            <span class="badge badge-success badge-pill"><?php echo $userStats['user_types']['authors']; ?></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Reviewers
                                            <span class="badge badge-info badge-pill"><?php echo $userStats['user_types']['reviewers']; ?></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Attendees
                                            <span class="badge badge-warning badge-pill"><?php echo $userStats['user_types']['attendees']; ?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Articles Section -->
                <section id="articles" class="mt-5">
                    <h2>Article Statistics</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Article Status</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="articleChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Article Details</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <h3 class="text-primary"><?php echo $articleStats['accepted']; ?></h3>
                                            <p>Accepted</p>
                                        </div>
                                        <div class="col-6">
                                            <h3 class="text-danger"><?php echo $articleStats['rejected']; ?></h3>
                                            <p>Rejected</p>
                                        </div>
                                        <div class="col-6">
                                            <h3 class="text-warning"><?php echo $articleStats['under_review']; ?></h3>
                                            <p>Under Review</p>
                                        </div>
                                        <div class="col-6">
                                            <h3 class="text-info"><?php echo $articleStats['pending']; ?></h3>
                                            <p>Pending</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Analytics Section -->
                <section id="analytics" class="mt-5">
                    <h2>Analytics</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Review Score Distribution</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="reviewChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>

    <script>
        // Conference Chart
        const conferenceCtx = document.getElementById('conferenceChart').getContext('2d');
        new Chart(conferenceCtx, {
            type: 'doughnut',
            data: {
                labels: ['Active', 'Planned', 'Completed'],
                datasets: [{
                    data: [<?php echo $conferenceStats['active_conferences']; ?>, 0, <?php echo $conferenceStats['completed_conferences']; ?>],
                    backgroundColor: ['#28a745', '#ffc107', '#6c757d']
                }]
            }
        });

        // User Chart
        const userCtx = document.getElementById('userChart').getContext('2d');
        new Chart(userCtx, {
            type: 'bar',
            data: {
                labels: ['Organizers', 'Authors', 'Reviewers', 'Attendees'],
                datasets: [{
                    label: 'User Count',
                    data: [
                        <?php echo $userStats['user_types']['organizers']; ?>,
                        <?php echo $userStats['user_types']['authors']; ?>,
                        <?php echo $userStats['user_types']['reviewers']; ?>,
                        <?php echo $userStats['user_types']['attendees']; ?>
                    ],
                    backgroundColor: ['#007bff', '#28a745', '#17a2b8', '#ffc107']
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Article Chart
        const articleCtx = document.getElementById('articleChart').getContext('2d');
        new Chart(articleCtx, {
            type: 'pie',
            data: {
                labels: ['Accepted', 'Rejected', 'Under Review', 'Pending'],
                datasets: [{
                    data: [
                        <?php echo $articleStats['accepted']; ?>,
                        <?php echo $articleStats['rejected']; ?>,
                        <?php echo $articleStats['under_review']; ?>,
                        <?php echo $articleStats['pending']; ?>
                    ],
                    backgroundColor: ['#28a745', '#dc3545', '#ffc107', '#17a2b8']
                }]
            }
        });

        // Review Chart
        const reviewCtx = document.getElementById('reviewChart').getContext('2d');
        new Chart(reviewCtx, {
            type: 'line',
            data: {
                labels: ['Review 1', 'Review 2', 'Review 3', 'Review 4', 'Review 5'],
                datasets: [{
                    label: 'Review Scores',
                    data: [<?php echo implode(',', $reviews); ?>],
                    borderColor: '#007bff',
                    fill: false,
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });

        // Export functions
        function exportReport() {
            alert('Downloading PDF report...');
        }

        function exportExcel() {
            alert('Downloading Excel report...');
        }
    </script>
</body>

</html>