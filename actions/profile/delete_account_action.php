<?php
session_start();
include '../../includes/connect_db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $userId = $_SESSION['user_id'];
    $enteredPassword = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($enteredPassword, $hashedPassword)) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => 'Incorrect current password!'
        ];
        header("Location: ../../profile.php");
        exit();
    }

    $deleteTransactions = $conn->prepare("
        DELETE t FROM Transactions t
        JOIN Categories c ON t.category_id = c.category_id
        WHERE c.user_id = ?
    ");
    $deleteTransactions->bind_param("i", $userId);
    $deleteTransactions->execute();
    $deleteTransactions->close();

    $deleteCategories = $conn->prepare("DELETE FROM Categories WHERE user_id = ?");
    $deleteCategories->bind_param("i", $userId);
    $deleteCategories->execute();
    $deleteCategories->close();

    $deleteUser = $conn->prepare("DELETE FROM Users WHERE user_id = ?");
    $deleteUser->bind_param("i", $userId);
    $deleteUser->execute();
    $deleteUser->close();

    session_unset();
    session_destroy();
    header("Location: ../../index.php");
    exit();
}
?>
