<?php

require '../../includes/auth.php';
require '../../config/koneksi.php';

$cari = $_GET['cari'] ?? '';

$query = $pdo->prepare("
SELECT *
FROM m_produk
WHERE nama_produk LIKE ?
ORDER BY id_produk DESC
");

$query->execute(["%$cari%"]);

$data = $query->fetchAll();

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Data Produk</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins', sans-serif;
    min-height:100vh;
    padding:40px;

    background:
    linear-gradient(
        135deg,
        #fff9e6 0%,
        #fff2b2 45%,
        #ffe08a 100%
    );

    color:#5c4b2d;
}

/* CONTAINER */
.container{
    max-width:1150px;
    margin:auto;
}

/* CARD */
.card{
    background:rgba(255,255,255,0.78);
    backdrop-filter:blur(14px);

    border:1px solid rgba(255,255,255,0.5);

    border-radius:32px;
    padding:35px;

    box-shadow:
    0 10px 35px rgba(255, 208, 90, 0.15);
}

/* TOP HEADER */
.top-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:28px;
    flex-wrap:wrap;
    gap:20px;
}

.title-area h1{
    font-size:32px;
    font-weight:700;
    color:#7a5c1e;
}

.title-area p{
    margin-top:5px;
    color:#9b8550;
    font-size:14px;
}

/* SEARCH */
.search-box{
    display:flex;
    gap:12px;
    margin-bottom:22px;
}

.search-box input{
    flex:1;
    height:54px;
    border:none;
    border-radius:18px;
    padding:0 18px;

    background:#fffdf6;

    font-size:14px;
    color:#6d5524;

    box-shadow:
    inset 0 0 0 1px #f5deb3;

    transition:0.25s;
}

.search-box input:focus{
    outline:none;

    box-shadow:
    0 0 0 4px rgba(255, 217, 102, 0.25);
}

.search-box button{
    border:none;
    padding:0 24px;

    border-radius:18px;

    background:linear-gradient(
        135deg,
        #ffd54f,
        #ffca28
    );

    color:#6b4f00;

    font-weight:600;
    cursor:pointer;

    transition:0.25s;
}

.search-box button:hover{
    transform:translateY(-2px);
}

/* BUTTON TAMBAH */
.btn-add{
    display:inline-flex;
    align-items:center;
    gap:8px;

    margin-bottom:28px;

    padding:14px 22px;

    border-radius:18px;

    background:linear-gradient(
        135deg,
        #ffe082,
        #ffd54f
    );

    color:#6d4c00;

    text-decoration:none;
    font-weight:600;

    box-shadow:
    0 8px 20px rgba(255, 193, 7, 0.18);

    transition:0.25s;
}

.btn-add:hover{
    transform:translateY(-2px);
}

/* TABLE */
.table-wrapper{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:separate;
    border-spacing:0 14px;
}

/* HEADER */
th{
    text-align:left;
    padding:0 16px 12px;

    font-size:13px;
    font-weight:600;
    color:#9c7b31;
}

/* ROW */
td{
    background:#fffdf9;
    padding:18px 16px;

    font-size:14px;
    color:#5c4b2d;
}

/* ROUNDED */
tr td:first-child{
    border-top-left-radius:18px;
    border-bottom-left-radius:18px;
}

tr td:last-child{
    border-top-right-radius:18px;
    border-bottom-right-radius:18px;
}

/* HOVER */
tbody tr{
    transition:0.25s;
}

tbody tr:hover{
    transform:scale(1.01);
}

/* PRICE */
.price{
    font-weight:600;
    color:#c28b00;
}

/* STOCK */
.stock-box{
    display:flex;
    align-items:center;
    gap:8px;
}

/* BADGE */
.badge-kritis{
    background:#ffb3ba;
    color:#8b1e3f;

    padding:5px 10px;
    border-radius:999px;

    font-size:11px;
    font-weight:600;
}

