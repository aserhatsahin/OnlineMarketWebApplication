<?php
session_start();

// Admin mi kontrol et
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

include 'includes/db.php';

// Ürün ekleme formu gönderildi mi?
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $image = $_FILES['image']['name'];

    // Dosyayı yükleme işlemi (resim)
    $targetDir = "images/";
    $targetFile = $targetDir . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);

    // Veritabanına yeni ürünü ekle
    $stmt = $db->prepare("INSERT INTO products (name, description, price, image, category_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $description, $price, $image, $category_id]);

    echo "Product added successfully!";
}
?>
<link rel="stylesheet" href="assets/styles.css">
<!-- Ürün ekleme formu -->
<form method="POST" action="add_product.php" enctype="multipart/form-data">
    <label for="name">Product Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="description">Description:</label>
    <textarea id="description