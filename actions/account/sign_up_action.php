<?php
session_start();
include '../../includes/connect_db.php';

$categories = [
    ['Income', '#1F7D53', 0],
    ['Food', '#F0A04B', 0],
    ['Transportation', '#D50B8B', 0],
    ['School', '#F1BA88', 0],
    ['Others', '#8E1616', 0]
];

$transactions_amount = 0;
$transactions_date = date('Y-m-d');
$transactions_description = "Grocery shopping at the mall (example)";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];
    $balance = 0;
    $theme = "light";

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $checkEmail = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $checkEmail->store_result();

    if ($checkEmail->num_rows > 0) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => 'Email is already registered!'
        ];
        header("Location: ../../sign_up.php");
        $checkEmail->close();
        exit();
    } else {
        $checkEmail->close();

        $stmtUsers = $conn->prepare("INSERT INTO users (username, email, password, balance, theme) VALUES (?, ?, ?, ?, ?)");
        $stmtUsers->bind_param("sssds", $username, $email, $hash, $balance, $theme);

        $stmtUsers->execute();
        $user_id = $conn->insert_id;

        $stmtCategory = $conn->prepare("INSERT INTO Categories (user_id, category_name, category_color, category_amount) VALUES (?, ?, ?, ?)");

        foreach ($categories as $category) {
            $stmtCategory->bind_param("issd", $user_id, $category[0], $category[1], $category[2]);
            $stmtCategory->execute();

            if ($category[0] === 'Food') {
                $category_id = $conn->insert_id;

                $stmtTransactions = $conn->prepare("INSERT INTO Transactions (category_id, transaction_amount, transaction_date, transaction_description) VALUES (?, ?, ?, ?)");
                $stmtTransactions->bind_param("idss", $category_id, $transactions_amount, $transactions_date, $transactions_description);
                $stmtTransactions->execute();
                $stmtTransactions->close();
            }
        }

        $stmtCategory->close();
        $stmtUsers->close();
        $conn->close();

        header("Location: ../../login.php");
        exit();
    }
}
?>