<?php
session_start();
if (!isset($_SESSION['login'])) header("Location: login.php");
include '../config/db.php';
$user = $_SESSION['user'];
$error = '';

if (isset($_POST['tambah']) && isset($_POST['id']) && isset($_POST['qty'])) {
    $_SESSION['cart'][$_POST['id']] = $_POST['qty'];
}

if (isset($_POST['tambah_bundle']) && isset($_POST['bundle_id'])) {
    $bundle_id = $_POST['bundle_id'];

    error_log("Bundle ID: " . $bundle_id);

    $q_items = mysqli_query($koneksi, "SELECT bi.*, p.stok, p.nama, p.harga 
                                      FROM bundle_items bi 
                                      JOIN produk p ON bi.produk_id = p.id 
                                      WHERE bi.bundle_id = '$bundle_id'");
    
    if (!$q_items) {
        error_log("Error query: " . mysqli_error($koneksi));
        $error = "Terjadi kesalahan saat mengambil data bundle";
    } else {
        $bisa_ditambahkan = true;
        $error_msg = '';

        while($item = mysqli_fetch_assoc($q_items)) {
            error_log("Checking item: " . $item['nama'] . " - Stok: " . $item['stok'] . " - Qty: " . $item['qty']);
            
            if($item['stok'] < $item['qty']) {
                $bisa_ditambahkan = false;
                $error_msg = "Stok {$item['nama']} tidak mencukupi (tersedia: {$item['stok']}, dibutuhkan: {$item['qty']})";
                break;
            }
        }
        
        if($bisa_ditambahkan) {
            mysqli_data_seek($q_items, 0);

            while($item = mysqli_fetch_assoc($q_items)) {
                error_log("Adding to cart: " . $item['nama'] . " - Qty: " . $item['qty']);
                $_SESSION['cart'][$item['produk_id']] = $item['qty'];
            }

            header("Location: transaksi.php");
            exit();
        } else {
            $error = $error_msg;
        }
    }
}

if (isset($_GET['hapus']) && isset($_GET['id'])) {
    unset($_SESSION['cart'][$_GET['id']]);
    header("Location: transaksi.php");
    exit();
}

$total = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $qty) {
        $q = mysqli_query($koneksi, "SELECT * FROM produk WHERE id='$id'");
        $d = mysqli_fetch_assoc($q);
        $total += $d['harga'] * $qty;
    }
}

