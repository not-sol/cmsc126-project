<?php
session_start();
include '../../includes/connect_db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $userId = $_SESSION['user_id'];

    $stmt = $conn->prepare("UPDATE users SET username = ? WHERE user_id = ?");
    $stmt->bind_param("si", $username, $userId);
    $stmt->execute();
    $stmt->close();

    $_SESSION['username'] = $username;
}

header("Location: ../../profile.php");
exit();
?>