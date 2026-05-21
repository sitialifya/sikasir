<?php

session_start();
require '../../config/koneksi.php';

$id = $_GET['id'];

// cek user
$cek = $pdo->prepare("
    SELECT *
    FROM m_user
    WHERE id_user = ?
");

$cek->execute([$id]);

$user = $cek->fetch();

// kalau admin jangan dihapus
if ($user['role'] == 'Admin') {

    echo "
    <script>
        alert('Admin tidak boleh dihapus');
        window.location='index.php';
    </script>
    ";

    exit;
}

// cek apakah user punya transaksi
$transaksi = $pdo->prepare("
    SELECT COUNT(*)
    FROM t_penjualan
    WHERE id_user = ?
");

$transaksi->execute([$id]);

if ($transaksi->fetchColumn() > 0) {

    echo "
    <script>
        alert('User masih terikat transaksi');
        window.location='index.php';
    </script>
    ";

    exit;
}

// hapus user
$hapus = $pdo->prepare("
    DELETE FROM m_user
    WHERE id_user = ?
");

$hapus->execute([$id]);

echo "
<script>
    alert('User berhasil dihapus');
    window.location='index.php';
</script>
";
?>