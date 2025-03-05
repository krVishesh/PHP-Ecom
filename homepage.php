<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$cart_count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
$result = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="styles/homepage_styles.css">
</head>

<body>
    <div class="container">
        <h1>Welcome to the Homepage</h1>
        <div class="header">
            <span>Items in Cart: <strong><?php echo $cart_count; ?></strong></span> |
            <a href="cart.php">View Cart</a> |
            <a href="logout.php">Logout</a>
        </div>

        <h2>Products</h2>
        <div class="products-grid">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="product">
                    <h3><?= $row['name'] ?></h3>
                    <p><?= $row['description'] ?></p>
                    <p>Price: $<?= $row['price'] ?></p>
                    <form action="cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                        <button type="submit" name="add_to_cart">Add to Cart</button>
                        <span>
                            Item in cart:
                            <strong>
                                <?php
                                $product_id = $row['id'];
                                $item_count = isset($_SESSION['cart'][$product_id]) ? $_SESSION['cart'][$product_id] : 0;
                                echo $item_count;
                                ?>
                            </strong>
                        </span>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>