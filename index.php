<?php
    session_start();
    include "includes/connect_db.php"
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="<?= (isset($_SESSION['theme']) && $_SESSION['theme'] === 'dark') ? 'dark' : 'light' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UP Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
    <div>Welcome page</div>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="dashboard.php">Dashboard</a>
    <?php else: ?>
        <a href="login.php">Login</a>
    <?php endif; ?>
</body>
</html>