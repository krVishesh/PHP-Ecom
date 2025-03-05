<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if cart is empty
if (empty($_SESSION['cart'])) {
    echo "<div style='max-width: 800px; margin: 0 auto; text-align: center;'>
            <p style='font-size: 1.2em; color: #777;'>Your cart is empty. <a href='homepage.php' style='color: #5cb85c; text-decoration: none;'>Go to Homepage</a></p>
          </div>";
    exit();
}

// Handle Checkout Action
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db.php';
    $user_id = $_SESSION['user_id'];
    $order_success = true;

    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $sql = "INSERT INTO orders (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity')";
        if (!mysqli_query($conn, $sql)) {
            $order_success = false;
            break;
        }
    }

    if ($order_success) {
        echo "<div style='max-width: 800px; margin: 0 auto; text-align: center;'>
                <h3 style='font-size: 1.5em; color: #5cb85c; margin-top: 20px;'>Order placed successfully!</h3>
                <p style='font-size: 1.2em; color: #777;'>You will be redirected to the homepage in 2 seconds...</p>
                <a href='homepage.php' style='display: block; text-align: center; margin: 20px auto; padding: 10px 20px; background-color: #5cb85c; color: white; border: none; border-radius: 4px; text-decoration: none;'>Go to Homepage</a>
              </div>";
        // Clear the cart after successful checkout
        unset($_SESSION['cart']);
        echo "<script>
            setTimeout(function() {
                window.location.href = 'homepage.php';
            }, 2000);
        </script>";
    } else {
        echo "<div style='max-width: 800px; margin: 0 auto; text-align: center;'>
                <h3 style='font-size: 1.5em; color: #d9534f; margin-top: 20px;'>Failed to place order. Please try again.</h3>
                <a href='checkout.php' style='display: block; text-align: center; margin: 20px auto; padding: 10px 20px; background-color: #d9534f; color: white; border: none; border-radius: 4px; text-decoration: none;'>Retry</a>
              </div>";
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="styles/checkout_styles.css">
</head>

<body>
    <div class="container">
        <h1>Checkout</h1>
        <a href="homepage.php">Go to Homepage</a> |
        <a href="logout.php">Logout</a>

        <h2>Your Cart Summary</h2>
        <ul>
            <?php
            include 'db.php';
            $overall_total = 0;
            foreach ($_SESSION['cart'] as $id => $quantity) {
                $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
                $product = mysqli_fetch_assoc($result);
                $total_price = $product['price'] * $quantity;
                $overall_total += $total_price;
                echo "<li>{$product['name']} - Quantity: $quantity - Price: \${$product['price']} - Total: \${$total_price}</li>";
            }
            ?>
        </ul>
        <p class="overall-total">Overall Total: $<?= $overall_total ?></p>

        <form method="POST">
            <button type="submit">Place Order</button>
        </form>
    </div>
</body>

</html>