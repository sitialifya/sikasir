<?php
require_once __DIR__ . '/../../config/koneksi.php';

$data = $pdo->query("
    SELECT 
        m_produk.nama_produk,
        t_log_stok.qty,
        t_log_stok.jenis,
        t_log_stok.keterangan,
        t_log_stok.waktu_log
    FROM t_log_stok
    INNER JOIN m_produk
        ON t_log_stok.id_produk = m_produk.id_produk
    ORDER BY t_log_stok.waktu_log DESC
")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
<title>Mutasi Stok</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI';
    background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 50%, #fad0c4 100%);
    padding: 40px;
}

.card {
    background: white;
    padding: 30px;
    border-radius: 20px;
    max-width: 1000px;
    margin: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #1e3a8a;
    color: white;
    padding: 12px;
}

td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}

</style>

</head>

<body>

<div class="card">

<h2>📦 Mutasi Stok</h2>
<a href="index.php">← Kembali</a>

<table>
<tr>
    <th>Produk</th>
    <th>Jenis</th>
    <th>Qty</th>
    <th>Keterangan</th>
    <th>Waktu</th>
</tr>

<?php foreach($data as $d): ?>

<tr>
    <td><?= $d['nama_produk'] ?></td>
    <td><?= $d['jenis'] ?></td>
    <td><?= $d['qty'] ?></td>
    <td><?= $d['keterangan'] ?></td>
    <td><?= $d['waktu_log'] ?></td>
</tr>

<?php endforeach; ?>

</table>

</div>

</body>
</html>