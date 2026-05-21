<?php

session_start();
require_once '../../config/koneksi.php';

if (isset($_POST['tambah'])) {

    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = $_POST['role'];

    // cek username
    $cek = $pdo->prepare("
        SELECT COUNT(*) 
        FROM m_user 
        WHERE username = ?
    ");

    $cek->execute([$username]);

    if ($cek->fetchColumn() > 0) {

        echo "
        <script>
            alert('Username sudah digunakan');
            window.location='tambah.php';
        </script>
        ";
        exit;
    }

    // simpan user
    $sql = $pdo->prepare("
        INSERT INTO m_user
        (username, password, role)
        VALUES (?, ?, ?)
    ");

    $sql->execute([
        $username,
        $password,
        $role
    ]);

    echo "
    <script>
        alert('User berhasil ditambahkan');
        window.location='index.php';
    </script>
    ";
}
?>