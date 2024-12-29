<?php
include 'includes/header.php';
include "includes/db.php";
include "stmt.php";

// Kategori ID'sini URL'den alıyoruz
$cat_id = isset($_GET['id']) ? $_GET['id'] : null;

// Kategoriye ait ürünleri alıyoruz
$prod = getProdByCat($cat_id); // getProdByCat fonksiyonu kategoriye göre ürünleri alır

// Kategori adı
$categoryName = '';
if ($cat_id) {
    // Kategoriyi veritabanından alıyoruz
    $categoryName = getCategoryNameById($cat_id); // Bu fonksiyon, kategori adını döndürür
} else {
    $categoryName = "All Products"; // Kategori seçilmemişse, "Tüm Ürünler" göster
}
?>

<main>
    <h1><?php echo htmlspecialchars($categoryName); ?></h1>
    <p>Explore products by category:</p>

    <!-- Ürünleri göster -->
    <div class="main-container">
        <!-- Horizontal Slide Buttons -->
        <button class="slide-btn prev" onclick="navigateSlide('prev')">⬅️</button>
        <div class="product-grid" id="productGrid">
            <?php
            // Eğer ürünler varsa
            if ($prod) {
                $displayedProducts = array_slice($prod, 0, 3); // İlk 3 ürünü al
            
                foreach ($displayedProducts as $product) {
                    echo "<div class='product'>";
                    echo "<img src='images/" . htmlspecialchars($product['image']) . "'>";
                    echo "<h3>" . htmlspecialchars($product['name']) . "</h3>";
                    echo "<p>$" . htmlspecialchars($product['price']) . "</p>";
                    echo "<button>Add to Cart</button>";
                    echo "</div>";
                }
            } else {
                echo "<p>No products available in this category.</p>";
            }
            ?>
        </div>
        <button class="slide-btn next" onclick="navigateSlide('next')">➡️</button>
    </div>
</main>

<script>
    let currentIndex = 0; // Başlangıçta gösterilen ürünlerin index'i

    function navigateSlide(direction) {
        const productGrid = document.getElementById('productGrid');
        const products = <?php echo json_encode($prod); ?>; // PHP'den ürünleri JavaScript'e aktarıyoruz

        if (!productGrid) return;

        // yönlere göre index güncellenmesi
        if (direction === 'prev') {
            currentIndex = (currentIndex - 3 + products.length) % products.length; // 3 ürün kaydırma
        } else if (direction === 'next') {
            currentIndex = (currentIndex + 3) % products.length;
        }

        // Yeni 3 ürünü göstermek için grid'i güncelle
        const displayedProducts = products.slice(currentIndex, currentIndex + 3); // 3 ürün al
        productGrid.innerHTML = ''; // Eski ürünleri temizle

        displayedProducts.forEach(product => {
            const productDiv = document.createElement('div');
            productDiv.classList.add('product');
            productDiv.innerHTML = `
                <img src='images/${product.image}' alt='${product.name}'>
                <h3>${product.name}</h3>
                <p>$${product.price}</p>
                <button>Add to Cart</button>
            `;
            productGrid.appendChild(productDiv);
        });
    }
</script>

<?php include 'includes/footer.php'; ?>