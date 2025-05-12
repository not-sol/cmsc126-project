<?php
session_start();
include '../../includes/connect_db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_SESSION['user_id'];
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($hashedPasswordFromDb);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($currentPassword, $hashedPasswordFromDb)) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => 'Incorrect current password!'
        ];
        header("Location: ../../profile.php");
        exit();
    }

    $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
    $stmt->bind_param("si", $newHashedPassword, $userId);
    $stmt->execute();
    $stmt->close();

    $_SESSION['alert'] = [
        'type' => 'success',
        'message' => 'Password changed successfully!'
    ];
}

header("Location: ../../profile.php");
exit();
?>