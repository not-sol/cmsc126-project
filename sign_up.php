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
        <h3>Sign Up</h3>
        <form novalidate action="<?php htmlspecialchars("PHP_SELF")?>" method="post">
            <div class="form-floating my-3">
                <input type="email" class="form-control form-control-sm" id="email" placeholder="Enter email" name="email" required>
                <label for="email" class="form-label">Email</label>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="form-floating my-3">
                <input type="username" class="form-control" id="uname" placeholder="Enter username" name="username" required>
                <label for="uname" class="form-label">Username</label>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="form-floating my-3">
                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password" required>
                <label for="pwd" class="form-label">Password</label>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <button type="submit" class="btn btn-dark">Submit</button>
        </form>
        <a href="login.php">Login</a>
    </div>
    <script src="js/validate-form.js"></script>
</body>
</html>
<?php
include "connect_db.php";

$categories = [
    ['Food', '#640D5F', 0],
    ['Transportation', '#D91656', 0],
    ['Clothes', '#EB5B00', 0],
    ['Others', '#AB4459', 0]
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];
    $balance = 0;
    $theme = "light";

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, balance, theme) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssds", $username, $email, $hash, $balance, $theme);

    if ($stmt->execute()) {
        $user_id = $conn->insert_id;

        $stmtCat = $conn->prepare("INSERT INTO Categories (user_id, category_name, category_color, category_amount) VALUES (?, ?, ?, ?)");

        foreach ($categories as $category) {
            $stmtCat->bind_param("issd", $user_id, $category[0], $category[1], $category[2]);
            $stmtCat->execute();
        }

        $stmtCat->close();
        $stmt->close();
        $conn->close();

        header("Location: login.php");
        exit();
    } else {
        echo "Email is already in use.";
    }
}
?>
