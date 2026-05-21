<?php
require_once __DIR__ . '/../../config/koneksi.php';

$query = $pdo->query("
    SELECT 
        p.nomor_nota,
        p.tgl_transaksi,
        p.total_bayar,
        u.username
    FROM t_penjualan p
    INNER JOIN m_user u
        ON p.id_user = u.id_user
    ORDER BY p.tgl_transaksi DESC
");

$data = $query->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
<title>Laporan Penjualan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-4">

<div class="d-flex justify-content-between mb-3">
    <h4>📦 Laporan Penjualan Harian</h4>
    <a href="index.php" class="btn btn-secondary">Kembali</a>
</div>

<table class="table table-striped table-bordered bg-white">
<thead class="table-dark">
<tr>
<th>No</th>
<th>Nota</th>
<th>Tanggal</th>
<th>Kasir</th>
<th>Total</th>
</tr>
</thead>

<tbody>
<?php $no=1; foreach($data as $d): ?>
<tr>
<td><?= $no++ ?></td>
<td><?= $d['nomor_nota'] ?></td>
<td><?= $d['tgl_transaksi'] ?></td>
<td><?= $d['username'] ?></td>
<td>Rp <?= number_format($d['total_bayar'],0,',','.') ?></td>
</tr>
<?php endforeach; ?>
</tbody>

</table>

</div>

</body>
</html>