/* ACTION */
.action{
    display:flex;
    gap:10px;
}

/* BUTTON EDIT */
.btn-edit{
    padding:9px 15px;
    border-radius:12px;

    background:#fff1b8;
    color:#8a6700;

    text-decoration:none;
    font-size:13px;
    font-weight:600;

    transition:0.2s;
}

.btn-edit:hover{
    transform:translateY(-1px);
}

/* BUTTON DELETE */
.btn-delete{
    padding:9px 15px;
    border-radius:12px;

    background:#ffd6d6;
    color:#b42318;

    text-decoration:none;
    font-size:13px;
    font-weight:600;

    transition:0.2s;
}

.btn-delete:hover{
    transform:translateY(-1px);
}

/* BACK */
.bottom-action{
    margin-top:28px;
    display:flex;
    justify-content:flex-end;
}

.btn-back{
    padding:13px 22px;

    border-radius:16px;

    background:#fff4cc;
    color:#8a6700;

    text-decoration:none;
    font-weight:600;

    transition:0.25s;
}

.btn-back:hover{
    transform:translateY(-2px);
}

/* EMPTY */
.empty{
    text-align:center;
    padding:40px;
    color:#a38b4d;
}

/* RESPONSIVE */
@media(max-width:768px){

    body{
        padding:20px;
    }

    .card{
        padding:24px;
    }

    .top-header{
        flex-direction:column;
        align-items:flex-start;
    }

    .search-box{
        flex-direction:column;
    }

    .search-box button{
        height:50px;
    }

    .action{
        flex-direction:column;
    }
}

</style>
</head>

<body>

<div class="container">

<div class="card">

    <!-- HEADER -->
    <div class="top-header">

        <div class="title-area">
            <h1>🌼 Data Produk</h1>
            <p>Kelola produk toko maju jaya</p>
        </div>

    </div>

    <!-- SEARCH -->
    <form class="search-box">

        <input
            type="text"
            name="cari"
            placeholder="Cari produk "
            value="<?= htmlspecialchars($cari) ?>"
        >

        <button type="submit">
            Cari
        </button>

    </form>

    <!-- BUTTON -->
    <a class="btn-add" href="tambah.php">
        ✨ Tambah Produk
    </a>

    <!-- TABLE -->
    <div class="table-wrapper">

    <table>

        <thead>
        <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        </thead>

        <tbody>

        <?php if(count($data) > 0): ?>

            <?php foreach($data as $d): ?>

            <tr>

                <td>
                    <strong>
                        <?= htmlspecialchars($d['nama_produk']) ?>
                    </strong>
                </td>

                <td class="price">
                    Rp <?= number_format($d['harga_jual']) ?>
                </td>

                <td>

                    <div class="stock-box">

                        <?= $d['stok'] ?>

                        <?php if($d['stok'] < 5): ?>
                            <span class="badge-kritis">
                                Stok Kritis
                            </span>
                        <?php endif; ?>

                    </div>

                </td>

                <td>

                    <div class="action">

                        <a
                            class="btn-edit"
                            href="edit.php?id=<?= $d['id_produk'] ?>"
                        >
                            Edit
                        </a>

                        <a
                            class="btn-delete"
                            href="hapus.php?id=<?= $d['id_produk'] ?>"
                            onclick="return confirm('Hapus produk?')"
                        >
                            Hapus
                        </a>

                    </div>

                </td>

            </tr>

            <?php endforeach; ?>

        <?php else: ?>

            <tr>
                <td colspan="4">

                    <div class="empty">
                        Produk tidak ditemukan 🌼
                    </div>

                </td>
            </tr>

        <?php endif; ?>

        </tbody>

    </table>

    </div>

    <!-- BACK -->
    <div class="bottom-action">

        <a
            class="btn-back"
            href="../../dashboard_admin.php"
        >
            ← Kembali
        </a>

    </div>

</div>

</div>

</body>
</html>