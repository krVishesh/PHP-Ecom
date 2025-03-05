<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle Add to Cart action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }
    header("Location: homepage.php");
    exit();
}

// Handle Remove from Cart action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="styles/cart_styles.css">
</head>

<body>
    <div class="container">
        <h1>Your Cart</h1>
        <a href="homepage.php">Back to Homepage</a>

        <?php if (empty($_SESSION['cart'])) { ?>
            <p class="empty-cart">Your cart is empty.</p>
        <?php } else { ?>
            <ul>
                <?php
                include 'db.php';
                $overall_total = 0;
                foreach ($_SESSION['cart'] as $id => $quantity) {
                    $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
                    $product = mysqli_fetch_assoc($result);
                    $total_price = $product['price'] * $quantity;
                    $overall_total += $total_price;
                    echo "<li>
                {$product['name']} (Quantity: $quantity) <span class='item-total'>Total: \${$total_price}</span>
                <form method='POST' style='display:inline;'>
                    <input type='hidden' name='product_id' value='$id'>
                    <button type='submit' name='remove_from_cart'>Remove</button>
                </form>
              </li>";
                }
                ?>
            </ul>
            <p class="overall-total">Overall Total: $<?= $overall_total ?></p>
            <a class="checkout" href="checkout.php">Proceed to Checkout</a>
        <?php } ?>
    </div>
</body>

</html>