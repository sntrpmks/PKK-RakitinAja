<?php
session_start();
if (!isset($_SESSION['login'])) header("Location: login.php");
$user = $_SESSION['user'];
include '../config/db.php';
$kategoriList = ['Processor', 'RAM', 'Graphics Card', 'Motherboard', 'Power Supply', 'Casing', 'Storage', 'Software', 'Lainnya'];
$filter = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$where = $filter ? "WHERE kategori='$filter'" : '';
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
if ($cari) {
    $where .= ($where ? ' AND ' : 'WHERE ') . "nama LIKE '%$cari%'";
}
$q = mysqli_query($koneksi, "SELECT * FROM produk $where");

$q_grafik = mysqli_query($koneksi, "SELECT DATE(tanggal) as tgl, SUM(total) as total FROM transaksi GROUP BY DATE(tanggal) ORDER BY tgl DESC LIMIT 7");
$labels = [];
$data = [];
while($d = mysqli_fetch_assoc($q_grafik)) {
    $labels[] = date('d/m', strtotime($d['tgl']));
    $data[] = $d['total'];
}
$labels = array_reverse($labels);
$data = array_reverse($data);

$q2 = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM transaksi");
$transaksi = mysqli_fetch_assoc($q2)['total'];

$q3 = mysqli_query($koneksi, "SELECT SUM(total) as total FROM transaksi");
$pendapatan = mysqli_fetch_assoc($q3)['total'];

$q4 = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM produk WHERE stok < 5");
$stok_habis = mysqli_fetch_assoc($q4)['total'];

