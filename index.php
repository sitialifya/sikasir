<?php

session_start();

if(isset($_SESSION['id_user'])){

    if($_SESSION['role'] == 'Admin'){

        header("Location: models/produk/index.php");

    }else{

        header("Location: models/transaksi/index.php");

    }

}else{

    header("Location: auth/login.php");

}
?>