<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>SIKASIR</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f3f4f6;
}

.navbar{
    background:#14532d;
}

.navbar a{
    color:white !important;
}

.card-box{
    background:white;
    padding:25px;
    border-radius:15px;
    box-shadow:0 0 10px rgba(0,0,0,.1);
}

</style>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark px-4">

<a class="navbar-brand" href="#">
    SIKASIR
</a>

<div class="ms-auto d-flex gap-3">

<a href="../../models/produk/index.php">
    Produk
</a>

<a href="../../models/laporan/penjualan.php">
    Laporan
</a>

<a href="../../auth/logout.php">
    Logout
</a>

</div>

</nav>

<div class="container mt-4">