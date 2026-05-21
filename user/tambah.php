<?php 
require_once '../../config/koneksi.php'; 
require_once '../../includes/auth.php'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tambah User - SI KASIR</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{
    min-height:100vh;
    font-family:'Segoe UI', sans-serif;
    background: linear-gradient(135deg,#fff7c2,#ffeaa7,#fdf1a6);
    display:flex;
    align-items:center;
    justify-content:center;
}

/* CARD */
.card{
    width:100%;
    max-width:750px;
    border:none;
    border-radius:25px;
    overflow:hidden;
    box-shadow:0 20px 50px rgba(0,0,0,0.15);
    background:rgba(255,255,255,0.9);
    backdrop-filter: blur(10px);
}

/* HEADER */
.card-header{
    background: linear-gradient(135deg,#f6d365,#fda085);
    color:#2b2b2b;
    padding:30px;
    border:0;
    text-align:center;
}

.card-header h4{
    font-weight:700;
    margin-bottom:5px;
}

/* FORM */
.card-body{
    padding:40px;
}

/* INPUT GROUP STYLE */
.input-group-text{
    background:#fff3b0;
    border:2px solid #f0e2a6;
    border-right:none;
    border-radius:12px 0 0 12px;
    color:#6b5b2a;
}

.form-control,
.form-select{
    border:2px solid #f0e2a6;
    border-radius:0 12px 12px 0;
    padding:12px 15px;
    background:#fffef7;
}

.form-control:focus,
.form-select:focus{
    border-color:#f4c542;
    box-shadow:0 0 0 4px rgba(244,197,66,0.25);
}

/* BUTTON */
.btn-primary{
    background:linear-gradient(135deg,#f4c542,#f6d365);
    border:none;
    border-radius:12px;
    padding:14px;
    font-weight:600;
    color:#2b2b2b;
    transition:0.2s;
}

.btn-primary:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(244,197,66,0.3);
}

.btn-secondary{
    border-radius:12px;
    padding:14px;
    background:#fff3b0;
    border:none;
    color:#5a4a1f;
}

.btn-secondary:hover{
    background:#ffe58a;
}

/* GRID */
.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

.full{
    grid-column:1 / -1;
}

/* RESPONSIVE */
@media(max-width:768px){
    .form-grid{
        grid-template-columns:1fr;
    }
}
</style>
</head>

<body>

<div class="card">

    <div class="card-header">
        <h4><i class="bi bi-person-plus-fill"></i> Tambah User</h4>
        <small>Kelola akun kasir & admin dengan mudah</small>
    </div>

    <div class="card-body">

        <form action="proses.php" method="POST">

            <div class="form-grid">

                <!-- Username -->
                <div class="full">
                    <label class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                    </div>
                </div>

                <!-- Password -->
                <div class="full">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>
                </div>

                <!-- Role -->
                <div class="full">
                    <label class="form-label">Role</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                        <select name="role" class="form-select" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="Admin">Admin</option>
                            <option value="Kasir">Kasir</option>
                        </select>
                    </div>
                </div>

                <!-- BUTTON -->
                <div class="full mt-3">
                    <button type="submit" name="tambah" class="btn btn-primary w-100 mb-2">
                        <i class="bi bi-check-circle"></i> Simpan User
                    </button>

                    <a href="index.php" class="btn btn-secondary w-100">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

            </div>

        </form>

    </div>

</div>

</body>
</html>