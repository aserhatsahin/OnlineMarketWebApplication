<?php
session_start();
session_unset();  // Tüm session değişkenlerini temizler
session_destroy();  // Session'ı sonlandırır

// Çıkış yaptıktan sonra anasayfaya yönlendir
header("Location: index.php");
exit;
?>