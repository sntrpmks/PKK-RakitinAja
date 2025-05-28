<?php
session_start();
if (!isset($_SESSION['login'])) header("Location: login.php");
include '../config/db.php';

$q_produk = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY nama ASC");

$q_bundle = mysqli_query($koneksi, "SELECT * FROM bundle ORDER BY nama ASC");

if (isset($_GET['hapus']) && $_SESSION['user']['role'] == 'admin') {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM detail_transaksi WHERE produk_id='$id'");
    mysqli_query($koneksi, "DELETE FROM produk WHERE id='$id'");
    header("Location: laporan.php");
    exit;
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok - RakitinAja</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .laporan-card {background:#fff;padding:32px 36px;border-radius:16px;box-shadow:0 2px 16px rgba(25,114,120,0.10);max-width:700px;margin-bottom:24px;}
        .laporan-card h2 {margin-top:0;margin-bottom:18px;color:#197278;}
        .laporan-card table {width:100%;margin-top:10px;border-collapse: separate; border-spacing: 0;}
        .laporan-card th {background:#197278;color:#fff;font-weight:bold;text-align:left;padding:12px 15px;}
        .laporan-card td {padding:10px 15px;text-align:left;border-bottom:1px solid #eee;}
        .laporan-card th:first-child { border-top-left-radius: 10px; }
        .laporan-card th:last-child { border-top-right-radius: 10px; }
        .laporan-card tr:last-child td { border-bottom: none; }
        .laporan-card tr:nth-child(even) { background:#f9f9f9; }
        .btn-hapus {background:#e74c3c;color:#fff;padding:6px 12px;border:none;border-radius:6px;cursor:pointer;font-weight:normal;transition:background .2s;font-size:0.9em;}
        .btn-hapus:hover {background:#b71c1c;}
        .btn-edit {background:#197278;color:#fff;padding:6px 12px;border:none;border-radius:6px;cursor:pointer;font-weight:normal;transition:background .2s;font-size:0.9em;}
        .btn-edit:hover {background:#1251a3;}
        .action-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .action-buttons .btn-edit,
        .action-buttons .btn-hapus {
            margin-right: 0;
            white-space: nowrap;
        }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="content">
    <div class="laporan-container">
        <h2>Laporan Stok Barang</h2>

        <div class="laporan-section">
            <h3>Stok Komponen</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $no = 1;
                    while($d = mysqli_fetch_assoc($q_produk)): 
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><img src="../assets/img/<?= $d['gambar'] ?>" alt="<?= htmlspecialchars($d['nama']) ?>" style="width:50px;height:50px;object-fit:contain;"></td>
                            <td><?= htmlspecialchars($d['nama']) ?></td>
                            <td><?= htmlspecialchars($d['kategori']) ?></td>
                            <td>Rp. <?= number_format($d['harga']) ?></td>
                            <td>
                                <span class="stok-badge <?= $d['stok']<5?'low':($d['stok']<10?'medium':'safe') ?>">
                                    <?= $d['stok'] ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="edit_produk.php?id=<?= $d['id'] ?>" class="btn-edit">Edit</a>
                                    <a href="hapus_produk.php?id=<?= $d['id'] ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="laporan-section">
            <h3>Stok Bundle</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Bundle</th>
                            <th>Harga</th>
                            <th>Komponen</th>
                            <th>Status Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $no = 1;
                    while($bundle = mysqli_fetch_assoc($q_bundle)): 
                        $q_items = mysqli_query($koneksi, "SELECT bi.*, p.stok, p.nama 
                                                          FROM bundle_items bi 
                                                          JOIN produk p ON bi.produk_id = p.id 
                                                          WHERE bi.bundle_id = {$bundle['id']}");
                        $stok_aman = true;
                        $komponen_list = [];
                        while($item = mysqli_fetch_assoc($q_items)) {
                            if($item['stok'] < $item['qty']) {
                                $stok_aman = false;
                            }
                            $komponen_list[] = $item['nama'] . " ({$item['qty']}x)";
                        }
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><img src="../assets/img/<?= $bundle['gambar'] ?>" alt="<?= htmlspecialchars($bundle['nama']) ?>" style="width:50px;height:50px;object-fit:contain;"></td>
                            <td><?= htmlspecialchars($bundle['nama']) ?></td>
                            <td>Rp. <?= number_format($bundle['harga']) ?></td>
                            <td>
                                <ul style="list-style:none;padding:0;margin:0;">
                                    <?php foreach($komponen_list as $komponen): ?>
                                        <li><?= htmlspecialchars($komponen) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </td>
                            <td>
                                <span class="stok-badge <?= $stok_aman ? 'safe' : 'low' ?>">
                                    <?= $stok_aman ? 'Stok Aman' : 'Stok Tidak Cukup' ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="edit_bundle.php?id=<?= $bundle['id'] ?>" class="btn-edit">Edit</a>
                                    <a href="hapus_bundle.php?id=<?= $bundle['id'] ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus bundle ini?')">Hapus</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .laporan-section {
        margin-bottom: 40px;
    }
    
    .laporan-section h3 {
        color: var(--primary);
        margin-bottom: 20px;
        font-size: 1.4em;
    }
    
    .table-container {
        background: #fff;
        border-radius: 12px;
        box-shadow: var(--shadow);
        overflow: hidden;
        border: 1px solid rgba(25,114,120,0.1);
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
    }
    
    th, td {
        padding: 12px 16px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }
    
    th {
        background: var(--primary);
        color: #fff;
        font-weight: 600;
    }
    
    tr:hover {
        background: #f8f9fa;
    }
    
    .stok-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.9em;
        font-weight: 500;
    }
    
    .stok-badge.low {
        background: #ffe5e5;
        color: #dc3545;
    }
    
    .stok-badge.medium {
        background: #fff3cd;
        color: #ffc107;
    }
    
    .stok-badge.safe {
        background: #d4edda;
        color: #28a745;
    }
    
    .btn-edit, .btn-hapus {
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 0.9em;
        margin-right: 8px;
    }
    
    .btn-edit {
        background: var(--primary);
        color: #fff;
    }
    
    .btn-hapus {
        background: #dc3545;
        color: #fff;
    }
    
    .btn-edit:hover {
        background: var(--primary-dark);
    }
    
    .btn-hapus:hover {
        background: #c82333;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .action-buttons .btn-edit,
    .action-buttons .btn-hapus {
        margin-right: 0;
        white-space: nowrap;
    }
</style>
</body>
</html> 