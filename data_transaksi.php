<?php
session_start();
require '../../config/koneksi.php';

if($_SESSION['role'] != 'Admin'){
    header("Location: ../../nota.php");
    exit;
}

$query = $pdo->query("
    SELECT 
        p.*,
        u.username
    FROM t_penjualan p
    JOIN m_user u
    ON p.id_user = u.id_user
    ORDER BY p.id_penjualan DESC
");

$data = $query->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Data Transaksi</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    font-family:'Poppins',sans-serif;
}

body{
    background: linear-gradient(to bottom right, #FFF8E7, #FFE8B6);
    min-height:100vh;
}

.card-custom{
    background:white;
    border:none;
    border-radius:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.title{
    color:#7A5C2E;
    font-weight:700;
}

.subtitle{
    color:#A47C48;
    font-size:14px;
}

.table{
    overflow:hidden;
    border-radius:20px;
}

.table thead{
    background:#FFE08A;
    color:#6A4C1F;
}

.table tbody tr:hover{
    background:#FFF7E3;
}

.btn-detail{
    background:#F6C65B;
    color:#5A3E13;
    border:none;
    border-radius:10px;
    padding:8px 14px;
    text-decoration:none;
    font-size:13px;
    font-weight:600;
}

.btn-detail:hover{
    background:#ECB84A;
    color:#5A3E13;
}

.btn-back{
    background:#E7D3A7;
    color:#6A4C1F;
    border:none;
    border-radius:12px;
    padding:10px 18px;
    text-decoration:none;
    font-weight:600;
}

.btn-back:hover{
    background:#dcbf84;
    color:#6A4C1F;
}

</style>
</head>

<body>

<div class="container py-5">

<div class="card card-custom p-4">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>
<h2 class="title mb-1">
📊 Data Transaksi
</h2>

<p class="subtitle mb-0">
Riwayat transaksi penjualan Swalayan Maju Jaya
</p>
</div>

<a href="../../dashboard_admin.php" class="btn-back">
← Kembali
</a>

</div>

<div class="table-responsive">

<table class="table align-middle">

<thead>
<tr>
<th>No Nota</th>
<th>Tanggal</th>
<th>Kasir</th>
<th>Total</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

<?php if(empty($data)): ?>

<tr>
<td colspan="5" class="text-center py-4">
Belum ada transaksi
</td>
</tr>

<?php endif; ?>

<?php foreach($data as $d): ?>

<tr>

<td>
<?= $d['nomor_nota'] ?>
</td>

<td>
<?= $d['tgl_transaksi'] ?>
</td>

<td>
<?= $d['username'] ?>
</td>

<td>
Rp <?= number_format($d['total_bayar']) ?>
</td>

<td>

<a href="nota.php?id=<?= $d['id_penjualan'] ?>"
class="btn-detail">

Detail Nota

</a>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

</div>

</div>

</body>
</html>