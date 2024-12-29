<?php
ob_start();
include_once "../includes/db.php";
session_start();
if (isset($_SESSION['role'])) {
  if ($_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
  }
} else {
  header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <script src="./js/ckeditor.js"></script>
  <script src="https://www.gstatic.com/charts/loader.js"></script>
  <title>Admin page</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/sb-admin.css" rel="stylesheet">
  <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>

<body>

<div id="wrapper">