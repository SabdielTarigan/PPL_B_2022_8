<?php
//File: logout.php
//Deskripsi: untuk logout (menghapus session yang dibuat saat login)
//Nama      : Nikolas Widad Arrauf H
//NIM       : 24060120140139
//Kelas     : B1

session_start();
if (isset($_SESSION['username'])){
    unset($_SESSION['username']);
    session_destroy();
}
header('Location: index.php');
?>
