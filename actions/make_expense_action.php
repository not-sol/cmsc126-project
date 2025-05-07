<?php
include "../includes/connect_db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id'];

    $amount = floatval($_POST['amount']);
    $date = $_POST['date'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];

    $stmt1 = $conn->prepare("UPDATE users SET balance = balance - ? WHERE user_id = ?");
    $stmt1->bind_param("di", $amount, $user_id);
    $stmt1->execute();
    $stmt1->close();

    $stmt2 = $conn->prepare("UPDATE Categories SET category_amount = category_amount + ? WHERE category_id = ?");
    $stmt2->bind_param("di", $amount, $category_id);
    $stmt2->execute();
    $stmt2->close();

    $stmt3 = $conn->prepare("INSERT INTO Transactions (category_id, transaction_amount, transaction_date, transaction_description) VALUES (?, ?, ?, ?)");
    $stmt3->bind_param("idss", $category_id, $amount, $date, $description);
    $stmt3->execute();
    $stmt3->close();

    header("Location: ../dashboard.php");
    exit;
}
?>