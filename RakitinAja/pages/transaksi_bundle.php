<?php
session_start();
if (!isset($_SESSION['login'])) header("Location: login.php");
include '../config/db.php';
$user = $_SESSION['user'];
$error = '';

$bundle_id = isset($_GET['id']) ? intval($_GET['id']) : (isset($_POST['bundle_id']) ? intval($_POST['bundle_id']) : 0);

if ($bundle_id && !isset($_SESSION['cart_bundle'][$bundle_id])) {
    $q_items = mysqli_query($koneksi, "SELECT bi.*, p.stok, p.nama, p.harga 
                                      FROM bundle_items bi 
                                      JOIN produk p ON bi.produk_id = p.id 
                                      WHERE bi.bundle_id = '$bundle_id'");
    
    if (!$q_items) {
        error_log("Error query bundle items: " . mysqli_error($koneksi));
        $error = "Terjadi kesalahan saat mengambil data item bundle.";
    } else {
        $bisa_ditambahkan = true;
        $error_msg = '';

        while($item = mysqli_fetch_assoc($q_items)) {
            if($item['stok'] < $item['qty']) {
                $bisa_ditambahkan = false;
                $error_msg = "Stok {$item['nama']} tidak mencukupi (tersedia: {$item['stok']}, dibutuhkan: {$item['qty']}) untuk bundle ini.";
                break;
            }
        }
        
        if($bisa_ditambahkan) {
            mysqli_data_seek($q_items, 0);
            
            $_SESSION['cart'] = [];
            while($item = mysqli_fetch_assoc($q_items)) {
                $_SESSION['cart'][$item['produk_id']] = $item['qty'];
            }
            $_SESSION['cart_bundle'][$bundle_id] = true;
            
        } else {
            $error = $error_msg;
            unset($_SESSION['cart_bundle'][$bundle_id]);
        }
    }
}
if (empty($_SESSION['cart']) && $bundle_id) {
     header("Location: dashboard.php");
     exit();
}

if (isset($_GET['hapus']) && isset($_GET['id'])) {
    unset($_SESSION['cart'][$_GET['id']]);
     if (empty($_SESSION['cart'])) {
         unset($_SESSION['cart_bundle'][$bundle_id]);
         header("Location: dashboard.php");
         exit();
     }
    header("Location: transaksi_bundle.php?id=" . $bundle_id);
    exit();
}

$total = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id_produk => $qty) {
        $q = mysqli_query($koneksi, "SELECT * FROM produk WHERE id='$id_produk'");
        $d = mysqli_fetch_assoc($q);
        $total += $d['harga'] * $qty;
    }
}

$q_bundle_data = mysqli_query($koneksi, "SELECT * FROM bundle WHERE id = $bundle_id");
$bundle_data = mysqli_fetch_assoc($q_bundle_data);

