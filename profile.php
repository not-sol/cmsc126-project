<?php
    session_start();
    include "includes/connect_db.php";
    include "actions/dashboard/get_data_action.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_darkmode'])) {
    $_SESSION['darkmode'] = ($_SESSION['darkmode'] === 'yes') ? 'no' : 'yes';
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body class="<?= ($_SESSION['darkmode'] ?? 'no') === 'yes' ? 'bg-dark text-light' : '' ?>">

<div class="container">
    <h1>Hello, <?php echo $_SESSION['username'];?></h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#change-username-modal">
        Change Username
    </button>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#change-password-modal">
        Change Password
    </button>
    <?php if (isset($_SESSION['alert'])): ?>
    <div class="alert alert-<?= $_SESSION['alert']['type'] ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['alert']['message']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>

    <form method="post" id="darkmode-form">
    <input type="hidden" name="toggle_darkmode" value="1">
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="mySwitch" name="darkmode"
            onchange="document.getElementById('darkmode-form').submit();"
            <?= (isset($_SESSION['darkmode']) && $_SESSION['darkmode'] === 'yes') ? 'checked' : '' ?>>
        <label class="form-check-label" for="mySwitch">Dark Mode</label>
    </div>
</form>
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