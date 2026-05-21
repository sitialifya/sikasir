<?php
require '../../includes/auth.php';
require '../../config/koneksi.php';

$id = $_GET['id'];

$cek = $pdo->prepare("
SELECT COUNT(*)
FROM t_penjualan_detail
WHERE id_produk=?
");

$cek->execute([$id]);

if($cek->fetchColumn() > 0){

    die("Produk tidak bisa dihapus karena sudah ada transaksi.");

}

$hapus = $pdo->prepare("
DELETE FROM m_produk
WHERE id_produk=?
");

$hapus->execute([$id]);

header("Location: index.php");