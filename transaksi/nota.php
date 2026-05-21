<?php
session_start();
require '../../config/koneksi.php';

/*AMBIL ID TRANSAKSI*/
$id_penjualan = null;

/* dari URL admin */
if(isset($_GET['id'])){
    $id_penjualan = $_GET['id'];
}

/* dari session kasir */
elseif(isset($_SESSION['nota']['id_penjualan'])){
    $id_penjualan = $_SESSION['nota']['id_penjualan'];
}

if(!$id_penjualan){
    die("ID transaksi tidak ditemukan");
}
/*HEADER TRANSAKSI*/
$query = $pdo->prepare("
    SELECT 
        p.*,
        u.username
    FROM t_penjualan p
    JOIN m_user u
    ON p.id_user = u.id_user
    WHERE p.id_penjualan = ?
");

$query->execute([$id_penjualan]);

$nota = $query->fetch();

if(!$nota){
    die("Data transaksi tidak ditemukan");
}

/*DETAIL TRANSAKSI*/
$detail = $pdo->prepare("
    SELECT 
        d.*,
        pr.nama_produk
    FROM t_penjualan_detail d
    JOIN m_produk pr
    ON d.id_produk = pr.id_produk
    WHERE d.id_penjualan = ?
");

$detail->execute([$id_penjualan]);

$items = $detail->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Nota Penjualan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    font-family:'Poppins',sans-serif;
}

body{
    background:
    linear-gradient(to bottom right,#FFF8E7,#FFE8B6);
    min-height:100vh;
}

.nota-card{
    max-width:520px;
    margin:auto;
    background:white;
    border-radius:28px;
    padding:35px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
}

.logo{
    font-size:32px;
    font-weight:700;
    color:#7A5C2E;
}

.subtitle{
    color:#A47C48;
    font-size:14px;
}

.line{
    border-top:2px dashed #E6C87C;
    margin:18px 0;
}

.table thead{
    background:#FFE08A;
}

.total-box{
    background:#FFF3D4;
    border-radius:18px;
    padding:18px;
}

.btn-print{
    background:#F6C65B;
    border:none;
    color:#5A3E13;
    font-weight:600;
    border-radius:12px;
    padding:12px;
    width:100%;
}

.btn-print:hover{
    background:#ECB84A;
}

.btn-back{
    background:#E7D3A7;
    border:none;
    color:#6A4C1F;
    font-weight:600;
    border-radius:12px;
    padding:12px;
    width:100%;
    text-decoration:none;
    display:block;
    text-align:center;
    margin-top:10px;
}

</style>
</head>

<body>

<div class="container py-5">

<div class="nota-card">

<div class="text-center">

<div class="logo">
🧈 ButterKasir
</div>

<div class="subtitle">
Toko Swalayan Maju Jaya
</div>

</div>

<div class="line"></div>

<p class="mb-1">
<b>No Nota:</b>
<?= $nota['nomor_nota'] ?>
</p>

<p class="mb-1">
<b>Tanggal:</b>
<?= $nota['tgl_transaksi'] ?>
</p>

<p class="mb-0">
<b>Kasir:</b>
<?= $nota['username'] ?>
</p>

<div class="line"></div>

<div class="table-responsive">

<table class="table align-middle">

<thead>
<tr>
<th>Barang</th>
<th>Qty</th>
<th>Subtotal</th>
</tr>
</thead>

<tbody>

<?php foreach($items as $item): ?>

<tr>

<td>
<?= $item['nama_produk'] ?>
</td>

<td>
<?= $item['qty'] ?>
</td>

<td>
Rp <?= number_format($item['subtotal'],0,',','.') ?>
</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

<div class="total-box">

<h5>
Total :
Rp <?= number_format($nota['total_bayar'],0,',','.') ?>
</h5>

</div>

<div class="text-center mt-4 mb-3">
✨ Terima kasih sudah berbelanja ✨
</div>

<button onclick="window.print()" class="btn-print">
🖨️ Print Nota
</button>

<a href="index.php" class="btn-back">
← Kembali
</a>

</div>

</div>

</body>
</html>