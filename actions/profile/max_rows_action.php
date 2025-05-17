<?php
session_start();
include '../../includes/connect_db.php';

if (isset($_POST['max_rows'])) {
    $maxRows = intval($_POST['max_rows']);
    $username = $_SESSION['username'];

    $_SESSION['max_rows'] = $maxRows;

    $stmt = $conn->prepare("UPDATE users SET max_rows = ? WHERE username = ?");
    $stmt->bind_param("is", $maxRows, $username);
    $stmt->execute();
    $stmt->close();
}

header("Location: ../../profile.php");
exit;
?>