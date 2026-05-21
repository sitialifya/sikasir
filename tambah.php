<?php
require '../../includes/auth.php';
require '../../config/koneksi.php';

if($_POST){

    $nama = $_POST['nama_produk'];
    $harga = $_POST['harga_jual'];
    $stok = $_POST['stok'];

    if(empty($nama) || empty($harga) || empty($stok)){
        die("Data produk tidak lengkap!");
    }

    if($harga < 0 || $stok < 0){
        die("Harga dan stok tidak boleh negatif!");
    }

    // INSERT PRODUK
    $query = $pdo->prepare("
        INSERT INTO m_produk (nama_produk, harga_jual, stok)
        VALUES (?, ?, ?)
    ");

    $query->execute([$nama, $harga, $stok]);

    $id_produk = $pdo->lastInsertId();

    // LOG STOK
    $log = $pdo->prepare("
        INSERT INTO t_log_stok (id_produk, jumlah, tipe, keterangan)
        VALUES (?, ?, ?, ?)
    ");

    $log->execute([
        $id_produk,
        $stok,
        'Masuk',
        'Stok awal produk'
    ]);

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tambah Produk</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins', sans-serif;
    background:
    linear-gradient(
        135deg,
        #fff9db 0%,
        #ffe8a3 50%,
        #ffd43b 100%
    );

    min-height:100vh;
    padding:40px 20px;
}

/* OVERLAY MODAL STYLE */
.overlay{
    width:100%;
    min-height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;
}

/* CARD */
.card{
    width:100%;
    max-width:430px;

    background:rgba(255,255,255,0.88);

    backdrop-filter:blur(14px);

    border-radius:28px;

    padding:38px;

    box-shadow:
    0 10px 30px rgba(0,0,0,0.08);

    border:1px solid rgba(255,255,255,0.5);

    animation:fadeIn .4s ease;
}

@keyframes fadeIn{
    from{
        opacity:0;
        transform:translateY(15px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* TITLE */
.title{
    text-align:center;
    margin-bottom:28px;
}

.title h2{
    color:#5c3d00;
    font-size:28px;
    margin-bottom:8px;
}

.title p{
    color:#8d6b1f;
    font-size:14px;
}

/* INPUT */
.input-group{
    margin-bottom:18px;
}

.input-group label{
    display:block;
    margin-bottom:8px;
    font-size:14px;
    font-weight:500;
    color:#6b4f00;
}

.input-group input{
    width:100%;
    height:52px;

    border:none;

    border-radius:14px;

    padding:0 16px;

    font-size:14px;

    background:#fffdf4;

    border:2px solid transparent;

    transition:0.3s;
}

.input-group input:focus{
    outline:none;

    border-color:#facc15;

    background:white;

    box-shadow:
    0 0 0 4px rgba(250,204,21,0.18);
}

/* BUTTON */
.btn{
    width:100%;
    height:54px;

    border:none;

    border-radius:16px;

    background:
    linear-gradient(
        135deg,
        #facc15,
        #f59e0b
    );

    color:white;

    font-size:16px;
    font-weight:600;

    cursor:pointer;

    transition:0.3s;

    margin-top:8px;
}

.btn:hover{
    transform:translateY(-2px);

    box-shadow:
    0 10px 20px rgba(245,158,11,0.25);
}

/* BACK */
.back{
    text-align:center;
    margin-top:20px;
}

.back a{
    text-decoration:none;
    color:#8d6b1f;
    font-size:14px;
    font-weight:500;
}

.back a:hover{
    color:#5c3d00;
}

</style>

</head>

<body>

<div class="overlay">

    <div class="card">

        <div class="title">
            <h2>✨ Tambah Produk</h2>
            <p>Tambahkan produk baru ke sistem kasir</p>
        </div>

        <form method="POST">

            <div class="input-group">
                <label>Nama Produk</label>
                <input
                    type="text"
                    name="nama_produk"
                    placeholder="Masukkan nama produk"
                    required
                >
            </div>

            <div class="input-group">
                <label>Harga Jual</label>
                <input
                    type="number"
                    name="harga_jual"
                    placeholder="Masukkan harga jual"
                    required
                >
            </div>

            <div class="input-group">
                <label>Stok Awal</label>
                <input
                    type="number"
                    name="stok"
                    placeholder="Masukkan stok awal"
                    required
                >
            </div>

            <button class="btn" type="submit">
                Simpan Produk
            </button>

        </form>

        <div class="back">
            <a href="index.php">← Kembali</a>
        </div>

    </div>

</div>

</body>
</html>