if (isset($_POST['bayar'])) {
    $user_id = $user['id'];
    $nama_kasir = isset($_POST['nama_kasir']) ? $_POST['nama_kasir'] : $user['username'];
    $_SESSION['nama_kasir'] = $nama_kasir;
    $uang_diberikan = isset($_POST['uang_diberikan']) ? (int)$_POST['uang_diberikan'] : 0;
    if ($uang_diberikan < $total) {
        $error = 'Uang yang diberikan kurang dari total belanja!';
    } else {
        $kembalian = $uang_diberikan - $total;
        $_SESSION['uang_diberikan'] = $uang_diberikan;
        $_SESSION['kembalian'] = $kembalian;

        $temp_no_transaksi = uniqid('TEMP_REG_', true);

        $insert_transaksi_query = "INSERT INTO transaksi (user_id, nama_kasir, tanggal, total, no_transaksi) VALUES ('$user_id', '$nama_kasir', NOW(), '$total', '$temp_no_transaksi')";

        if (mysqli_query($koneksi, $insert_transaksi_query)) {
        $transaksi_id = mysqli_insert_id($koneksi);

            $final_no_transaksi = 'REG-' . date('Ymd') . '-' . $transaksi_id;

            $update_transaksi_query = "UPDATE transaksi SET no_transaksi = '$final_no_transaksi' WHERE id = $transaksi_id";
            mysqli_query($koneksi, $update_transaksi_query);

        foreach ($_SESSION['cart'] as $id => $qty) {
            $q = mysqli_query($koneksi, "SELECT * FROM produk WHERE id='$id'");
            $d = mysqli_fetch_assoc($q);
            $subtotal = $d['harga'] * $qty;
                mysqli_query($koneksi, "INSERT INTO detail_transaksi (transaksi_id, produk_id, jumlah, harga, subtotal) VALUES ('$transaksi_id', '$id', '$qty', '$d[harga]', '$subtotal')");
            mysqli_query($koneksi, "UPDATE produk SET stok = stok - $qty WHERE id='$id'");
        }

        $_SESSION['nota'] = $transaksi_id;
        unset($_SESSION['cart']);
        header("Location: nota.php");
        exit;

        } else {
            $error = "Terjadi kesalahan saat menyimpan transaksi: " . mysqli_error($koneksi);
            error_log("MySQL Error on INSERT (Regular Transaksi): " . mysqli_error($koneksi));
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Transaksi - RakitinAja</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .transaksi-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }
        
        .produk-select-card, .bundle-select-card {
            background: #fff;
            padding: 24px;
            border-radius: 16px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(25,114,120,0.1);
        }
        
        .tab-container {
            margin-bottom: 24px;
        }
        
        .tab-buttons {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
        }
        
        .tab-button {
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            background: var(--bg);
            color: #666;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .tab-button.active {
            background: var(--primary);
            color: #fff;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .form-group {
            margin-bottom: 16px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        
        .form-control {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1em;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(25,114,120,0.1);
        }
        
        .btn-add {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .btn-add:hover {
            background: #1251a3;
            transform: translateY(-2px);
        }

        .keranjang-card {
            background: #fff;
            padding: 24px;
            border-radius: 16px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(25,114,120,0.1);
        }
        
        .keranjang-card h3 {
            margin-top: 0;
            margin-bottom: 16px;
            color: var(--primary);
        }
        
        .error-msg {
            background: #ff4757;
            color: #fff;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 16px;
        }
        
        .payment-section {
            margin-top: 24px;
        }
        
        .uang-box {
            display: flex;
            gap: 16px;
            align-items: center;
            margin-bottom: 16px;
        }
        
        .uang-box label {
            font-weight: 500;
            color: #333;
        }
        
        .uang-box input {
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1em;
            transition: all 0.3s ease;
        }
        
        .uang-box input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(25,114,120,0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        th {
            background: var(--bg);
            font-weight: 600;
            color: #333;
        }
        
        .btn-hapus {
            background: #ff4757;
            color: #fff;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.9em;
            transition: all 0.3s ease;
        }
        
        .btn-hapus:hover {
            background: #ff6b81;
            transform: translateY(-2px);
        }
        
        .btn-bayar {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 16px 32px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1.1em;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .btn-bayar:hover {
            background: #1251a3;
            transform: translateY(-2px);
        }
        
        .bundle-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 16px;
            margin-top: 16px;
        }
        
        .bundle-card {
            background: var(--bg);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .bundle-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .bundle-image {
            width: 100%;
            height: 150px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        
        .bundle-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        
        .bundle-content {
            padding: 16px;
        }
        
        .bundle-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        
        .bundle-price {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 12px;
        }
        
        .bundle-desc {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 12px;
            line-height: 1.4;
        }

        .bundle-specs {
            background: #fff;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 12px;
        }
        
        .bundle-specs h4 {
            margin: 0 0 8px 0;
            color: #333;
            font-size: 0.9em;
        }
        
        .spec-list {
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: 0.85em;
            color: #666;
        }
        
        .spec-list li {
            display: flex;
            align-items: center;
            margin-bottom: 4px;
        }
        
        .spec-list li:before {
            content: '✓';
            color: var(--primary);
            margin-right: 8px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="content">
    <h2>Transaksi Penjualan</h2>
    <div class="transaksi-container">
        <div class="produk-select-card">
            <div class="tab-container">
                <div class="tab-buttons">
                    <button class="tab-button active" onclick="openTab('produk')">Produk</button>
                    <button class="tab-button" onclick="openTab('bundle')">Bundle</button>
                </div>
                
                <div id="produk" class="tab-content active">
            <form method="post">
                        <div class="form-group">
                <label for="produk_id">Pilih Produk:</label>
                            <select name="id" id="produk_id" class="form-control">
                    <?php
                    $q = mysqli_query($koneksi, "SELECT * FROM produk WHERE stok > 0");
                    while($d = mysqli_fetch_assoc($q)):
                    ?>
                    <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['nama']) ?> (Stok: <?= $d['stok'] ?>)</option>
                    <?php endwhile; ?>
                </select>
                        </div>
                        
                        <div class="form-group">
                <label for="qty">Jumlah:</label>
                            <input type="number" name="qty" id="qty" class="form-control" min="1" value="1">
                        </div>
                        
                        <button type="submit" name="tambah" class="btn-add">Tambah ke Keranjang</button>
            </form>
                </div>
                
                <div id="bundle" class="tab-content">
                    <div class="bundle-grid">
                        <?php
                        $q_bundle = mysqli_query($koneksi, "SELECT * FROM bundle ORDER BY id DESC");
                        while($bundle = mysqli_fetch_assoc($q_bundle)):
                            $diskon = 0;
                            $q_items = mysqli_query($koneksi, "SELECT * FROM bundle_items WHERE bundle_id = {$bundle['id']}");
                            $total_harga = 0;
                            while($item = mysqli_fetch_assoc($q_items)) {
                                $q_produk = mysqli_query($koneksi, "SELECT harga FROM produk WHERE id = {$item['produk_id']}");
                                $produk = mysqli_fetch_assoc($q_produk);
                                $total_harga += $produk['harga'] * $item['qty'];
                            }
                            $diskon = round(($total_harga - $bundle['harga']) / $total_harga * 100);
                        ?>
                        <div class="bundle-card">
                            <div class="bundle-image">
                                <img src="../assets/img/<?= $bundle['gambar'] ?>" alt="<?= htmlspecialchars($bundle['nama']) ?>">
                            </div>
                            <div class="bundle-content">
                                <div class="bundle-title"><?= htmlspecialchars($bundle['nama']) ?></div>
                                <div class="bundle-price">Rp. <?= number_format($bundle['harga']) ?></div>
                                <div class="bundle-desc"><?= htmlspecialchars($bundle['deskripsi']) ?></div>
                                
                                <div class="bundle-specs">
                                    <h4>Spesifikasi Bundle:</h4>
                                    <ul class="spec-list">
                                        <?php
                                        mysqli_data_seek($q_items, 0);
                                        while($item = mysqli_fetch_assoc($q_items)):
                                            $q_produk = mysqli_query($koneksi, "SELECT nama FROM produk WHERE id = {$item['produk_id']}");
                                            $produk = mysqli_fetch_assoc($q_produk);
                                        ?>
                                        <li><?= htmlspecialchars($produk['nama']) ?> (<?= $item['qty'] ?>x)</li>
                                        <?php endwhile; ?>
                                    </ul>
                                </div>

                                <a href="transaksi_bundle.php?id=<?= $bundle['id'] ?>" class="btn-add">Proses Bundle</a>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="keranjang-card">
            <h3>Keranjang Belanja</h3>
            <?php if($error): ?><div class="error-msg"><?= $error ?></div><?php endif; ?>
            <form method="post" class="payment-section">
                <div class="uang-box">
                    <label for="nama_kasir">Nama Kasir: </label>
                    <input type="text" name="nama_kasir" id="nama_kasir" value="<?= isset($_POST['nama_kasir']) ? htmlspecialchars($_POST['nama_kasir']) : htmlspecialchars($user['username']) ?>" required>
                </div>

                <table>
                    <thead>
                        <tr><th>Nama</th><th>Qty</th><th>Harga</th><th>Subtotal</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                    <?php
                    $total = 0;
                    if (!empty($_SESSION['cart'])):
                    foreach ($_SESSION['cart'] as $id => $qty):
                        $q = mysqli_query($koneksi, "SELECT * FROM produk WHERE id='$id'");
                        $d = mysqli_fetch_assoc($q);
                        $subtotal = $d['harga'] * $qty;
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($d['nama']) ?></td>
                        <td><?= $qty ?></td>
                        <td>Rp. <?= number_format($d['harga']) ?></td>
                        <td>Rp. <?= number_format($subtotal) ?></td>
                        <td>
                            <a href="?hapus=1&id=<?= $id ?>" class="btn-hapus" onclick="return confirm('Hapus item ini dari keranjang?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="5" style="text-align:center;">Keranjang kosong</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>

                <div class="uang-box">
                    <label for="uang_diberikan">Uang Diberikan: </label>
                    <input type="number" name="uang_diberikan" id="uang_diberikan" required>
                </div>

                <div class="uang-box">
                    <label>Total: </label>
                    <span style="font-weight: 600; color: var(--primary);">Rp. <?= number_format($total) ?></span>
                </div>

                <button type="submit" name="bayar" class="btn-bayar">Bayar</button>
            </form>
        </div>
    </div>
</div>

<script>
function openTab(tabName) {
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });

    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active');
    });

    document.getElementById(tabName).classList.add('active');

    event.currentTarget.classList.add('active');
}
</script>
</body>
</html> 