<?php
session_start();

if(isset($_SESSION['kullanici_adi']))
    include 'page.php';
else
    include 'login.php';
?>

