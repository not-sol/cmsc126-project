<?php
    include "connect_db.php"
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
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
                <label for="email" class="form-label">Email</label>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="form-floating my-3">
                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password" required>
                <label for="pwd" class="form-label">Password</label>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <button type="submit" class="btn btn-dark">Submit</button>
        </form>
        <a href="sign_up.php">Sign Up</a>
    </div>
    <script src="js/validate-form.js"></script>
</body>
</html>
<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT user_id, username, email, password, balance FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['balance'] = $user['balance'];

                header("Location: dashboard.php");
                exit();
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "Account not found.";
        }
    }
?>
