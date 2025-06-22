<?php
session_start();
require_once 'maintenance_config.php';

// Only users with the organizer role can access
if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] !== 'organizer' && $_SESSION['user_role'] !== 'organizator')) {
    header('HTTP/1.0 403 Forbidden');
    echo "Access denied. Only organizers can access this page.";
    exit();
}

$message = '';
$messageType = '';

// Read users from users.json file
$usersFile = __DIR__ . '/colorlib-regform-7/users.json';
$users = [];
if (file_exists($usersFile)) {
    $users = json_decode(file_get_contents($usersFile), true);
}

// User deletion process
if (isset($_POST['delete_user'])) {
    $emailToDelete = $_POST['delete_user'];
    foreach ($users as $key => $user) {
        if ($user['email'] === $emailToDelete) {
            unset($users[$key]);
            file_put_contents($usersFile, json_encode(array_values($users), JSON_PRETTY_PRINT));
            $message = 'User deleted successfully.';
            $messageType = 'success';
            break;
        }
    }
}

// User update process
if (isset($_POST['update_user'])) {
    $emailToUpdate = $_POST['original_email'];
    $newName = $_POST['name'];
    $newEmail = $_POST['email'];
    $newRole = $_POST['role'];

    foreach ($users as $key => $user) {
        if ($user['email'] === $emailToUpdate) {
            $users[$key]['name'] = $newName;
            $users[$key]['email'] = $newEmail;
            $users[$key]['role'] = $newRole;
            file_put_contents($usersFile, json_encode(array_values($users), JSON_PRETTY_PRINT));
            $message = 'User information updated.';
            $messageType = 'success';
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .admin-container {
            padding: 2rem;
        }

        .user-card {
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 1rem;
        }

        .actions {
            display: flex;
            gap: 0.5rem;
        }
    </style>
</head>

<body>
    <div class="container admin-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-users-cog"></i> User Management</h1>
            <a href="maintenance_admin.php" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Maintenance Panel
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

        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-list"></i> Registered Users</h5>
            </div>
            <div class="card-body">
                <?php foreach ($users as $user): ?>
                    <div class="user-card">
                        <form method="POST" class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Name Surname:</label>
                                    <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($user['name']); ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Email:</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Role:</label>
                                    <select class="form-control" name="role">
                                        <option value="author" <?php echo $user['role'] === 'author' ? 'selected' : ''; ?>>Author</option>
                                        <option value="reviewer" <?php echo $user['role'] === 'reviewer' ? 'selected' : ''; ?>>Reviewer</option>
                                        <option value="organizator" <?php echo $user['role'] === 'organizator' ? 'selected' : ''; ?>>Organizer</option>
                                        <option value="participant" <?php echo $user['role'] === 'participant' ? 'selected' : ''; ?>>Attendee</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Actions:</label>
                                    <div class="actions">
                                        <input type="hidden" name="original_email" value="<?php echo htmlspecialchars($user['email']); ?>">
                                        <button type="submit" name="update_user" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Update
                                        </button>
                                        <button type="submit" name="delete_user" value="<?php echo htmlspecialchars($user['email']); ?>"
                                            class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>