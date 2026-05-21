<?php
session_start();

// kalau sudah login
if (isset($_SESSION['id_user'])) {
    header("Location: ../index.php");
    exit;
}

// init attempt login
if (!isset($_SESSION['login_attempt'])) {
    $_SESSION['login_attempt'] = 0;
    $_SESSION['login_time'] = time();
}

$error = "";

// reset attempt kalau sudah lewat 10 menit
if (time() - $_SESSION['login_time'] > 600) {
    $_SESSION['login_attempt'] = 0;
    $_SESSION['login_time'] = time();
}

// validasi form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = "Username dan Password wajib diisi!";
    } else {
        $_SESSION['login_attempt']++;

        // optional: batasi percobaan login
        if ($_SESSION['login_attempt'] > 5) {
            $error = "Terlalu banyak percobaan login. Coba lagi 5 menit.";
        } else {
            header("Location: proses_login.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SIKASIR</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:20px;
            font-family:'Poppins', sans-serif;

            background:
            linear-gradient(
                135deg,
                #fff9db 0%,
                #ffe8a3 50%,
                #ffd43b 100%
            );
        }

        .login-container{
            width:100%;
            max-width:500px;
        }

        .login-card{
            background:rgba(255,255,255,0.95);
            border-radius:30px;
            padding:50px;
            box-shadow:0 20px 50px rgba(0,0,0,0.08);
            backdrop-filter:blur(10px);
            border:1px solid rgba(255,255,255,0.4);

            animation:fadeIn 0.7s ease;
        }

        @keyframes fadeIn{
            from{
                opacity:0;
                transform:translateY(20px);
            }
            to{
                opacity:1;
                transform:translateY(0);
            }
        }

        .brand{
            text-align:center;
            margin-bottom:10px;
        }

        .brand h1{
            font-size:34px;
            font-weight:700;
            color:#5c4300;
            margin-bottom:5px;
        }

        .brand p{
            color:#8a6d1d;
            font-size:14px;
        }

        .login-title{
            text-align:center;
            font-size:28px;
            font-weight:600;
            color:#4b3900;
            margin-bottom:35px;
        }

        .input-group{
            position:relative;
            margin-bottom:22px;
        }

        .input-group i{
            position:absolute;
            top:50%;
            left:18px;
            transform:translateY(-50%);
            color:#b08900;
            z-index:10;
        }

        .input-group input{
            width:100%;
            height:55px;
            border:none;
            border-radius:16px;
            background:#fff7d6;
            padding-left:50px;
            font-size:15px;
            transition:0.3s;
        }

        .input-group input:focus{
            outline:none;
            background:#fff;
            box-shadow:0 0 0 4px rgba(255,212,59,0.3);
        }

        .form-check-label{
            font-size:14px;
            color:#6b5b2e;
        }

        .forgot-link{
            text-decoration:none;
            color:#b08900;
            font-size:14px;
            font-weight:500;
        }

        .forgot-link:hover{
            text-decoration:underline;
        }

        .btn-login{
            width:100%;
            height:55px;
            border:none;
            border-radius:16px;
            background:#f4b400;
            color:#5c4300;
            font-size:16px;
            font-weight:600;
            transition:0.3s;
            margin-top:10px;
        }

        .btn-login:hover{
            background:#e0a800;
            transform:translateY(-2px);
            box-shadow:0 10px 20px rgba(244,180,0,0.25);
        }

        .alert{
            border-radius:14px;
            font-size:14px;
        }

        @media(max-width:576px){

            .login-card{
                padding:35px 25px;
                border-radius:24px;
            }

            .brand h1{
                font-size:28px;
            }

            .login-title{
                font-size:24px;
            }

        }

    </style>
</head>

<body>

    <div class="login-container">

        <div class="login-card">

            <div class="brand">
                <h1>SIKASIR</h1>
                <p>Sistem Kasir Modern </p>
            </div>

            <h2 class="login-title">
                Welcome  
            </h2>

            <?php if($error): ?>
                <div class="alert alert-danger text-center">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form action="proses_login.php" method="POST">

                <div class="input-group">
                    <i class="fas fa-user"></i>

                    <input
                        type="text"
                        name="username"
                        placeholder="Masukkan Username"
                        required
                    >
                </div>

                <div class="input-group">
                    <i class="fas fa-lock"></i>

                    <input
                        type="password"
                        name="password"
                        placeholder="Masukkan Password"
                        required
                    >
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="remember"
                        >

                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>

                    <a href="#" class="forgot-link">
                        Forgot Password?
                    </a>

                </div>

                <button type="submit" class="btn-login">
                    LOGIN
                </button>

            </form>

        </div>

    </div>

</body>
</html>