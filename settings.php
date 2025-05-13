<?php
    session_start();
    include "includes/connect_db.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_darkmode'])) {
        $_SESSION['darkmode'] = ($_SESSION['darkmode'] === 'yes') ? 'no' : 'yes';
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="<?= ($_SESSION['theme'] === 'dark') ? 'dark' : 'light' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
    <a href="index.php">Home</a>
    <a href="profile.php">Profile</a>
    <a href="dashboard.php">Dashboard</a>
    <form action="actions/account/logout_action.php" method="post">
        <button type="submit" class="btn btn-outline-danger">Logout</button>
    </form>

    <form id="darkmode-form" action="actions/settings/toggle_theme_action.php" method="post">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="mySwitch" name="darkmode"
                onchange="document.getElementById('darkmode-form').submit();"
                <?= ($_SESSION['theme'] === 'dark') ? 'checked' : '' ?>>
            <label class="form-check-label" for="mySwitch">Dark Mode</label>
        </div>
    </form>
</body>
</html>