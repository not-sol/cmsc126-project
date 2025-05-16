<?php
    session_start();
    include "includes/connect_db.php";
    include "actions/dashboard/get_data_action.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_darkmode'])) {
        $_SESSION['darkmode'] = ($_SESSION['darkmode'] === 'yes') ? 'no' : 'yes';
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }

    if (isset($_GET['max_rows'])) {
        $_SESSION['max_rows'] = (int) $_GET['max_rows'];
    }

    $maxRows = $_SESSION['max_rows'] ?? 10;
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
<nav class="navbar navbar-expand border-bottom rounded-bottom bg-body-tertiary fixed-top">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">Dashboard</a>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link text-primary" href="#"><?php echo $_SESSION['username'];?></a>
            </li>
        </ul>
    </div>
</nav>

<div class="container border rounded py-5 px-4 px-md-5" style="max-width: 60rem; margin-top: 5rem; margin-bottom: 5rem">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="mb-3">Profile</h1>
        </div>
        <div class="col-auto">
            <div class="btn-group">
                <form action="actions/account/logout_action.php" method="post">
                    <button type="submit" class="btn btn-outline-danger">Logout</button>
                </form>
            </div>
        </div>
    </div>
    <p class="m-2">Username</p>
    <div class="container">
        <div class="row align-items-center border p-3 rounded">
            <div class="col">
                <h2 class="mb-0"><?= htmlspecialchars($_SESSION['username']) ?></h2>
            </div>
            <div class="col-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#change-username-modal">
                        Change
                    </button>
                </div>
            </div>
        </div>
    </div>

    <p class="m-2">Email</p>
    <div class="container">
        <div class="row align-items-center border p-3 rounded">
            <h2 class="mb-0"><?php echo maskEmail($email); ?></h2>
        </div>
    </div>

    <p class="m-2">Password</p>
    <div class="container">
        <div class="row align-items-center border p-3 rounded">
            <div class="col">
                <h2 class="mb-0">********</h2>
            </div>
            <div class="col-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#change-password-modal">
                        Change
                    </button>
                </div>
            </div>
        </div>
    </div>
    <p class="text-center mt-3">You're account was created on <?php echo $_SESSION['reg_time'];?></p>
    <?php if (isset($_SESSION['alert'])): ?>
    <div class="alert alert-<?= $_SESSION['alert']['type'] ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['alert']['message']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>
    
    <h1 class="mt-5 mb-4">Preferences</h1>
    
    <form method="post" action="" class="mb-4">
        <div class="dropdown mb-3 dropend">
            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                Max Rows: <?= $maxRows ?>
            </button>
            <ul class="dropdown-menu">
                <?php foreach ([10, 25, 50, 100] as $opt): ?>
                <li>
                    <a class="dropdown-item <?= $opt == $maxRows ? 'active' : '' ?>" href="?max_rows=<?= $opt ?>">
                    <?= $opt ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </form>


    <form id="darkmode-form" action="actions/profile/toggle_theme_action.php" method="post">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="mySwitch" name="darkmode"
                onchange="document.getElementById('darkmode-form').submit();"
                <?= ($_SESSION['theme'] === 'dark') ? 'checked' : '' ?>>
            <label class="form-check-label" for="mySwitch">Dark Mode</label>
        </div>
    </form>

    <h2 class="mt-5 mb-4">Danger</h2>
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-account-modal">
        Delete Account
    </button>
</div>

<div class="modal fade" id="change-username-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form novalidate action="actions/profile/change_username_action.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Change Username</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating my-3">
                        <input type="text" class="form-control" id="change-username-amount" placeholder="username" name="username" maxlength="50" required>
                        <label class="form-label">New Username</label>
                        <div class="invalid-feedback">Please enter a new username.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="change-password-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form novalidate action="actions/profile/change_password_action.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="current-password" name="current_password" placeholder="password" required>
                        <label for="current-password" class="form-label">Current Password</label>
                        <div class="invalid-feedback" id="password-feedback ">Please fill out this field.</div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="new-password" name="new_password" placeholder="password" required minlength="8">
                        <label for="new-password" class="form-label">New Password</label>
                        <div class="invalid-feedback" id="password-feedback ">Please fill out this field.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="delete-account-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form novalidate action="actions/profile/delete_account_action.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating my-3">
                        <input type="password" class="form-control" id="delete-account" name="password" placeholder="password" required>
                        <label for="delete-account" class="form-label">Password</label>
                        <div class="invalid-feedback" id="password-feedback">Please fill out this field.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.');">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const forms = document.querySelectorAll("form");

    forms.forEach(form => {
        form.addEventListener("submit", function (e) {
        if (!form.checkValidity()) {
            e.preventDefault();
        }
        form.classList.add("was-validated"); 
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>