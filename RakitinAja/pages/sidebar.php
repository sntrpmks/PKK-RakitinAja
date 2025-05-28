<?php
if (!isset($user) && isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
$role = isset($user['role']) ? $user['role'] : '';
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .search-form {
            position: relative;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
        }
        
        .search-form input[type="text"] {
            width: 100%;
            height: 42px;
            padding: 0 16px 0 40px;
            border: 2px solid #eee;
            border-radius: 12px;
            font-size: 0.95em;
            transition: all 0.3s ease;
            background: var(--bg);
            line-height: 42px;
        }
        
        .search-form input[type="text"]::placeholder {
            position: relative;
            top: 1px;
        }
        
        .search-form input[type="text"]:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(25,114,120,0.1);
        }
        
        .search-form::before {
            content: '🔍';
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.1em;
            z-index: 1;
            line-height: 1;
            display: flex;
            align-items: center;
            height: 42px;
        }
    </style>
</head>
<body>
<div class="sidebar <?= $role ?>">
    <a href="dashboard.php" class="logo">rakitinaja</a>
    <form action="produk.php" method="get" class="search-form">
        <input type="text" name="cari" placeholder="Cari Barang...">
    </form>
    <a href="dashboard.php">Dashboard</a>
    <?php if($role == 'admin'): ?>
        <a href="restock.php">Restock</a>
    <?php endif; ?>
    <a href="riwayat.php">Riwayat Transaksi</a>
    <a href="laporan.php">Laporan Stok</a>
    <?php if($role == 'admin'): ?>
        <a href="tambah_produk.php">Tambah Produk</a>
        <a href="user.php">User</a>
    <?php endif; ?>
    <a href="logout.php">Logout</a>
</div> 
</body>
</html> 