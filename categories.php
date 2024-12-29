<?php
include 'includes/header.php';
include "stmt.php";
?>

<main>
    <h1>Product Categories</h1>
    <p>Explore products by category:</p>

    <section class="categories">
        <ul>
            <?php
            // Kategorileri veritabanından alıyoruz
            $categories = getAllCategories(); // Bu fonksiyon kategorileri alır
            
            // Kategorileri döngü ile listele
            foreach ($categories as $category) {
                echo "<li><a href='index.php?id=" . htmlspecialchars($category['id']) . "'>" . htmlspecialchars($category['name']) . "</a></li>";
            }
            ?>
        </ul>
    </section>
</main>

<?php include 'includes/footer.php'; ?>