<?php
    session_start();
    include "includes/connect_db.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UP Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 bg-body">
    <div class="card px-4 py-5" style="width: 100%; max-width: 450px;">
        <h2 class="text-center mb-4">Login to UP Tracker</h2>
        <form novalidate action="actions/account/login_action.php" method="post">
            <div class="form-floating my-3">
                <input type="email" class="form-control" id="password-input" placeholder="Email" name="email" required>
                <label for="password-input" class="form-label">Email</label>
            </div>
            <div class="form-floating my-3">
                <input type="password" class="form-control" id="password-input" placeholder="Enter password" name="password" required>
                <label for="password-input" class="form-label">Password</label>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>   
        </form>
        <p class="text-center mt-3">Don't have an account? <a href="sign_up.php">Sign Up</a></p>
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