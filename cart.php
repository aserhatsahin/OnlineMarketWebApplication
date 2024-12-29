<?php
session_start();
include 'includes/db.php';

// Kullanıcı giriş yaptı mı kontrol et
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login to view your cart.'); window.location.href = 'login.php';</script>";
    exit;
}

// Kullanıcı ID'sini al
$user_id = $_SESSION['user_id'];

// Sepetteki ürünler ve detaylarını al
$stmt = $db->prepare("SELECT ci.*, p.name, p.price FROM cart_items ci JOIN products p ON ci.product_id = p.id WHERE ci.user_id = ?");
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

    // Silme işleminden sonra sepeti yeniden yükle
    header("Location: cart.php");
    exit;
}

?>

<main>
    <link rel="stylesheet" href="assets/styles.css">
    <h1>Your Cart</h1>

    <?php if (empty($cart_items)): ?>
        <p>Your cart is empty. Add some products!</p>
    <?php else: ?>
        <ul>
            <?php foreach ($cart_items as $item): ?>
                <li>
                    <?php echo htmlspecialchars($item['name']); ?> -
                    Quantity: <?php echo $item['quantity']; ?> -
                    Price: $<?php echo number_format($item['price'], 2); ?> -
                    Total: $<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                    <a href="cart.php?remove=<?php echo $item['product_id']; ?>"
                        onclick="return confirm('Are you sure you want to remove this product?');">Remove</a>
                </li>
            <?php endforeach; ?>
        </ul>

        <p><strong>Total Price: $<?php echo number_format($total_price, 2); ?></strong></p>
    <?php endif; ?>

    <p><a href="index.php">Continue Shopping</a></p>
</main>