<?php
session_start();
require_once '../config/koneksi.php';

/*SET DEFAULT LOGIN ATTEMPT*/
if (!isset($_SESSION['login_attempt'])) {
    $_SESSION['login_attempt'] = 0;
}

if (!isset($_SESSION['login_time'])) {
    $_SESSION['login_time'] = time();
}

/*CEK BRUTEFORCE*/
if ($_SESSION['login_attempt'] >= 5) {

    $selisih = time() - $_SESSION['login_time'];

    // 300 detik = 5 menit
    if ($selisih < 300) {

        die("Terlalu banyak percobaan, tunggu 5 menit.");

    } else {

        // reset setelah 5 menit
        $_SESSION['login_attempt'] = 0;
    }
}

/*PROSES LOGIN*/
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    /*VALIDASI EMPTY FIELD*/
    if (empty($username) || empty($password)) {

        die("Username dan Password wajib diisi!");
    }

    /*CEK USER*/
    $query = $pdo->prepare("
        SELECT *
        FROM m_user
        WHERE username = ?
    ");

    $query->execute([$username]);

    $user = $query->fetch();

    /*LOGIN BERHASIL*/
    if ($user && password_verify($password, $user['password'])) {

        // reset login attempt
        $_SESSION['login_attempt'] = 0;

        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        /*REDIRECT ROLE*/
        if ($user['role'] == 'Admin') {

            header("Location: ../dashboard_admin.php");
            exit;

        } else {

            header("Location: ../models/transaksi/index.php");
            exit;
        }

    } else {

        /*LOGIN GAGAL*/
        $_SESSION['login_attempt'] += 1;
        $_SESSION['login_time'] = time();

        echo "Username atau Password salah!";
    }
}
?>