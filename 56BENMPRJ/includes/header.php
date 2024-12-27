<header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="contact.php">Contact</a></li>

            <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Kullanıcı giriş yaptıysa -->
            <li><a href="logout.php">Logout</a></li>
            <li><a href="myCart.php">My Cart</a></li>

            <?php if ($_SESSION['role'] === 'admin'): ?>
            <!-- Adminse, Add Product butonunu göster -->
            <li><a href="add_product.php">Add Market Item</a></li>
            <?php endif; ?>

            <?php else: ?>
            <!-- Kullanıcı giriş yapmamışsa -->
            <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>