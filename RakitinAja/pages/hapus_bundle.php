<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['user']['role'] != 'admin') header("Location: login.php");
include '../config/db.php';

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    $q = mysqli_query($koneksi, "SELECT gambar FROM bundle WHERE id = '$id'");
    if($q) {
        $bundle = mysqli_fetch_assoc($q);
        if($bundle && $bundle['gambar']) {
            $gambar_path = "../assets/img/" . $bundle['gambar'];
            if(file_exists($gambar_path)) {
                unlink($gambar_path);
            }
        }

        $delete_items = mysqli_query($koneksi, "DELETE FROM bundle_items WHERE bundle_id = '$id'");
        if(!$delete_items) {
            $_SESSION['error'] = "Gagal menghapus items bundle: " . mysqli_error($koneksi);
            header("Location: laporan.php");
            exit;
        }

        $delete_bundle = mysqli_query($koneksi, "DELETE FROM bundle WHERE id = '$id'");
        if(!$delete_bundle) {
            $_SESSION['error'] = "Gagal menghapus bundle: " . mysqli_error($koneksi);
            header("Location: laporan.php");
            exit;
        }
        
        $_SESSION['success'] = "Bundle berhasil dihapus";
    } else {
        $_SESSION['error'] = "Gagal mengambil data bundle: " . mysqli_error($koneksi);
    }
} else {
    $_SESSION['error'] = "ID bundle tidak ditemukan";
}

header("Location: laporan.php");
exit;
?> 