$q_produk = mysqli_query($koneksi, "SELECT * FROM produk WHERE stok < 10 ORDER BY stok ASC");
$q_bundle = mysqli_query($koneksi, "SELECT * FROM bundle ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - RakitinAja</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <?php if($user['role'] == 'admin'): ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php endif; ?>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        .dashboard-header {
            background: linear-gradient(120deg, #197278 60%, #43b5a0 100%);
            color: #fff;
            padding: 40px;
            border-radius: 20px;
            margin-bottom: 32px;
            box-shadow: 0 10px 30px rgba(25,114,120,0.15);
            position: relative;
            overflow: hidden;
            animation: fadeInDown 0.5s ease;
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .dashboard-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
            animation: shimmer 2s infinite;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        .dashboard-header h1 {
            margin: 0 0 12px 0;
            letter-spacing: 1px;
            font-size: 2.2em;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        
        .dashboard-header p {
            margin: 0;
            font-size: 1.1em;
            opacity: 0.9;
        }
        
        .filter-kategori {
            margin-bottom: 24px;
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .filter-kategori select {
            padding: 12px 20px;
            border-radius: 12px;
            border: 2px solid #e0e0e0;
            font-size: 1em;
            transition: all 0.3s ease;
            background: #fff;
            cursor: pointer;
        }
        
        .filter-kategori select:hover {
            border-color: #197278;
        }
        
        .filter-kategori select:focus {
            outline: none;
            border-color: #197278;
            box-shadow: 0 0 0 3px rgba(25,114,120,0.1);
        }
        
        <?php if($user['role'] == 'admin'): ?>
        .chart-container {
            background: #fff;
            padding: 32px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(25,114,120,0.1);
            margin: 32px 0;
            animation: slideUp 0.5s ease;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .chart-container h3 {
            margin: 0 0 20px 0;
            color: #197278;
            font-size: 1.5em;
            font-weight: 600;
        }
        
        .chart-options {
            margin-bottom: 24px;
            display: flex;
            gap: 12px;
        }
        
        .chart-options button {
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            background: #f0f0f0;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .chart-options button.active {
            background: #197278;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(25,114,120,0.2);
        }
        
        .top-products {
            margin-top: 40px;
            animation: fadeIn 0.5s ease;
        }
        
        .top-products h3 {
            color: #197278;
            margin-bottom: 20px;
            font-size: 1.5em;
            font-weight: 600;
        }
        
        .top-products table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        
        .top-products th {
            background: #197278;
            color: #fff;
            padding: 16px;
            text-align: left;
            font-weight: 500;
        }
        
        .top-products td {
            padding: 14px 16px;
            border-bottom: 1px solid #eee;
            transition: all 0.3s ease;
        }
        
        .top-products tr:last-child td {
            border-bottom: none;
        }
        
        .top-products tr:nth-child(even) {
            background: #f9f9f9;
        }
        
        .top-products tr:hover td {
            background: rgba(25,114,120,0.05);
        }
        <?php endif; ?>
        
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
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(25,114,120,0.15);
        }
        
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: all 0.3s ease;
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
            color: #197278;
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
            background: #197278;
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            text-align: center;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-proses:hover {
            background: #1251a3;
            transform: translateY(-2px);
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
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }
        
        .stat-card {
            background: #fff;
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(25,114,120,0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(25,114,120,0.1);
            position: relative;
            overflow: hidden;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(25,114,120,0.15);
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--gradient);
        }
        
        .stat-card .icon {
            font-size: 2.5em;
            margin-bottom: 16px;
            color: var(--primary);
        }
        
        .stat-card .value {
            font-size: 2em;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }
        
        .stat-card .label {
            color: #666;
            font-size: 0.9em;
        }
        
        .chart-container {
            background: #fff;
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(25,114,120,0.1);
            margin-bottom: 32px;
            border: 1px solid rgba(25,114,120,0.1);
        }
        
        .chart-container h3 {
            margin-top: 0;
            margin-bottom: 24px;
            color: var(--primary);
            font-size: 1.4em;
            font-weight: 600;
        }
        
        .chart-wrapper {
            position: relative;
            height: 300px;
        }
        
        .product-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 24px 0;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(25,114,120,0.1);
            animation: fadeIn 0.5s ease;
        }
        
        .product-table th {
            background: var(--primary);
            color: #fff;
            padding: 16px;
            text-align: left;
            font-weight: 500;
            font-size: 0.95em;
        }
        
        .product-table td {
            padding: 16px;
            border-bottom: 1px solid #eee;
            font-size: 0.95em;
        }
        
        .product-table tr:last-child td {
            border-bottom: none;
        }
        
        .product-table tr:nth-child(even) {
            background: #f9f9f9;
        }
        
        .product-table tr:hover td {
            background: rgba(25,114,120,0.05);
        }
        
        .product-table img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border-radius: 8px;
            background: #f5f5f5;
            padding: 4px;
        }
        
        .product-table .stok {
            font-weight: 500;
        }
        
        .product-table .stok.rendah {
            color: #dc3545;
        }
        
        .product-table .stok.sedang {
            color: #ffc107;
        }
        
        .product-table .stok.aman {
            color: #28a745;
        }
        
        .product-table .kategori {
            text-transform: capitalize;
            color: #666;
        }
        
        .product-table .harga {
            font-weight: 600;
            color: var(--primary);
        }
        
        .section-header {
            margin: 32px 0 24px;
            position: relative;
            padding-bottom: 12px;
        }
        
        .section-header h2 {
            color: var(--primary);
            font-size: 1.8em;
            font-weight: 600;
            margin: 0;
        }
        
        .section-header::after {
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
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(25,114,120,0.1);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .filter-section label {
            font-weight: 500;
            color: #333;
            font-size: 1.1em;
        }
        
        .filter-section select {
            padding: 12px 20px;
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            font-size: 1em;
            transition: all 0.3s ease;
            background: #fff;
            cursor: pointer;
            min-width: 200px;
            color: #333;
            font-weight: 500;
        }
        
        .filter-section select:hover {
            border-color: var(--primary);
        }
        
        .filter-section select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(25,114,120,0.1);
        }
        
        .filter-section select option {
            padding: 10px;
            font-size: 1em;
        }
        
        .bundle-items {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .bundle-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 4px 8px;
            background: #f8f9fa;
            border-radius: 6px;
            font-size: 0.9em;
        }
        
        .item-name {
            font-weight: 500;
            color: #333;
        }
        
        .item-qty {
            color: #666;
        }
        
        .item-stock {
            font-size: 0.85em;
            padding: 2px 6px;
            border-radius: 4px;
        }
        
        .item-stock.low {
            background: #ffe5e5;
            color: #dc3545;
        }
        
        .item-stock.medium {
            background: #fff3cd;
            color: #ffc107;
        }
        
        .item-stock.safe {
            background: #d4edda;
            color: #28a745;
        }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="content">
    <div class="dashboard-header">
        <h1>Selamat Datang, <?= htmlspecialchars($user['username']) ?></h1>
        <p>Website Penjualan Komponen Komputer RakitinAja</p>
    </div>

    <div class="section-header">
    <h2>Daftar Komponen Komputer</h2>
    </div>
    
    <form method="get" class="filter-section">
        <label for="kategori">Filter Kategori:</label>
        <select name="kategori" id="kategori" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            <?php foreach($kategoriList as $kat): ?>
                <option value="<?= $kat ?>" <?= $filter==$kat?'selected':'' ?>><?= ucfirst($kat) ?></option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if($user['role']=='admin'): ?>
    <table class="product-table">
        <thead>
        <tr>
                <th>Gambar</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
        </tr>
        </thead>
        <tbody>
            <?php while($d = mysqli_fetch_assoc($q)): 
                $stok_class = $d['stok'] < 5 ? 'rendah' : ($d['stok'] < 10 ? 'sedang' : 'aman');
            ?>
        <tr>
                <td><img src="../assets/img/<?= $d['gambar'] ?>" alt="<?= htmlspecialchars($d['nama']) ?>"></td>
            <td><?= htmlspecialchars($d['nama']) ?></td>
                <td class="kategori"><?= ucfirst($d['kategori']) ?></td>
                <td class="harga">Rp. <?= number_format($d['harga']) ?></td>
                <td class="stok <?= $stok_class ?>"><?= $d['stok'] ?> unit</td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <div class="section-header">
        <h2>Daftar Bundle Paket</h2>
    </div>
    <div class="product-table">
        <table>
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Bundle</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
            <?php while($bundle = mysqli_fetch_assoc($q_bundle)): 
                $q_items = mysqli_query($koneksi, "SELECT bi.*, p.nama, p.harga, p.stok 
                                                  FROM bundle_items bi 
                                                  JOIN produk p ON bi.produk_id = p.id 
                                                  WHERE bi.bundle_id = {$bundle['id']}");
            ?>
            <tr>
                <td><img src="../assets/img/<?= $bundle['gambar'] ?>" alt="<?= htmlspecialchars($bundle['nama']) ?>" style="width: 50px; height: 50px; object-fit: cover;"></td>
                <td><a href="spesifikasi.php?type=bundle&id=<?= $bundle['id'] ?>" style="text-decoration:none; color:inherit;"><?= htmlspecialchars($bundle['nama']) ?></a></td>
                <td>Rp. <?= number_format($bundle['harga']) ?></td>
            </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="icon">📊</div>
            <div class="value"><?= number_format($transaksi) ?></div>
            <div class="label">Total Transaksi</div>
        </div>
        
        <div class="stat-card">
            <div class="icon">💰</div>
            <div class="value">Rp. <?= number_format($pendapatan) ?></div>
            <div class="label">Total Pendapatan</div>
        </div>
        
        <div class="stat-card">
            <div class="icon">⚠️</div>
            <div class="value"><?= number_format($stok_habis) ?></div>
            <div class="label">Stok Menipis</div>
        </div>
    </div>

    <div class="chart-container">
        <h3>Grafik Penjualan 7 Hari Terakhir</h3>
        <div class="chart-wrapper">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <div class="top-products">
        <h3>Produk Terlaris</h3>
        <table class="product-table">
            <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Total Terjual</th>
            </tr>
            </thead>
            <tbody>
            <?php
                $q_top = mysqli_query($koneksi, "SELECT p.nama, p.kategori, SUM(dt.jumlah) as total_terjual 
                FROM detail_transaksi dt 
                JOIN produk p ON dt.produk_id = p.id 
                GROUP BY p.id 
                ORDER BY total_terjual DESC 
                LIMIT 5");
            while($top = mysqli_fetch_assoc($q_top)):
            ?>
            <tr>
                <td><?= htmlspecialchars($top['nama']) ?></td>
                    <td class="kategori"><?= ucfirst($top['kategori']) ?></td>
                    <td class="harga"><?= number_format($top['total_terjual']) ?> unit</td>
            </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    

    <?php else: ?>
    <div class="card-grid">
    <?php mysqli_data_seek($q, 0); while($d = mysqli_fetch_assoc($q)): ?>
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
            <form method="post" action="transaksi.php" class="aksi">
                <input type="hidden" name="id" value="<?= $d['id'] ?>">
                <input type="number" name="qty" min="1" max="<?= $d['stok'] ?>" value="1">
                <button name="tambah" class="btn-proses">Proses</button>
            </form>
        </div>
    <?php endwhile; ?>
    </div>
    <?php endif; ?>
    <?php if($user['role']!='admin'): ?>
    <div style="margin-top:40px;"></div>
    <div class="section-header">
        <h2>Daftar Bundle Paket</h2>
    </div>
    <div class="card-grid">
    <?php 
    $q_bundle = mysqli_query($koneksi, "SELECT * FROM bundle ORDER BY id DESC");
    while($bundle = mysqli_fetch_assoc($q_bundle)):
        $q_items = mysqli_query($koneksi, "SELECT bi.*, p.nama, p.harga, p.stok 
                                          FROM bundle_items bi 
                                          JOIN produk p ON bi.produk_id = p.id 
                                          WHERE bi.bundle_id = {$bundle['id']}");
    ?>
        <div class="card">
            <a href="spesifikasi.php?type=bundle&id=<?= $bundle['id'] ?>" style="text-decoration:none;color:inherit;">
                <img src="../assets/img/<?= $bundle['gambar'] ?>" alt="<?= htmlspecialchars($bundle['nama']) ?>">
                <div class="card-content">
                    <b><?= htmlspecialchars($bundle['nama']) ?></b>
                    <span>Rp. <?= number_format($bundle['harga']) ?></span>
                    <div style="margin-bottom:8px; color:#666; font-size:0.95em;">Deskripsi: <?= htmlspecialchars($bundle['deskripsi']) ?></div>
                    <div style="margin-bottom:8px; font-weight:500; color:#197278;">Komponen:</div>
                    <ul style="padding-left:18px; margin-bottom:8px;">
                    <?php while($item = mysqli_fetch_assoc($q_items)): ?>
                        <li>
                            <?= htmlspecialchars($item['nama']) ?> (<?= $item['qty'] ?>x)
                            <span style="font-size:0.9em; color:<?= $item['stok']<5?'#dc3545':($item['stok']<10?'#ffc107':'#28a745') ?>;">[Stok: <?= $item['stok'] ?>]</span>
                        </li>
                    <?php endwhile; ?>
                    </ul>
                </div>
            </a>
            <a href="transaksi_bundle.php?id=<?= $bundle['id'] ?>" class="btn-proses" style="width:100%;margin-top:8px;">Proses Bundle</a>
        </div>
    <?php endwhile; ?>
    </div>
    <?php endif; ?>
</div>

<?php if($user['role'] == 'admin'): ?>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
new Chart(ctx, {
                type: 'line',
                data: {
        labels: <?= json_encode($labels) ?>,
                    datasets: [{
            label: 'Total Penjualan',
            data: <?= json_encode($data) ?>,
                        borderColor: '#197278',
                        backgroundColor: 'rgba(25, 114, 120, 0.1)',
            borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
        maintainAspectRatio: false,
                    plugins: {
                        legend: {
                display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp. ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
    </script>
    <?php endif; ?>
</body>
</html> 