<?php
    include "includes/connect_db.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h3>Sign In</h3>
        <form novalidate action="<?php htmlspecialchars("PHP_SELF")?>" method="post">
            <div class="form-floating my-3">
                <input type="email" class="form-control" id="password-input" placeholder="Email" name="email" required>
                <label for="password-input" class="form-label">Email</label>
                <div class="invalid-feedback" id="email-feedback">Please fill out this field.</div>
            </div>
            <div class="form-floating my-3">
                <input type="password" class="form-control" id="password-input" placeholder="Enter password" name="password" required>
                <label for="password-input" class="form-label">Password</label>
                <div class="invalid-feedback" id="password-feedback ">Please fill out this field.</div>
            </div>
            <button type="submit" class="btn btn-dark">Submit</button>
        </form>
        <a href="sign_up.php">Sign Up</a>
    </div>
    <script src="assets/js/validate-form.js"></script>
</body>
</html>
<?php
    include "actions/account/login_action.php"
?>