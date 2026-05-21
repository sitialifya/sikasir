<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

$username = "admin";
$password = password_hash("admin123", PASSWORD_DEFAULT);
$role = "Admin";

$stmt = $pdo->prepare("INSERT INTO m_user (username, password, role) VALUES (?, ?, ?)");
$success = $stmt->execute([$username, $password, $role]);

if ($success) {
    echo "User berhasil dibuat";
} else {
    echo "Gagal membuat user";
}
?>