<?php
session_start();
if (!isset($_SESSION['login'])) header("Location: login.php");
include '../config/db.php';
$q = mysqli_query($koneksi, "SELECT t.*, u.username, b.nama as nama_bundle FROM transaksi t JOIN users u ON t.user_id=u.id LEFT JOIN bundle b ON t.bundle_id = b.id ORDER BY t.tanggal DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Transaksi - RakitinAja</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .riwayat-card {background:#fff;padding:32px 36px;border-radius:16px;box-shadow:0 2px 16px rgba(25,114,120,0.10);max-width:1100px;margin-bottom:24px;}
        .riwayat-card h2 {margin-top:0;margin-bottom:18px;color:#197278;}
        .riwayat-card table {width:100%;margin-top:10px;border-collapse: separate; border-spacing: 0;}
        .riwayat-card th {background:#197278;color:#fff;font-weight:bold;text-align:left;padding:12px 15px;}
        .riwayat-card td {padding:10px 15px;text-align:left;border-bottom:1px solid #eee;}
        .riwayat-card th:first-child { border-top-left-radius: 10px; }
        .riwayat-card th:last-child { border-top-right-radius: 10px; }
        .riwayat-card tr:last-child td { border-bottom: none; }
        .riwayat-card tr:nth-child(even) {background:#f9f9f9;}
        .produk-list {font-size:0.95em;color:#333;line-height:1.4;}
        .bundle-info {font-weight: bold; color: var(--primary);}
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="content">
    <div class="riwayat-card">
    <h2>Riwayat Transaksi</h2>
    <table border="0" cellpadding="0" cellspacing="0">
        <thead>
            <tr><th>No</th><th>Tanggal</th><th>Kasir</th><th>Item Transaksi</th><th>Total</th></tr>
        </thead>
        <tbody>
        <?php $no=1; while($d = mysqli_fetch_assoc($q)): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $d['tanggal'] ?></td>
            <td><?= htmlspecialchars($d['nama_kasir']) ?></td>
            <td class="produk-list">
                <?php if ($d['bundle_id']):?>
                    <span class="bundle-info">Bundle: <?= htmlspecialchars($d['nama_bundle']) ?></span>
                <?php else:?>
                <?php
                    $qprod = mysqli_query($koneksi, "SELECT p.nama, dt.jumlah FROM detail_transaksi dt JOIN produk p ON dt.produk_id=p.id WHERE dt.transaksi_id='{$d['id']}'");
                $produkArr = [];
                while($p = mysqli_fetch_assoc($qprod)) {
                        $produkArr[] = htmlspecialchars($p['nama'])." (x".$p['jumlah'].")";
                }
                echo implode(', ', $produkArr);
                ?>
                <?php endif; ?>
            </td>
            <td>Rp. <?= number_format($d['total']) ?></td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>
</body>
</html> 