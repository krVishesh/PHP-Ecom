<?php
$host = "localhost";
$user = "root";
$password = "";

// Connect to MySQL server (without specifying a database yet)
$conn = mysqli_connect($host, $user, $password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create the `ecommerce` database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS ecommerce";
if (mysqli_query($conn, $sql)) {
    echo "";
} else {
    echo "Error creating database: " . mysqli_error($conn);
}

// Select the `ecommerce` database
mysqli_select_db($conn, 'ecommerce');

// Create the `users` table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
)";
mysqli_query($conn, $sql);

// Create the `products` table
$sql = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(100)
)";
mysqli_query($conn, $sql);

// Create the `orders` table
$sql = "CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    quantity INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
)";
mysqli_query($conn, $sql);

// Insert sample products if not already inserted
$sql = "SELECT COUNT(*) AS total FROM products";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['total'] == 0) {
    $sql = "INSERT INTO products (name, description, price, image) VALUES
    ('Product 1', 'Description for product 1', 10.99, 'product1.jpg'),
    ('Product 2', 'Description for product 2', 19.99, 'product2.jpg'),
    ('Product 3', 'Description for product 3', 15.99, 'product3.jpg'),
    ('Product 4', 'Description for product 4', 25.99, 'product4.jpg'),
    ('Product 5', 'Description for product 5', 8.99, 'product5.jpg'),
    ('Product 6', 'Description for product 6', 5.99, 'product6.jpg'),
    ('Product 7', 'Description for product 7', 14.99, 'product7.jpg'),
    ('Product 8', 'Description for product 8', 29.99, 'product8.jpg'),
    ('Product 9', 'Description for product 9', 49.99, 'product9.jpg'),
    ('Product 10', 'Description for product 10', 99.99, 'product10.jpg')";

    if (mysqli_query($conn, $sql)) {
        echo "";
    } else {
        echo "Error inserting products: " . mysqli_error($conn);
    }
}

// Close the connection
mysqli_close($conn);
