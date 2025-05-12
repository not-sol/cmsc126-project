<?php
session_start();
include 'connect_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_darkmode'])) {
    $userId = $_SESSION['user_id']; // assuming you have this stored
    $newTheme = ($_SESSION['darkmode'] === 'yes') ? 'no' : 'yes';

    // Update session
    $_SESSION['darkmode'] = $newTheme;

    // Save to database
    $themeValue = ($newTheme === 'yes') ? 'dark' : 'light';
    $stmt = $conn->prepare("UPDATE users SET theme = ? WHERE user_id = ?");
    $stmt->bind_param("si", $themeValue, $userId);
    $stmt->execute();
    $stmt->close();

    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}
?>