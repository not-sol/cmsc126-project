<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "
            <script>
                const form = document.querySelector('form');
                const emailInput = document.getElementById('email-input');
                const passwordInput = document.getElementById('password-input');
                const emailFeedback = document.getElementById('email-feedback');
                const passwordFeedback = document.getElementById('password-feedback');
                
                emailFeedback.innerHTML = 'Please fill out this field.';
                passwordFeedback.innerHTML = 'Please fill out this field.';
                emailInput.classList.remove('is-invalid');
                passwordInput.classList.remove('is-invalid');
                form.classList.add('was-validated');
            </script>";

        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT user_id, username, email, password, balance, theme, reg_time FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['reg_time'] = date("F d, Y", strtotime($user['reg_time']));
                $_SESSION['theme'] = $user['theme'];
                
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Wrong pass";
                echo "
                    <script>
                        form.classList.remove('was-validated');
                        passwordFeedback.innerHTML = 'Incorrect password';
                        passwordInput.classList.add('is-invalid');
                    </script>";
            }
        } else {
            echo "No account";
            echo "
                <script>
                    form.classList.remove('was-validated');
                    emailFeedback.innerHTML = 'Account not found';
                    emailInput.classList.add('is-invalid');
                </script>";
        }
    }
?>