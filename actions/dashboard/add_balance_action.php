<?php
    include "../../includes/connect_db.php";
    session_start();
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $user_id = $_SESSION['user_id'];
        $amount = floatval($_POST['amount']);
        $date = $_POST['date'];
        $description = $_POST['description'];

        $stmt1 = $conn->prepare("UPDATE users SET balance = balance + ? WHERE user_id = ?");
        $stmt1->bind_param("di", $amount, $user_id);
        $stmt1->execute();
        $stmt1->close();

        $stmt2 = $conn->prepare("UPDATE Categories SET category_amount = category_amount + ? WHERE user_id = ? AND category_name = 'Income'");
        $stmt2->bind_param("di", $amount, $user_id);
        $stmt2->execute();
        $stmt2->close();

        $stmt3 = $conn->prepare("SELECT category_id FROM Categories WHERE user_id = ? AND category_name = 'Income'");
        $stmt3->bind_param("i", $user_id);
        $stmt3->execute();
        $result = $stmt3->get_result();

        if ($row = $result->fetch_assoc()) {
            $category_id = $row['category_id'];

            $stmt4 = $conn->prepare("INSERT INTO Transactions (category_id, transaction_amount, transaction_date, transaction_description) VALUES (?, ?, ?, ?)");
            $stmt4->bind_param("idss", $category_id, $amount, $date, $description);
            $stmt4->execute();
            $stmt4->close();
        }
        $stmt3->close();

        header("Location: ../../dashboard.php");
        exit();
    }
?>