<?php
session_start();
include_once 'includes/db.php';

// Giriş formu gönderildi mi kontrol et
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Kullanıcıyı veritabanından al
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $password === $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: admin/dashboard.php");
        } elseif ($user['role'] === 'user') {
            header("Location: index.php");
        }
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link href="assets/styles.css" rel="stylesheet">
    </head>

    <body>
        <div class="login-container">
            <h4>Login</h4>
            <form action="login.php" method="POST">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Enter Username" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit" name="login">
                        Login
                    </button>
                </div>
            </form>

            <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>
        </div>
    </body>

</html>