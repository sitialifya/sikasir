<?php
session_start();
require_once __DIR__ . '/../../config/koneksi.php';

$totalProduk = $pdo->query("SELECT COUNT(*) FROM m_produk")->fetchColumn();
$totalStok = $pdo->query("SELECT SUM(stok) FROM m_produk")->fetchColumn();
$stokKritis = $pdo->query("SELECT COUNT(*) FROM m_produk WHERE stok < 5")->fetchColumn();

$penjualanHariIni = $pdo->query("
    SELECT COALESCE(SUM(total_bayar),0)
    FROM t_penjualan
    WHERE DATE(tgl_transaksi) = CURDATE()
")->fetchColumn();

$bestSeller = $pdo->query("
    SELECT p.nama_produk, SUM(d.qty) AS total_terjual
    FROM t_penjualan_detail d
    JOIN m_produk p ON p.id_produk = d.id_produk
    GROUP BY d.id_produk
    ORDER BY total_terjual DESC
    LIMIT 5
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard Laporan</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>

            body{
                margin:0;
                font-family:'Segoe UI', sans-serif;
                background: linear-gradient(135deg,#fff7c2,#ffeaa7,#fff3b0);
            }

            /* HEADER */
            .header-box{
                background:#ffffff;
                padding:18px 22px;
                border-radius:16px;
                box-shadow:0 8px 25px rgba(0,0,0,0.06);
            }

            /* CARD */
            .card-box{
                background:#ffffff;
                border:none;
                border-radius:18px;
                box-shadow:0 10px 25px rgba(0,0,0,0.08);
                transition:0.25s;
            }

            .card-box:hover{
                transform:translateY(-4px);
            }

            /* NUMBER */
            .big-number{
                font-size:28px;
                font-weight:800;
                color:#5a4a1f;
            }

            /* TITLE */
            h4,h5,h6{
                color:#5a4a1f;
            }

            /* BUTTON */
            .btn-back{
                background:linear-gradient(135deg,#f4c542,#f6d365);
                color:#2b2b2b;
                border:none;
                padding:10px 16px;
                border-radius:12px;
                font-weight:600;
                text-decoration:none;
            }

            .btn-back:hover{
                transform:translateY(-2px);
            }

            /* TABLE */
            .table{
                border-radius:12px;
                overflow:hidden;
            }

            .table thead{
                background:#fff3b0;
                color:#5a4a1f;
            }

            .table tbody tr:hover{
                background:#fff8d6;
            }

        </style>
    </head>

    <body>

        <div class="container mt-4">

            <!-- HEADER -->
            <div class="header-box d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">📊 Dashboard Laporan & Analytics</h4>

                <a href="../../dashboard_admin.php" class="btn-back">
                    ⬅ Kembali
                </a>
            </div>

            <!-- STATS -->
            <div class="row g-3">

                <div class="col-md-3">
                    <div class="card card-box p-3 text-center">
                        <h6>Total Produk</h6>
                        <div class="big-number"><?= $totalProduk ?></div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-box p-3 text-center">
                        <h6>Total Stok</h6>
                        <div class="big-number"><?= $totalStok ?></div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-box p-3 text-center">
                        <h6>Penjualan Hari Ini</h6>
                        <div class="big-number">
                            Rp <?= number_format($penjualanHariIni,0,',','.') ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-box p-3 text-center">
                        <h6>Stok Kritis</h6>
                        <div class="big-number text-danger"><?= $stokKritis ?></div>
                    </div>
                </div>

            </div>

            <!-- BEST SELLER -->
            <div class="mt-4">
                <div class="card card-box p-4">

                    <h5 class="mb-3">🏆 Best Seller Produk</h5>

                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Total Terjual</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($bestSeller as $b): ?>
                            <tr>
                                <td><?= htmlspecialchars($b['nama_produk']) ?></td>
                                <td><b><?= $b['total_terjual'] ?></b></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </body>
</html>