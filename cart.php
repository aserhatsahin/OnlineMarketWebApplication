<?php
session_start();
include 'includes/db.php';

// Kullanıcı giriş yaptı mı kontrol et
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login to view your cart.'); window.location.href = 'login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

// Sepetteki ürünler ve detaylarını al
$stmt = $db->prepare("SELECT ci.*, p.name, p.price, p.image FROM cart_items ci JOIN products p ON ci.product_id = p.id WHERE ci.user_id = ?");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Sepet toplamını hesapla
$total_price = 0;
foreach ($cart_items as $item) {
    $total_price += $item['price'] * $item['quantity'];
}

// Ürün silme işlemi
if (isset($_GET['remove'])) {
    $product_id = $_GET['remove'];
    $stmt = $db->prepare("DELETE FROM cart_items WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);

    header("Location: cart.php");
    exit();
}

// Sepeti tamamen temizleme
if (isset($_GET['clear'])) {
    $stmt = $db->prepare("DELETE FROM cart_items WHERE user_id = ?");
    $stmt->execute([$user_id]);

    header("Location: cart.php");
    exit();
}

// Ürün adedini artırma/azaltma
if (isset($_POST['update_quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if ($quantity > 0) {
        $stmt = $db->prepare("UPDATE cart_items SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$quantity, $user_id, $product_id]);
    } else {
        $stmt = $db->prepare("DELETE FROM cart_items WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user_id, $product_id]);
    }

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
        <link rel="stylesheet" href="assets/styles.css">
    </head>

    <body>
        <main>
            <h1>Your Cart</h1>
            <?php if (empty($cart_items)): ?>
            <p>Your cart is empty. Add some products!</p>
            <?php else: ?>
            <div class="cart-container">
                <ul>
                    <?php foreach ($cart_items as $item): ?>
                    <li class="cart-item">
                        <img src="images/<?php echo htmlspecialchars($item['image']); ?>"
                            alt="<?php echo htmlspecialchars($item['name']); ?>" class="cart-image">
                        <div class="item-info">
                            <span class="item-name"><?php echo htmlspecialchars($item['name']); ?></span>
                            <span class="item-price">$<?php echo number_format($item['price'], 2); ?></span>
                        </div>
                        <form action="cart.php" method="POST" class="item-form">
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
                            <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                            <button type="submit" name="update_quantity" class="update-btn">Update</button>
                        </form>
                        <div class="item-actions">
                            <a href="cart.php?remove=<?php echo $item['product_id']; ?>" class="remove-btn"
                                onclick="return confirm('Are you sure you want to remove this product?');">Remove</a>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="cart-summary">
                <p><strong>Total Price: $<?php echo number_format($total_price, 2); ?></strong></p>
                <a href="cart.php?clear" class="clear-btn"
                    onclick="return confirm('Are you sure you want to clear your cart?');">Clear Cart</a>
            </div>
            <?php endif; ?>
            <a href="index.php" class="continue-btn">Continue Shopping</a>
        </main>
    </body>

</html>