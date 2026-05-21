<?php
session_start();
require '../../config/koneksi.php';

$id_produk = $_POST['id_produk'];
$qty = $_POST['qty'];

$stmt = $pdo->prepare("SELECT * FROM m_produk WHERE id_produk=?");
$stmt->execute([$id_produk]);

$produk = $stmt->fetch();

if($qty > $produk['stok']){
    echo "
    <script>
    alert('Stok tidak cukup!');
    window.location='index.php';
    </script>
    ";
    exit;
}

$_SESSION['cart'][] = [
    'id_produk' => $produk['id_produk'],
    'nama_produk' => $produk['nama_produk'],
    'harga_jual' => $produk['harga_jual'],
    'qty' => $qty,
    'subtotal' => $produk['harga_jual'] * $qty
];

header("Location:index.php");
?>