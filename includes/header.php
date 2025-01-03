<header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="categories.php">Categories</a></li>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'user'): ?>
            <!-- Sadece kullanıcılar için Cart bağlantısını göster -->
            <li><a href="cart.php">Cart</a></li>
            <?php endif; ?>

            <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Kullanıcı giriş yaptıysa -->
            <li><a href="logout.php">Logout</a></li>

            <?php if ($_SESSION['role'] === 'admin'): ?>
            <!-- Adminse, Dashboard butonunu göster -->
            <li><a href="admin/dashboard.php">Dashboard</a></li>
            <?php endif; ?>
            <?php else: ?>
            <!-- Kullanıcı giriş yapmamışsa -->
            <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>