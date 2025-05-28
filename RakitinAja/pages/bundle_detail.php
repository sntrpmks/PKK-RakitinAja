<?php
session_start();
if (!isset($_SESSION['login'])) header("Location: login.php");
include '../config/db.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$q = mysqli_query($koneksi, "SELECT * FROM bundle WHERE id = $id");
$bundle = mysqli_fetch_assoc($q);
if (!$bundle) die('Bundle tidak ditemukan');
$q_items = mysqli_query($koneksi, "SELECT bi.*, p.nama, p.harga, p.stok, p.gambar FROM bundle_items bi JOIN produk p ON bi.produk_id = p.id WHERE bi.bundle_id = $id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail Bundle - RakitinAja</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .bundle-detail-container {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(25,114,120,0.1);
            padding: 32px;
        }
        .bundle-detail-header {
            display: flex;
            gap: 32px;
            align-items: flex-start;
            margin-bottom: 32px;
        }
        .bundle-detail-header img {
            width: 220px;
            height: 220px;
            object-fit: contain;
            border-radius: 16px;
            background: #f5f5f5;
            box-shadow: 0 2px 8px rgba(25,114,120,0.07);
        }
        .bundle-info {
            flex: 1;
        }
        .bundle-info h2 {
            margin: 0 0 12px 0;
            color: var(--primary);
            font-size: 2em;
            font-weight: 700;
        }
        .bundle-info .harga {
            color: var(--primary);
            font-size: 1.3em;
            font-weight: 600;
            margin-bottom: 12px;
        }
        .bundle-info .desc {
            color: #555;
            margin-bottom: 16px;
        }
        .bundle-komponen {
            margin-top: 24px;
        }
        .bundle-komponen h3 {
            color: var(--primary);
            font-size: 1.2em;
            margin-bottom: 12px;
        }
        .komponen-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .komponen-item {
            display: flex;
            align-items: center;
            gap: 16px;
            background: #f8f9fa;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 12px;
        }
        .komponen-item img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 1px 4px rgba(25,114,120,0.07);
        }
        .komponen-info {
            flex: 1;
        }
        .komponen-info .nama {
            font-weight: 600;
            color: #333;
        }
        .komponen-info .qty {
            color: #197278;
            font-size: 0.98em;
            margin-left: 8px;
        }
        .komponen-info .harga {
            color: #888;
            font-size: 0.97em;
        }
        .komponen-info .stok {
            font-size: 0.95em;
            margin-left: 8px;
            color: #28a745;
        }
        .komponen-info .stok.low { color: #dc3545; }
        .komponen-info .stok.medium { color: #ffc107; }
        .komponen-info .stok.safe { color: #28a745; }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="content">
    <div class="bundle-detail-container">
        <div class="bundle-detail-header">
            <img src="../assets/img/<?= $bundle['gambar'] ?>" alt="<?= htmlspecialchars($bundle['nama']) ?>">
            <div class="bundle-info">
                <h2><?= htmlspecialchars($bundle['nama']) ?></h2>
                <div class="harga">Rp. <?= number_format($bundle['harga']) ?></div>
                <div class="desc"><?= htmlspecialchars($bundle['deskripsi']) ?></div>
            </div>
        </div>
        <div class="bundle-komponen">
            <h3>Spesifikasi Komponen Bundle</h3>
            <ul class="komponen-list">
                <?php while($item = mysqli_fetch_assoc($q_items)): ?>
                <li class="komponen-item">
                    <img src="../assets/img/<?= $item['gambar'] ?>" alt="<?= htmlspecialchars($item['nama']) ?>">
                    <div class="komponen-info">
                        <span class="nama"><?= htmlspecialchars($item['nama']) ?></span>
                        <span class="qty">(<?= $item['qty'] ?>x)</span>
                        <span class="harga">Rp. <?= number_format($item['harga']) ?></span>
                        <span class="stok <?= $item['stok']<5?'low':($item['stok']<10?'medium':'safe') ?>">Stok: <?= $item['stok'] ?></span>
                    </div>
                </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
</div>
</body>
</html> 