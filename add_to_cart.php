<?php
session_start();
include 'includes/db.php';

// Kullanıcı giriş yaptı mı kontrol et
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    echo "<script>alert('You must log in as a user to add products to the cart.'); window.location.href = 'login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];

// Ürün zaten sepette mi kontrol et
$stmt = $db->prepare("SELECT * FROM cart_items WHERE user_id = ? AND product_id = ?");
$stmt->execute([$user_id, $product_id]);
$cart_item = $stmt->fetch(PDO::FETCH_ASSOC);

if ($cart_item) {
    // Ürün zaten sepetteyse, adetini artır
    $stmt = $db->prepare("UPDATE cart_items SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);
} else {
    // Ürün sepette değilse, yeni bir kayıt ekle
    $stmt = $db->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, 1)");
    $stmt->execute([$user_id, $product_id]);
}

header("Location: cart.php");
exit();
?>