<?php
session_start();
require_once "includes/connect_db.php"; // Use require_once for critical files
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="<?= ($_SESSION['theme'] ?? 'light') === 'dark' ? 'dark' : 'light' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UP Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body class="d-flex flex-column align-items-center justify-content-center min-vh-100 bg-body">
    <div class="container text-center">
        <?php if (isset($_SESSION['user_id'])): ?>
            <h1 class="mb-3">Welcome to <strong>UP Tracker</strong></h1>
            <p class="lead">Track your university progress and performance in one place.</p>
            <a href="dashboard.php" class="btn btn-primary mt-3">Go to Dashboard</a>
        <?php else: ?>
            <h1 class="mb-3">Welcome to <strong>UP Tracker</strong></h1>
            <p class="lead">Please log in or sign up to get started.</p>
            <a href="login.php" class="btn btn-success me-2">Login</a>
            <a href="sign_up.php" class="btn btn-outline-primary">Sign Up</a>
        <?php endif; ?>
    </div>
</body>
</html>