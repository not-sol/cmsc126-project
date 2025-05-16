<?php


$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];
$maxRows = $_SESSION['max_rows'] ?? 10;
$sortOrder = $_SESSION['sort'] ?? 'date_create_asc';

$stmt = $conn->prepare("SELECT balance FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$_SESSION['balance'] = $user['balance'];

switch ($sortOrder) {
    case 'date_create_asc':
        $orderClause = "transaction_create_date ASC";
        break;
    case 'date_create_desc':
        $orderClause = "transaction_create_date DESC";
        break;
    case 'date_asc':
        $orderClause = "transaction_date ASC";
        break;
    case 'date_desc':
        $orderClause = "transaction_date DESC";
        break;
    case 'amount_asc':
        $orderClause = "transaction_amount ASC";
        break;
    case 'amount_desc':
        $orderClause = "transaction_amount DESC";
        break;
    default:
        $orderClause = "transaction_create_date ASC";
        break;
}

$currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

$totalRowsQuery = $conn->query("SELECT COUNT(*) as total FROM transactions");
$totalRows = $totalRowsQuery->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $maxRows);

$offset = ($currentPage - 1) * $maxRows;

$transactionData = $conn->query("
    SELECT * FROM transactions
    JOIN categories ON transactions.category_id = categories.category_id
    ORDER BY $orderClause
    LIMIT $maxRows OFFSET $offset
");


$stmt2 = $conn->prepare("
    SELECT category_id, category_color, category_name, category_amount 
    FROM Categories 
    WHERE user_id = ?
");
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$result2 = $stmt2->get_result();

$categories = [];
$labels = [];
$data = [];
$colors = [];
$income_total = 0;
$expense_total = 0;

while ($row = $result2->fetch_assoc()) {

    if (strtolower($row['category_name']) === 'income') {
        $income_total += (float)$row['category_amount'];
    } else {
        $expense_total += (float)$row['category_amount'];
    }
    
    $categories[] = $row;
    if (strtolower($row['category_name']) === 'income') {
        continue;
    }
    $labels[] = $row['category_name'];
    $data[] = (float)$row['category_amount'];
    $colors[] = $row['category_color'];
}

function maskEmail($email) {
    $parts = explode("@", $email);
    $name = $parts[0];
    $domain = $parts[1];

    $visibleLength = min(3, strlen($name));
    $visiblePart = substr($name, 0, $visibleLength);
    $maskedPart = str_repeat('*', strlen($name) - $visibleLength);

    return $visiblePart . $maskedPart . '@' . $domain;
}

?>

