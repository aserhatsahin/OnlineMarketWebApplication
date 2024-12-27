<?php
session_start();

// "Remember Me" özelliği kontrolü
if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
    // Cookie'den kullanıcıyı doğrula
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['username'] = $_COOKIE['username'];
}
?>