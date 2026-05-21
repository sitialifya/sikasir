<?php
require_once __DIR__ . '/../../config/koneksi.php';

$query = $pdo->query("
    SELECT 
        p.nama_produk,
        SUM(d.qty) AS total_terjual,
        SUM(d.qty * d.harga) AS total_pendapatan
    FROM t_penjualan_detail d
    INNER JOIN m_produk p
        ON d.id_produk = p.id_produk
    INNER JOIN t_penjualan j
        ON d.id_penjualan = j.id_penjualan
    GROUP BY d.id_produk
    ORDER BY total_terjual DESC
    LIMIT 10
");

$data = $query->fetchAll();
?>

<!DOCTYPE html>
<html>
    <head>
    <title>Best Seller</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body class="bg-light">

        <div class="container mt-4">

            <div class="d-flex justify-content-between mb-3">
                <h4>🔥 Best Seller Produk</h4>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </div>

            <table class="table table-bordered table-striped bg-white">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Total Terjual</th>
                        <th>Pendapatan</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $no=1; foreach($data as $d): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $d['nama_produk'] ?></td>
                        <td><?= $d['total_terjual'] ?></td>
                        <td>Rp <?= number_format($d['total_pendapatan'],0,',','.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>

        </div>

    </body>
</html>