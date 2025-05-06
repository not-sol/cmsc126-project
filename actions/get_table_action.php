<?php
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        echo "You must be logged in.";
        exit();
    }

    $sql = "
        SELECT t.*, c.category_name 
        FROM Transactions t
        JOIN Categories c ON t.category_id = c.category_id
        WHERE c.user_id = ?
        ORDER BY t.transaction_create_date DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
?>