CREATE TABLE Users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    reg_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    balance FLOAT DEFAULT 0,
    theme VARCHAR(255)
);

CREATE TABLE Categories (
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    category_name VARCHAR(255),
    category_color VARCHAR(255),
    category_amount FLOAT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

CREATE TABLE Transactions (
    transaction_id INT PRIMARY KEY AUTO_INCREMENT,
    category_id INT,
    transactions_amount FLOAT,
    transactions_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    transactions_description VARCHAR(255),
    FOREIGN KEY (category_id) REFERENCES Categories(category_id)
);