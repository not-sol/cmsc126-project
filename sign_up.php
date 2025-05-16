<?php
    session_start();
    include "includes/connect_db.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - UP Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 bg-body">
    <div class="card px-4 py-5" style="width: 100%; max-width: 450px;">
        <h2 class="text-center mb-4">Create an Account</h2>
        <form novalidate action="actions/account/sign_up_action.php" method="post">
            <div class="form-floating my-3">
                <input type="email" class="form-control form-control-sm" id="email" placeholder="Enter email" name="email" required>
                <label for="email" class="form-label">Email</label>
            </div>
            <div class="form-floating my-3">
                <input type="text" class="form-control" id="uname" placeholder="Enter username" name="username" required>
                <label for="uname" class="form-label">Username</label>
            </div>
            <div class="form-floating my-3">
                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password" minlength="8" required>
                <label for="pwd" class="form-label">Password</label>
            </div>
            <button type="submit" name="sign_up" class="btn btn-success w-100">Sign Up</button>
            <div class="text-center mt-3">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
        <?php if (isset($_SESSION['alert'])): ?>
        <div class="alert alert-<?= $_SESSION['alert']['type'] ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['alert']['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['alert']); ?>
        <?php endif; ?>
    </div>
    <script src="assets/js/validate-form.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>