<?php

session_start();

if(!isset($_SESSION['id_user'])){

    header("Location: ../../auth/login.php");
    exit;
}

if($_SESSION['role'] != 'Kasir'){

    die("Akses kasir ditolak!");

}
?>