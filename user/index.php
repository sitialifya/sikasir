<?php
require '../../includes/auth.php';
require '../../config/koneksi.php';

$data = $pdo->query("SELECT * FROM m_user ORDER BY role DESC, username ASC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manajemen User - SI KASIR</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{
    min-height:100vh;
    font-family:'Segoe UI', sans-serif;
    background: linear-gradient(135deg,#fff7c2,#ffeaa7,#fff3b0);
}

/* CONTAINER */
.main-container{
    max-width:1100px;
    margin:50px auto;
    padding:0 20px;
}

/* CARD */
.card{
    border:none;
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 18px 45px rgba(0,0,0,0.12);
    background:#ffffff;
}

/* HEADER */
.card-header{
    background: linear-gradient(135deg,#f6d365,#fda085);
    color:#2b2b2b;
    padding:22px 25px;
    border:0;
}

/* BUTTON */
.btn-tambah{
    background:#fff3b0;
    color:#5a4a1f;
    border-radius:12px;
    padding:10px 16px;
    border:none;
    font-weight:600;
    transition:0.2s;
}

.btn-tambah:hover{
    background:#ffe58a;
    transform:translateY(-2px);
}

/* TABLE */
.table{
    margin-bottom:0;
}

.table th{
    background:#fff8d6;
    color:#5a4a1f;
    font-weight:600;
    border:0;
}

.table td{
    vertical-align:middle;
    border-color:#f5f0d6;
}

.table-hover tbody tr:hover{
    background:#fffdf0;
}

/* BADGE */
.badge-admin{
    background:#ffd6a5;
    color:#6b4f1d;
    padding:6px 12px;
    border-radius:12px;
}

.badge-kasir{
    background:#fff1b8;
    color:#6b5b2a;
    padding:6px 12px;
    border-radius:12px;
}

/* ACTION BUTTON */
.btn-hapus{
    border-radius:10px;
    font-size:0.9rem;
    border:1px solid #ffb4a2;
    color:#d35400;
    background:transparent;
}

.btn-hapus:hover{
    background:#ffe0d6;
}

/* FOOTER */
.card-footer{
    background:#fffdf5;
    border-top:1px solid #f5f0d6;
}
</style>
</head>

<body>

<div class="main-container">

<div class="card">

    <!-- HEADER -->
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-0 fw-bold">👤 Manajemen User</h4>
            <small>Kelola akun kasir & admin</small>
        </div>

        <a href="tambah.php" class="btn btn-tambah">
            <i class="bi bi-plus-lg"></i> Tambah User
        </a>
    </div>

    <!-- TABLE -->
    <div class="card-body p-4">

        <div class="table-responsive">
            <table class="table table-hover align-middle">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach($data as $i => $d): ?>
                    <tr>
                        <td><?= $i+1 ?></td>
                        <td><strong><?= htmlspecialchars($d['username']) ?></strong></td>

                        <td>
                            <?php if($d['role'] == 'Admin'): ?>
                                <span class="badge badge-admin">Admin</span>
                            <?php else: ?>
                                <span class="badge badge-kasir">Kasir</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if($d['role'] != 'Admin'): ?>
                                <a href="hapus.php?id=<?= $d['id_user'] ?>"
                                   class="btn btn-hapus btn-sm"
                                   onclick="return confirm('Hapus user ini?')">
                                   <i class="bi bi-trash"></i> Hapus
                                </a>
                            <?php else: ?>
                                <span class="text-muted small">Protected</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>

            </table>
        </div>

        <?php if(empty($data)): ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-people display-1"></i>
                <p class="mt-2">Belum ada user</p>
            </div>
        <?php endif; ?>

    </div>

    <!-- FOOTER -->
    <div class="card-footer d-flex justify-content-between align-items-center">
        <a href="../../dashboard_admin.php" class="btn btn-light border">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>

        <small class="text-muted">Total User: <?= count($data) ?></small>
    </div>

</div>

</div>

</body>
</html>