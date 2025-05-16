<?php
session_start();
include '../../includes/connect_db.php';

$userId = $_SESSION['user_id'];
$currentTheme = $_SESSION['theme'] ?? 'light';

$newTheme = ($currentTheme === 'dark') ? 'light' : 'dark';
$_SESSION['theme'] = $newTheme;

$stmt = $conn->prepare("UPDATE users SET theme = ? WHERE user_id = ?");
$stmt->bind_param("si", $newTheme, $userId);
$stmt->execute();
$stmt->close();

header("Location: ../../profile.php");
exit();
?>