<?php
include "includes/db.php";

//getting all Products
function getAllProd()
{
  global $db;
  $qr = "SELECT * FROM  products ";
  $stmt = $db->query($qr);


  $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

  return $products;



}
// Kategoriye ait ürünleri al
function getProdByCat($cat_id = null)
{
  global $db;

  // Eğer kategori ID'si varsa, o kategoriye ait ürünleri al
  if ($cat_id) {
    $qr = "SELECT * FROM products WHERE category_id = ?";
    $stmt = $db->prepare($qr);
    $stmt->execute([$cat_id]);
  } else {
    // Eğer kategori seçilmemişse, tüm ürünleri al
    $qr = "SELECT * FROM products";
    $stmt = $db->prepare($qr);
    $stmt->execute();
  }

  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getAllCategories()
{

  global $db;

  $qr = "SELECT * FROM categories";
  $stmt = $db->query($qr);
  $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);


  return $categories;


}
// Kategori adı almak için fonksiyon
function getCategoryNameById($cat_id)
{
  global $db;

  $qr = "SELECT name FROM categories WHERE id = ?";
  $stmt = $db->prepare($qr);
  $stmt->execute([$cat_id]);

  $category = $stmt->fetch(PDO::FETCH_ASSOC);
  return $category ? $category['name'] : 'Unknown Category';
}




?>