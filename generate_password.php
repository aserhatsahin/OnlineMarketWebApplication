<?php
// Şifreleri hash'lemek için PHP kodu

// Kullanıcı adı ve şifreler
$users = [
    ['username' => 'admin', 'password' => 'adminpassword'],
    ['username' => 'user1', 'password' => 'user1password']
];

// Şifreleri hash'le ve yazdır
foreach ($users as $user) {
    $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);
    echo "Username: " . $user['username'] . " - Hashed Password: " . $hashedPassword . "<br>";
}
?>