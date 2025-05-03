<?php
// examples
$categories = [
    ['Food', '#640D5F', 0],
    ['Transportation', '#D91656', 0],
    ['Clothes', '#EB5B00', 0],
    ['Others', '#AB4459', 0]
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
        echo "Email is already in use. Please try another.";
        $checkEmail->close();
    } else {
        $checkEmail->close();

        $stmtUsers = $conn->prepare("INSERT INTO users (username, email, password, balance, theme) VALUES (?, ?, ?, ?, ?)");
        $stmtUsers->bind_param("sssds", $username, $email, $hash, $balance, $theme);

        if ($stmtUsers->execute()) {
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

            header("Location: login.php");
            exit();
        } else {
            echo "Something went wrong while creating your account.";
        }
    }
}
?>