<?php
session_start();
include 'includes/header.php';
include "includes/db.php";
include "stmt.php";

// Kategori ID'sini URL'den al
$cat_id = isset($_GET['id']) ? $_GET['id'] : null;

// Kategoriye ait ürünleri al
$products = getProdByCat($cat_id);

// Kategori adı
$categoryName = $cat_id ? getCategoryNameById($cat_id) : "All Products";
?>

<ma>
    <h1><?php echo htmlspecialchars($categoryName); ?></h1>
    <p>Explore products in this category:</p>

    <!-- Ürün Grid ve Kaydırma Butonları -->
    <div class="main-container">
        <!-- Sol Kaydırma Butonu -->
        <button class="slide-btn prev" onclick="navigateSlide('prev')">⬅️</button>
        <div class="product-grid" id="productGrid">
            <?php if ($products): ?>
            <?php foreach ($products as $product): ?>
            <div class="product">
                <img src="images/<?php echo htmlspecialchars($product['image']); ?>"
                    alt="<?php echo htmlspecialchars($product['name']); ?>">
                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                <p>$<?php echo number_format($product['price'], 2); ?></p>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'user'): ?>
                <!-- Kullanıcılar için Add to Cart butonu -->
                <form action="add_to_cart.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                    <button type="submit">Add to Cart</button>
                </form>
                <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <!-- Adminler için bilgilendirme mesajı -->
                <p><a href="login.php">Log in as market user to add cart</a></p>
                <?php else: ?>
                <!-- Giriş yapmayan kullanıcılar için -->
                <p><a href="login.php">Log in to add to cart</a></p>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p>No products available in this category.</p>
            <?php endif; ?>
        </div>
        <!-- Sağ Kaydırma Butonu -->
        <button class="slide-btn next" onclick="navigateSlide('next')">➡️</button>
    </div>
</ma in>

<script>
let currentIndex = 0;

function navigateSlide(direction) {
    const productGrid = document.getElementById('productGrid');
    const products = <?php echo json_encode($products); ?>;

    if (!productGrid) return;

    if (direction === 'prev') {
        currentIndex = (currentIndex - 3 + products.length) % products.length;
    } else if (direction === 'next') {
        currentIndex = (currentIndex + 3) % products.length;
    }

    const displayedProducts = products.slice(currentIndex, currentIndex + 3);
    productGrid.innerHTML = '';

    displayedProducts.forEach(product => {
        const productDiv = document.createElement('div');
        productDiv.classList.add('product');
        productDiv.innerHTML = `
                <img src="images/${product.image}" alt="${product.name}">
                <h3>${product.name}</h3>
                <p>$${product.price}</p>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'user'): ?>
                                <form action="add_to_cart.php" method="POST">
                                    <input type="hidden" name="product_id" value="${product.id}">
                                    <button type="submit">Add to Cart</button>
                                </form>
                    <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                    <p><a href="login.php">Log in as market user to add cart</a></p>
                    <?php else: ?>
                                <p><a href="login.php">Log in to add to cart</a></p>
                <?php endif; ?>
            `;
        productGrid.appendChild(productDiv);
    });
}
</script>

<?php include 'includes/footer.php'; ?>