<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database_name"; // change to your actual DB name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 1. Insert into Users
$username = "juan_dela_cruz";
$email = "juan@example.com";
$password_user = "mypassword123"; // avoid conflict with $password for db
$balance = 1000.00;
$theme = "light";

$sqlUser = "INSERT INTO Users (username, email, password, balance, theme)
VALUES ('$username', '$email', '$password_user', $balance, '$theme')";

if ($conn->query($sqlUser) === TRUE) {
    echo "User inserted successfully!<br>";

    // Get the last inserted user_id
    $user_id = $conn->insert_id;
    echo "New user_id is: " . $user_id . "<br>";

    // 2. Insert into Categories using the new user_id
    $category_name = "Food";
    $category_color = "#FF5733";

    $sqlCategory = "INSERT INTO Categories (user_id, category_name, category_color)
    VALUES ($user_id, '$category_name', '$category_color')";

    if ($conn->query($sqlCategory) === TRUE) {
        echo "Category inserted successfully!<br>";

        // Get the last inserted category_id
        $category_id = $conn->insert_id;
        echo "New category_id is: " . $category_id . "<br>";

        // 3. Insert into Transactions using the new category_id
        $transactions_amount = 250.00;
        $transactions_description = "Grocery shopping at the mall";

        $sqlTransaction = "INSERT INTO Transactions (category_id, transactions_amount, transactions_description)
        VALUES ($category_id, $transactions_amount, '$transactions_description')";

        if ($conn->query($sqlTransaction) === TRUE) {
            echo "Transaction inserted successfully!";
        } else {
            echo "Error inserting transaction: " . $conn->error;
        }

    } else {
        echo "Error inserting category: " . $conn->error;
    }

} else {
    echo "Error inserting user: " . $conn->error;
}

// Close connection
$conn->close();
?>
