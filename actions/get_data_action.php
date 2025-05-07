<?php
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    echo "You must be logged in.";
    exit();
}

$stmt = $conn->prepare("SELECT balance FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$_SESSION['balance'] = $user['balance'];

$stmt1 = $conn->prepare("
    SELECT t.*, c.category_name 
    FROM Transactions t 
    JOIN Categories c ON t.category_id = c.category_id 
    WHERE c.user_id = ? 
    ORDER BY t.transaction_create_date DESC
");
$stmt1->bind_param("i", $user_id);
$stmt1->execute();
$transactionData = $stmt1->get_result();

$stmt2 = $conn->prepare("
    SELECT category_id, category_color, category_name, category_amount 
    FROM Categories 
    WHERE user_id = ?
");
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$result2 = $stmt2->get_result();

$categories = [];
while ($row = $result2->fetch_assoc()) {
    $categories[] = $row;
}
?>