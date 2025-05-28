<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['user']['role']!='admin') header("Location: login.php");
include '../config/db.php';

if (isset($_POST['restock'])) {
    $id = $_POST['id'];
    $tambah = $_POST['tambah'];
    mysqli_query($koneksi, "UPDATE produk SET stok = stok + $tambah WHERE id = '$id'");
    header("Location: produk.php");
    exit();
}

$q = mysqli_query($koneksi, "SELECT * FROM produk");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Restock Produk</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .restock-card {background:#fff;padding:32px 36px;border-radius:16px;box-shadow:0 2px 16px rgba(25,114,120,0.10);max-width:600px;margin-bottom:24px;}
        .restock-card h2 {margin-top:0;margin-bottom:18px;color:#197278;}
        .restock-card table {width:100%;margin-top:10px;border-collapse: separate; border-spacing: 0;}
        .restock-card th {background:#197278;color:#fff;font-weight:bold;text-align:left;padding:12px 15px;}
        .restock-card td {padding:10px 15px;text-align:left;border-bottom:1px solid #eee;}
        .restock-card th:first-child { border-top-left-radius: 10px; }
        .restock-card th:last-child { border-top-right-radius: 10px; }
        .restock-card tr:last-child td { border-bottom: none; }
        .restock-card tr:nth-child(even) {background:#f9f9f9;}
        .restock-card form {display:flex; align-items:center; gap: 8px;}
        .restock-card input[type=number] {padding:7px;border-radius:7px;border:1px solid #e0e0e0;width:70px;}
        .restock-card button {padding:7px 16px;border-radius:7px;background:#197278;color:#fff;border:none;cursor:pointer;transition:background .2s;}
        .restock-card button:hover {background:#1251a3;}
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="content">
    <div class="restock-card">
    <h2>Restock Komponen Komputer</h2>
    <table border="0" cellpadding="0" cellspacing="0">
        <thead>
            <tr><th>No</th><th>Nama</th><th>Stok</th><th>Tambah Stok</th></tr>
        </thead>
        <tbody>
        <?php $no=1; while($d = mysqli_fetch_assoc($q)): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($d['nama']) ?></td>
            <td><?= $d['stok'] ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="id" value="<?= $d['id'] ?>">
                    <input type="number" name="tambah" min="1" required>
                    <button name="restock">Restock</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>
</body>
</html> 