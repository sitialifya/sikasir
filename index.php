<?php
session_start();
require '../../config/koneksi.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$produk = $pdo->query("
    SELECT * 
    FROM m_produk 
    ORDER BY nama_produk ASC
")->fetchAll();

$total = 0;

foreach ($_SESSION['cart'] as $item) {
    $total += $item['subtotal'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Transaksi Kasir</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    font-family: 'Poppins', sans-serif;
}

body{
    background: linear-gradient(to bottom right, #FFF8E7, #FFE8B6);
    min-height: 100vh;
}

.main-card{
    border: none;
    border-radius: 28px;
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(8px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.title{
    color: #7A5C2E;
    font-weight: 700;
}

.subtitle{
    color: #A47C48;
    font-size: 14px;
}

.label-text{
    color: #7A5C2E;
    font-weight: 500;
    margin-bottom: 8px;
}

.form-control,
.form-select{
    border-radius: 14px;
    border: 2px solid #F7D58A;
    padding: 12px;
}

.form-control:focus,
.form-select:focus{
    border-color: #E6B85C;
    box-shadow: 0 0 0 0.2rem rgba(230,184,92,0.25);
}

.btn-butter{
    background: linear-gradient(to right, #F6C65B, #F1B944);
    border: none;
    color: #5A3E13;
    font-weight: 600;
    border-radius: 14px;
    transition: 0.3s;
}

.btn-butter:hover{
    transform: translateY(-2px);
    background: linear-gradient(to right, #F1B944, #E9A92E);
    color: #5A3E13;
}

.table-wrapper{
    border-radius: 20px;
    overflow: hidden;
    border: 2px solid #FFE3A2;
}

.table{
    margin-bottom: 0;
}

.table thead{
    background: #FFE08A;
    color: #6A4C1F;
}

.table tbody tr{
    background: #FFFDF8;
}

.table tbody tr:hover{
    background: #FFF3D8;
}

.btn-delete{
    background: #FF8A8A;
    border: none;
    border-radius: 10px;
    color: white;
    padding: 6px 12px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
}

.btn-delete:hover{
    background: #ff6f6f;
    color: white;
}

.total-box{
    background: linear-gradient(to right, #FFF1C9, #FFE4A3);
    border-radius: 22px;
    padding: 25px;
    box-shadow: inset 0 2px 10px rgba(255,255,255,0.6);
}

.total-text{
    color: #6A4C1F;
    font-weight: 700;
}

.empty-cart{
    padding: 25px;
    color: #A58A57;
    font-weight: 500;
}

.badge-cart{
    background: #FFE08A;
    color: #6A4C1F;
    padding: 8px 14px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 600;
}

.section-title{
    color: #7A5C2E;
    font-weight: 600;
}

.btn-back{
    border-radius: 999px;
    padding: 10px 22px;
    font-weight: 500;
}

</style>
</head>

<body>

<div class="container py-5">

<div class="card main-card p-4 p-md-5">

<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

<div>

<h2 class="title mb-1">
🛒 Transaksi Penjualan
</h2>

<p class="subtitle mb-0">
Sistem Kasir Swalayan Maju Jaya
</p>

</div>

<div class="badge-cart mt-3 mt-md-0">
<?= count($_SESSION['cart']) ?> Item
</div>

</div>

<form action="tambah_cart.php" method="POST">

<div class="row g-3">

<div class="col-md-5">

<label class="label-text">
Pilih Barang
</label>

<select name="id_produk" class="form-select" required>

<option value="">
-- Pilih Barang --
</option>

<?php foreach($produk as $p): ?>

<option value="<?= $p['id_produk'] ?>">

<?= $p['nama_produk'] ?>
- Stok <?= $p['stok'] ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="col-md-3">

<label class="label-text">
Jumlah Qty
</label>

<input type="number"
name="qty"
class="form-control"
min="1"
placeholder="Masukkan qty"
required>

</div>

<div class="col-md-4 d-flex align-items-end">

<button class="btn btn-butter w-100 py-3">
+ Tambah ke Keranjang
</button>

</div>

</div>

</form>

<hr class="my-5">

<h5 class="section-title mb-3">
🧾 Keranjang Belanja
</h5>

<div class="table-wrapper">

<table class="table align-middle">

<thead>

<tr>
<th>Barang</th>
<th>Harga</th>
<th>Qty</th>
<th>Subtotal</th>
<th>Aksi</th>
</tr>

</thead>

<tbody>

<?php if(empty($_SESSION['cart'])): ?>

<tr>

<td colspan="5" class="text-center empty-cart">
Keranjang masih kosong 🛍️
</td>

</tr>

<?php endif; ?>

<?php foreach($_SESSION['cart'] as $i => $item): ?>

<tr>

<td>
<b><?= $item['nama_produk'] ?></b>
</td>

<td>
Rp <?= number_format($item['harga_jual']) ?>
</td>

<td>
<?= $item['qty'] ?>
</td>

<td>
<b>
Rp <?= number_format($item['subtotal']) ?>
</b>
</td>

<td>

<a href="hapus_cart.php?index=<?= $i ?>"
class="btn-delete">
Hapus
</a>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

<div class="total-box mt-4">

<div class="d-flex justify-content-between align-items-center flex-wrap mb-3">

<h4 class="total-text mb-2 mb-md-0">
💰 Total Belanja
</h4>

<h3 class="total-text">
Rp <?= number_format($total) ?>
</h3>

</div>

<form action="proses.php" method="POST">

<label class="label-text">
Uang Bayar
</label>

<input type="number"
name="bayar"
class="form-control mb-4"
placeholder="Masukkan uang pembayaran"
required>

<div class="d-flex justify-content-center">

<button class="btn btn-butter px-5 py-2">
✨ Selesaikan Transaksi
</button>

</div>

</form>

<div class="d-flex justify-content-end mt-4">

<a href="../../dashboard_admin.php"
class="btn btn-outline-secondary btn-back">

← Kembali

</a>

</div>

</div>

</div>

</div>

</body>
</html>