<?php
    
    session_start();
    include '../../includes/connect_db.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

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
                $_SESSION['email'] = $user['email'];
                $_SESSION['reg_time'] = date("F d, Y", strtotime($user['reg_time']));
                $_SESSION['theme'] = $user['theme'];
                $_SESSION['max_rows'] = $user['max_rows'];
                
                header("Location: ../../dashboard.php");
                exit();
            } else {
                $_SESSION['alert'] = [
                    'type' => 'danger',
                    'message' => 'Incorrect password!'
                ];
                header("Location: ../../login.php");
                exit();
            }
        } else {
            $_SESSION['alert'] = [
                'type' => 'danger',
                'message' => 'No account found!'
            ];
            header("Location: ../../login.php");
            exit();
        }
    }
?>