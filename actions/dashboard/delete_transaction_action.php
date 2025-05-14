<?php
session_start();
include '../../includes/connect_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['transaction_id'])) {
    $transaction_id = $_POST['transaction_id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("
        SELECT t.transaction_amount, c.category_id, c.category_name 
        FROM transactions t 
        JOIN categories c ON t.category_id = c.category_id 
        WHERE t.transaction_id = ? AND c.user_id = ?
    ");
    $stmt->bind_param("ii", $transaction_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $transaction = $result->fetch_assoc();
    $stmt->close();

    $amount = $transaction['transaction_amount'];
    $category_id = $transaction['category_id'];
    $category_name = strtolower($transaction['category_name']);

    if ($category_name === 'income') {
        $stmt = $conn->prepare("UPDATE users SET balance = balance - ? WHERE user_id = ?");
    } else {
        $stmt = $conn->prepare("UPDATE users SET balance = balance + ? WHERE user_id = ?");
    }
    $stmt->bind_param("di", $amount, $user_id);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("UPDATE categories SET category_amount = category_amount - ? WHERE category_id = ?");
    $stmt->bind_param("di", $amount, $category_id);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM transactions WHERE transaction_id = ?");
    $stmt->bind_param("i", $transaction_id);
    $stmt->execute();
    $stmt->close();
}

header("Location: ../../dashboard.php");
exit();
?>
