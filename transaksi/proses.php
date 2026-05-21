<?php
session_start();
require '../../config/koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$cart = $_SESSION['cart'] ?? [];
$bayar = $_POST['bayar'] ?? 0;

if (empty($cart)) {
    die("Keranjang kosong!");
}

$total = 0;

foreach ($cart as $item) {
    $total += $item['subtotal'];
}

/*VALIDASI PEMBAYARAN*/

if ($bayar < $total) {
    die("Uang bayar kurang!");
}

try {

    /*START TRANSACTION*/
    $pdo->beginTransaction();

    /*CEK STOK TERAKHIR*/
    foreach ($cart as $item) {

        $cek = $pdo->prepare("
            SELECT stok, nama_produk
            FROM m_produk
            WHERE id_produk = ?
        ");

        $cek->execute([$item['id_produk']]);

        $produk = $cek->fetch(PDO::FETCH_ASSOC);

        if (!$produk) {
            throw new Exception("Produk tidak ditemukan!");
        }

        if ($produk['stok'] < $item['qty']) {

            throw new Exception(
                "Stok produk {$produk['nama_produk']} tidak mencukupi!"
            );
        }
    }

    /*GENERATE NOMOR NOTA*/
    $nomor_nota = "PJN-" . date("YmdHis");

    /*INSERT HEADER PENJUALAN*/
    $insert = $pdo->prepare("
        INSERT INTO t_penjualan
        (
            nomor_nota,
            tgl_transaksi,
            total_bayar,
            id_user
        )
        VALUES
        (
            ?, ?, ?, ?
        )
    ");

    $insert->execute([
        $nomor_nota,
        date('Y-m-d H:i:s'),
        $total,
        $_SESSION['id_user']
    ]);

    $id_penjualan = $pdo->lastInsertId();

    /*LOOP DETAIL TRANSAKSI*/
    foreach ($cart as $item) {
        /*INSERT DETAIL PENJUALAN*/
        $detail = $pdo->prepare("
            INSERT INTO t_penjualan_detail
            (
                id_penjualan,
                id_produk,
                qty,
                subtotal
            )
            VALUES
            (
                ?, ?, ?, ?
            )
        ");

        $detail->execute([
            $id_penjualan,
            $item['id_produk'],
            $item['qty'],
            $item['subtotal']
        ]);

        /*UPDATE STOK*/

        $update = $pdo->prepare("
            UPDATE m_produk
            SET stok = stok - ?
            WHERE id_produk = ?
        ");

        $update->execute([
            $item['qty'],
            $item['id_produk']
        ]);

        /*INSERT LOG STOK*/

        $log = $pdo->prepare("
            INSERT INTO t_log_stok
            (
                id_produk,
                jumlah,
                tipe,
                keterangan
            )
            VALUES
            (
                ?, ?, ?, ?
            )
        ");

        $log->execute([
            $item['id_produk'],
            $item['qty'],
            'Keluar',
            'Penjualan Nota ' . $nomor_nota
        ]);
    }

    /*COMMIT TRANSACTION*/
    $pdo->commit();

    /*SIMPAN DATA NOTA KE SESSION*/

    $_SESSION['nota'] = [
        'id_penjualan' => $id_penjualan,
        'nomor_nota'   => $nomor_nota,
        'items'        => $cart,
        'total'        => $total,
        'bayar'        => $bayar,
        'kembalian'    => $bayar - $total
    ];

    /*KOSONGKAN CART*/

    $_SESSION['cart'] = [];

    /*REDIRECT KE HALAMAN NOTA*/

    header("Location: nota.php");
    exit;

} catch (Exception $e) {

    /*ROLLBACK JIKA ERROR*/
    $pdo->rollBack();

    echo "
    <script>
        alert('Transaksi gagal: {$e->getMessage()}');
        window.location='index.php';
    </script>
    ";
}
?>