if (isset($_POST['bayar'])) {
    $user_id = $user['id'];
    $nama_kasir = isset($_POST['nama_kasir']) ? $_POST['nama_kasir'] : $user['username'];
    $_SESSION['nama_kasir'] = $nama_kasir;
    $uang_diberikan = isset($_POST['uang_diberikan']) ? (int)$_POST['uang_diberikan'] : 0;

    $total_pembayaran = $bundle_data['harga']; 

    if ($uang_diberikan < $total_pembayaran) {
        $error = 'Uang yang diberikan kurang dari total belanja!';
    } else {
        $kembalian = $uang_diberikan - $total_pembayaran;
        $_SESSION['uang_diberikan'] = $uang_diberikan;
        $_SESSION['kembalian'] = $kembalian;

        $temp_no_transaksi = uniqid('TEMP_', true);

        $insert_transaksi_query = "INSERT INTO transaksi (user_id, nama_kasir, tanggal, total, bundle_id, no_transaksi) VALUES ('$user_id', '$nama_kasir', NOW(), '$total_pembayaran', '$bundle_id', '$temp_no_transaksi')";

        if (mysqli_query($koneksi, $insert_transaksi_query)) {
            $transaksi_id = mysqli_insert_id($koneksi);

            $final_no_transaksi = 'BDL-' . date('Ymd') . '-' . $transaksi_id;

            $update_transaksi_query = "UPDATE transaksi SET no_transaksi = '$final_no_transaksi' WHERE id = $transaksi_id";
            mysqli_query($koneksi, $update_transaksi_query);

            foreach ($_SESSION['cart'] as $id_produk => $qty) {
                $q_produk_detail = mysqli_query($koneksi, "SELECT * FROM produk WHERE id='$id_produk'");
                $d_produk_detail = mysqli_fetch_assoc($q_produk_detail);
                $subtotal_item = $d_produk_detail['harga'] * $qty;

                mysqli_query($koneksi, "INSERT INTO detail_transaksi (transaksi_id, produk_id, jumlah, harga, subtotal) VALUES ('$transaksi_id', '$id_produk', '$qty', '$d_produk_detail[harga]', '$subtotal_item')");

                mysqli_query($koneksi, "UPDATE produk SET stok = stok - $qty WHERE id='$id_produk'");
            }

            $_SESSION['nota'] = $transaksi_id;
            unset($_SESSION['cart']);
            unset($_SESSION['cart_bundle'][$bundle_id]);
            header("Location: nota.php");
            exit;

        } else {
            $error = "Terjadi kesalahan saat menyimpan transaksi: " . mysqli_error($koneksi);
            error_log("MySQL Error on INSERT: " . mysqli_error($koneksi));
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Bundle: <?= htmlspecialchars($bundle_data['nama'] ?? '') ?> - RakitinAja</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .transaksi-bundle-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }
        
        .bundle-info-card, .keranjang-card {
            background: #fff;
            padding: 24px;
            border-radius: 16px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(25,114,120,0.1);
        }
        
        .bundle-info-card h3, .keranjang-card h3 {
            margin-top: 0;
            margin-bottom: 16px;
            color: var(--primary);
        }

         .bundle-info-card img {
            max-width: 100%;
            height: 150px;
            object-fit: contain;
            background: var(--bg);
            border-radius: 10px;
            margin-bottom: 16px;
         }

         .bundle-info-card .detail-row {
             display: flex;
             justify-content: space-between;
             margin-bottom: 8px;
             padding-bottom: 8px;
             border-bottom: 1px solid #eee;
         }

         .bundle-info-card .detail-row span:first-child {
             font-weight: 500;
             color: #555;
         }

          .bundle-info-card .detail-row span:last-child {
             font-weight: 600;
             color: var(--primary);
          }

         .bundle-info-card .desc {
             font-size: 0.95em;
             color: #666;
             margin-top: 16px;
             padding-top: 16px;
             border-top: 1px solid #eee;
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
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="content">
    <h2>Transaksi Bundle: <?= htmlspecialchars($bundle_data['nama'] ?? '') ?></h2>
    <div class="transaksi-bundle-container">
        <div class="bundle-info-card">
            <h3>Detail Bundle</h3>
            <?php if($bundle_data): ?>
                <img src="../assets/img/<?= $bundle_data['gambar'] ?>" alt="<?= htmlspecialchars($bundle_data['nama']) ?>">
                <div class="detail-row">
                    <span>Nama Bundle:</span><span><?= htmlspecialchars($bundle_data['nama']) ?></span>
                </div>
                 <div class="detail-row">
                    <span>Harga Bundle:</span><span>Rp. <?= number_format($bundle_data['harga']) ?></span>
                </div>
                 <?php if(!empty($bundle_data['deskripsi'])): ?>
                 <div class="desc"><b>Deskripsi:</b><br><?= nl2br(htmlspecialchars($bundle_data['deskripsi'])) ?></div>
                 <?php endif; ?>
            <?php else: ?>
                <div class="error-msg">Bundle tidak ditemukan.</div>
            <?php endif; ?>
        </div>

        <div class="keranjang-card">
            <h3>Item dalam Bundle</h3>
            <?php if($error): ?><div class="error-msg"><?= $error ?></div><?php endif; ?>
            <form method="post" class="payment-section">
                <input type="hidden" name="bundle_id" value="<?= $bundle_id ?>">
                <div class="uang-box">
                    <label for="nama_kasir">Nama Kasir: </label>
                    <input type="text" name="nama_kasir" id="nama_kasir" value="<?= isset($_POST['nama_kasir']) ? htmlspecialchars($_POST['nama_kasir']) : htmlspecialchars($user['username']) ?>" required>
                </div>

                <table>
                    <thead>
                        <tr><th>Nama</th><th>Qty</th><th>Harga Satuan</th><th>Subtotal</th></tr>
                    </thead>
                    <tbody>
                    <?php
                    if (!empty($_SESSION['cart'])):
                    foreach ($_SESSION['cart'] as $id_produk => $qty):
                        $q_item_detail = mysqli_query($koneksi, "SELECT * FROM produk WHERE id='$id_produk'");
                        $d_item_detail = mysqli_fetch_assoc($q_item_detail);
                        $subtotal_item = $d_item_detail['harga'] * $qty;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($d_item_detail['nama']) ?></td>
                        <td><?= $qty ?></td>
                        <td>Rp. <?= number_format($d_item_detail['harga']) ?></td>
                        <td>Rp. <?= number_format($subtotal_item) ?></td>
                        <?= $id_produk ?>
                    </tr>
                    <?php endforeach; else: ?>
                     <tr><td colspan="4" style="text-align:center;">Tidak ada item dalam bundle atau stok tidak mencukupi.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>

                <div class="uang-box">
                    <label for="uang_diberikan">Uang Diberikan: </label>
                    <input type="number" name="uang_diberikan" id="uang_diberikan" required>
                </div>

                <div class="uang-box">
                    <label>Total Pembayaran: </label>
                    <span style="font-weight: 600; color: var(--primary);">Rp. <?= number_format($bundle_data['harga'] ?? 0) ?></span>
                </div>

                <?php if (!empty($_SESSION['cart']) && $bundle_data): ?>
                <button type="submit" name="bayar" class="btn-bayar">Bayar</button>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
</body>
</html> 