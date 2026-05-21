<?php 
session_start();
require_once 'config/koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: auth/login.php");
    exit;
}

if ($_SESSION['role'] != 'Admin') {
    header("Location: models/transaksi/index.php");
    exit;
}

/*TOTAL PRODUK*/
$totalProduk = $pdo->query("
    SELECT COUNT(id_produk)
    FROM m_produk
")->fetchColumn();

/*TOTAL STOK*/
$totalStok = $pdo->query("
    SELECT COALESCE(SUM(stok),0)
    FROM m_produk
")->fetchColumn();

/*STOK KRITIS*/
$stokKritis = $pdo->query("
    SELECT COUNT(*)
    FROM m_produk
    WHERE stok < 5
")->fetchColumn();

/*TOTAL KASIR AKTIF HARI INI*/
$totalKasir = $pdo->query("
    SELECT COUNT(DISTINCT id_user)
    FROM t_penjualan
    WHERE DATE(tgl_transaksi) = CURDATE()
")->fetchColumn();

/*TOTAL PENJUALAN HARI INI*/
$penjualanHariIni = $pdo->query("
    SELECT COALESCE(SUM(total_bayar),0)
    FROM t_penjualan
    WHERE DATE(tgl_transaksi) = CURDATE()
")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard Admin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

body{
    background:
    linear-gradient(
        135deg,
        #FFFDF5 0%,
        #FFF4C7 45%,
        #FFE8A3 100%
    );

    min-height:100vh;
}

/* SIDEBAR */

.sidebar{
    position:fixed;
    top:0;
    left:0;
    width:270px;
    height:100vh;

    background:rgba(255,255,255,0.82);

    backdrop-filter:blur(15px);

    padding:30px 22px;

    border-right:1px solid rgba(255,255,255,0.5);

    box-shadow:
    0 10px 35px rgba(0,0,0,0.05);
}

.brand{
    margin-bottom:40px;
}

.brand h2{
    font-size:30px;
    font-weight:700;

    background:
    linear-gradient(
        135deg,
        #F7B733,
        #FCB045
    );

    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

.brand p{
    color:#9B7B2F;
    font-size:13px;
    margin-top:5px;
}

/* MENU */

.menu-title{
    font-size:12px;
    color:#B28B2F;
    margin-bottom:12px;
    letter-spacing:1px;
}

.sidebar-link{
    display:flex;
    align-items:center;
    gap:12px;
    padding:14px 16px;
    border-radius:18px;
    text-decoration:none;
    color:#5F4A12;
    font-size:15px;
    font-weight:500;
    margin-bottom:10px;
    transition:0.25s;
}

.sidebar-link:hover{
    background:#FFF2BA;
    transform:translateX(5px);
    color:#5F4A12;
}

.sidebar-link i{
    font-size:18px;
}

.sidebar-active{
    background:
    linear-gradient(
        135deg,
        #FFE082,
        #FFD54F
    );
    color:#5F4300;
}

/* LOGOUT */

.logout{
    position:absolute;
    bottom:30px;
    width:84%;
    background:#FFF5DA;
}

/* MAIN */

.main{
    margin-left:270px;
    padding:35px;
}

/* TOPBAR */

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:35px;
}

.welcome h3{
    font-size:30px;
    font-weight:700;
    color:#5B4300;
}

.welcome p{
    color:#9B7B2F;
    margin-top:5px;
}

/* BUTTON */

.btn-refresh{
    border:none;
    padding:12px 20px;
    border-radius:16px;
    text-decoration:none;
    color:#5F4300;
    font-weight:600;
    background:
    linear-gradient(
        135deg,
        #FFE082,
        #FFD54F
    );
    transition:0.25s;
}

.btn-refresh:hover{
    transform:translateY(-2px);
    box-shadow:
    0 8px 20px rgba(255,193,7,0.25);
    color:#5F4300;
}

/* CARD */

.card-box{
    background:rgba(255,255,255,0.82);
    backdrop-filter:blur(10px);
    border:none;
    border-radius:28px;
    padding:28px;
    height:100%;
    position:relative;
    overflow:hidden;
    transition:0.3s;
    box-shadow:
    0 10px 30px rgba(0,0,0,0.05);
}

.card-box:hover{
    transform:translateY(-5px);
}

.card-box::before{
    content:'';
    position:absolute;
    top:-40px;
    right:-40px;
    width:120px;
    height:120px;
    background:rgba(255,214,102,0.2);
    border-radius:50%;
}

/* ICON */

.card-icon{
    width:58px;
    height:58px;
    border-radius:18px;
    display:flex;
    justify-content:center;
    align-items:center;
    margin-bottom:18px;
    font-size:23px;
    background:
    linear-gradient(
        135deg,
        #FFE082,
        #FFD54F
    );

    color:#5F4300;
}

.card-title{
    font-size:14px;
    color:#9B7B2F;
    margin-bottom:6px;
}

.card-value{
    font-size:30px;
    font-weight:700;
    color:#4B3900;
}

/* BOTTOM */

.bottom-grid{
    margin-top:30px;
}

.alert-card{
    background:rgba(255,255,255,0.82);
    border-radius:28px;
    padding:25px;
    box-shadow:
    0 10px 30px rgba(0,0,0,0.05);
}

.alert-card h5{
    color:#5F4300;
    margin-bottom:12px;
}

.alert-box{
    background:#FFF4C4;
    border-radius:18px;
    padding:18px;
    color:#6B5200;
    font-size:15px;
}

/* PROFILE */

.profile-card{
    background:
    linear-gradient(
        135deg,
        #FFD54F,
        #FFEC99
    );

    border-radius:28px;
    padding:28px;
    color:#5F4300;
    height:100%;
}

.profile-avatar{
    width:75px;
    height:75px;
    border-radius:50%;
    background:white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:32px;
}

.profile-card h4{
    font-weight:700;
    margin-top:18px;
}

.profile-card p{
    margin-top:10px;
    line-height:1.7;
}

/* RESPONSIVE */

@media(max-width:992px){

    .sidebar{
        width:100%;
        height:auto;
        position:relative;
    }

    .logout{
        position:relative;
        bottom:auto;
        width:100%;
        margin-top:15px;
    }

    .main{
        margin-left:0;
    }

    .topbar{
        flex-direction:column;
        align-items:flex-start;
        gap:15px;
    }

}

</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="brand">
        <h2>SI KASIR</h2>
        <p>Toko Swalayan Maju Jaya ✨</p>
    </div>

    <div class="menu-title">
        MENU UTAMA
    </div>

    <a class="sidebar-link sidebar-active" href="dashboard_admin.php">
        <i class="bi bi-grid-fill"></i>
        Dashboard
    </a>

    <a class="sidebar-link" href="models/produk/index.php">
        <i class="bi bi-box-seam"></i>
        Kelola Produk
    </a>

    <!-- DIUBAH KE DATA TRANSAKSI -->
    <a class="sidebar-link" href="models/transaksi/data_transaksi.php">
        <i class="bi bi-receipt"></i>
        Data Transaksi
    </a>

    <a class="sidebar-link" href="models/laporan/index.php">
        <i class="bi bi-bar-chart-fill"></i>
        Laporan
    </a>

    <a class="sidebar-link" href="models/user/index.php">
        <i class="bi bi-people-fill"></i>
        Kelola User
    </a>

    <a href="auth/logout.php" class="sidebar-link logout text-danger">
        <i class="bi bi-box-arrow-right"></i>
        Logout
    </a>

</div>

<!-- MAIN -->
<div class="main">

    <!-- TOPBAR -->
    <div class="topbar">

        <div class="welcome">

            <h3>
                Hi, <?= htmlspecialchars($_SESSION['username']) ?> 👋
            </h3>

            <p>
                Selamat datang di dashboard admin SI KASIR ✨
            </p>

        </div>

        <a href="dashboard_admin.php" class="btn-refresh">
            ⟳ Refresh
        </a>

    </div>

    <!-- CARDS -->
    <div class="row g-4">

        <div class="col-md-3">

            <div class="card-box">

                <div class="card-icon">
                    📦
                </div>

                <div class="card-title">
                    Total Produk
                </div>

                <div class="card-value">
                    <?= $totalProduk ?>
                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card-box">

                <div class="card-icon">
                    📊
                </div>

                <div class="card-title">
                    Total Stok
                </div>

                <div class="card-value">
                    <?= $totalStok ?>
                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card-box">

                <div class="card-icon">
                    💰
                </div>

                <div class="card-title">
                    Penjualan Hari Ini
                </div>

                <div class="card-value" style="font-size:22px;">
                    Rp <?= number_format($penjualanHariIni,0,',','.') ?>
                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card-box">

                <div class="card-icon">
                    👩
                </div>

                <div class="card-title">
                    Kasir Aktif
                </div>

                <div class="card-value">
                    <?= $totalKasir ?>
                </div>

            </div>

        </div>

    </div>

    <!-- BOTTOM -->
    <div class="row g-4 bottom-grid">

        <div class="col-lg-8">

            <div class="alert-card">

                <h5>
                    📢 Informasi Stok
                </h5>

                <div class="alert-box">

                    ⚠️ Saat ini ada

                    <b><?= $stokKritis ?></b>

                    produk dengan stok kritis dan perlu segera direstock.

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="profile-card">

                <div class="profile-avatar">
                    👩
                </div>

                <h4>
                    Admin Panel
                </h4>

                <p>
                    Kelola produk, laporan penjualan, data transaksi, dan user toko dengan tampilan yang nyaman, rapi, dan modern untuk membantu operasional Swalayan Maju Jaya lebih efisien ✨
                </p>

            </div>

        </div>

    </div>

</div>

</body>
</html>