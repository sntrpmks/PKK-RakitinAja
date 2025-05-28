<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['user']['role']!='admin') header("Location: login.php");
include '../config/db.php';
$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM produk WHERE id='$id'");
header("Location: dashboard.php");
?> 