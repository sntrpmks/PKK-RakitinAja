<?php
session_start();
if (!isset($_SESSION['login'])) header("Location: login.php");
include '../config/db.php';
$user = $_SESSION['user'];
$kategoriList = ['Processor', 'RAM', 'Graphics Card', 'Motherboard', 'Power Supply', 'Casing', 'Storage'];
$filter = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$where = "WHERE 1=1";
if ($filter) {
    $where .= " AND kategori='$filter'";
}
if ($cari) {
    $where .= " AND nama LIKE '%$cari%'";
}
$q = mysqli_query($koneksi, "SELECT * FROM produk $where");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Produk - RakitinAja</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        .produk-container {
            background: #fff;
            padding: 32px;
            border-radius: 20px;
            box-shadow: var(--shadow);
            margin-bottom: 24px;
            border: 1px solid rgba(25,114,120,0.1);
            animation: fadeIn 0.5s ease;
        }
        
        .produk-container h2 {
            margin-top: 0;
            margin-bottom: 24px;
            color: var(--primary);
            font-size: 1.8em;
            font-weight: 600;
            position: relative;
            padding-bottom: 12px;
        }
        
        .produk-container h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--gradient);
            border-radius: 2px;
        }
        
        .filter-section {
            margin-bottom: 24px;
            display: flex;
            gap: 16px;
            align-items: center;
            flex-wrap: wrap;
            background: var(--bg);
            padding: 20px;
            border-radius: 12px;
        }
        
        .filter-section select {
            padding: 12px 20px;
            border-radius: 12px;
            border: 2px solid #e0e0e0;
            font-size: 1em;
            transition: all 0.3s ease;
            background: #fff;
            cursor: pointer;
            min-width: 200px;
        }
        
        .filter-section select:hover {
            border-color: var(--primary);
        }
        
        .filter-section select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(25,114,120,0.1);
        }
        
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 24px;
            margin-top: 24px;
        }
        
        .card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(25,114,120,0.1);
            transition: all 0.3s ease;
            animation: fadeIn 0.5s ease;
            border: 1px solid rgba(25,114,120,0.1);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(25,114,120,0.15);
        }
        
        .card img {
            width: 100%;
            height: 200px;
            object-fit: contain;
            transition: all 0.3s ease;
            padding: 20px;
            background: var(--bg);
        }
        
        .card:hover img {
            transform: scale(1.05);
        }
        
        .card-content {
            padding: 20px;
        }
        
        .card b {
            display: block;
            font-size: 1.2em;
            margin-bottom: 10px;
            color: #333;
        }
        
        .card span {
            display: block;
            color: var(--primary);
            font-weight: 600;
            font-size: 1.3em;
            margin-bottom: 10px;
        }
        
        .card .stok {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 6px;
        }
        
        .card .kategori {
            color: #888;
            font-size: 0.9em;
            margin-bottom: 16px;
        }
        
        .btn-proses {
            display: block;
            width: 100%;
            padding: 12px;
            background: var(--gradient);
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            text-align: center;
            font-weight: 600;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            border: none;
            cursor: pointer;
        }
        
        .btn-proses:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(25,114,120,0.3);
        }
        
        .btn-proses::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn-proses:active::after {
            width: 200px;
            height: 200px;
        }
        
        .btn-proses.disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        .aksi {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .aksi input[type="number"] {
            padding: 8px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            width: 80px;
            text-align: center;
        }

        .aksi input[type="number"]:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(25,114,120,0.1);
        }

        .admin-notice {
            background: #fff3cd;
            color: #856404;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 16px;
            border: 1px solid #ffeeba;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="content">
    <div class="produk-container">
        <h2>Daftar Komponen Komputer</h2>
        
        <?php if($user['role'] == 'admin'): ?>
        <div class="admin-notice">
            Anda login sebagai admin. Untuk memproses transaksi, silakan login sebagai kasir.
        </div>
        <?php endif; ?>
        
        <form method="get" class="filter-section">
                <select name="kategori" id="kategori" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    <?php foreach($kategoriList as $kat): ?>
                        <option value="<?= $kat ?>" <?= $filter==$kat?'selected':'' ?>><?= ucfirst($kat) ?></option>
                    <?php endforeach; ?>
                </select>
        </form>

            <div class="card-grid">
            <?php while($d = mysqli_fetch_assoc($q)): ?>
                <div class="card">
                    <a href="spesifikasi.php?type=produk&id=<?= $d['id'] ?>" style="text-decoration:none;color:inherit;">
                    <img src="../assets/img/<?= $d['gambar'] ?>" alt="<?= htmlspecialchars($d['nama']) ?>">
                    <div class="card-content">
                        <b><?= htmlspecialchars($d['nama']) ?></b>
                        <span>Rp. <?= number_format($d['harga']) ?></span>
                        <div class="stok">Stok: <?= $d['stok'] ?></div>
                        <div class="kategori">Kategori: <?= ucfirst($d['kategori']) ?></div>
                    </div>
                    </a>
                </div>
            <?php endwhile; ?>
            </div>
    </div>
</div>
</body>
</html> 