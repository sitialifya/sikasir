<?php
require '../../includes/auth.php';
require '../../config/koneksi.php';

$id = $_GET['id'];

$data = $pdo->prepare("
    SELECT *
    FROM m_produk
    WHERE id_produk=?
");

$data->execute([$id]);

$produk = $data->fetch();

if($_POST){

    $nama = $_POST['nama_produk'];
    $harga = $_POST['harga_jual'];
    $stok = $_POST['stok'];
    $ket = $_POST['keterangan'];

    $update = $pdo->prepare("
        UPDATE m_produk
        SET
        nama_produk=?,
        harga_jual=?,
        stok=?
        WHERE id_produk=?
    ");

    $update->execute([
        $nama,
        $harga,
        $stok,
        $id
    ]);

    $log = $pdo->prepare("
        INSERT INTO t_log_stok
        (
            id_produk,
            jenis,
            qty,
            keterangan
        )
        VALUES(?,?,?,?)
    ");

    $log->execute([
        $id,
        'MASUK',
        $stok,
        $ket
    ]);

    header("Location: index.php");

}
?>

<form method="POST">

<input type="text"
       name="nama_produk"
       value="<?= $produk['nama_produk'] ?>">

<br><br>

<input type="number"
       name="harga_jual"
       value="<?= $produk['harga_jual'] ?>">

<br><br>

<input type="number"
       name="stok"
       value="<?= $produk['stok'] ?>">

<br><br>

<textarea name="keterangan"></textarea>

<br><br>

<button>
    Update
</button>

</form>