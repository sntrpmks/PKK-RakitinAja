<?php
session_start();
if (!isset($_SESSION['login'])) header("Location: login.php");
include '../config/db.php';
$user = $_SESSION['user'];
$transaksi_id = isset($_SESSION['nota']) ? $_SESSION['nota'] : (isset($_GET['id']) ? intval($_GET['id']) : 0);

if (!$transaksi_id) {
    die('ID Transaksi tidak ditemukan.');
}

$q_transaksi = mysqli_query($koneksi, "SELECT t.*, b.nama as nama_bundle FROM transaksi t LEFT JOIN bundle b ON t.bundle_id = b.id WHERE t.id = $transaksi_id");
$transaksi = mysqli_fetch_assoc($q_transaksi);

if (!$transaksi) {
    die('Data Transaksi tidak ditemukan.');
}

$q_detail = mysqli_query($koneksi, "SELECT dt.*, p.nama as nama_produk, p.gambar FROM detail_transaksi dt JOIN produk p ON dt.produk_id = p.id WHERE dt.transaksi_id = $transaksi_id");

$nama_kasir = $_SESSION['nama_kasir'] ?? $user['username'];
$uang_diberikan = $_SESSION['uang_diberikan'] ?? $transaksi['total'];
$kembalian = $_SESSION['kembalian'] ?? ($uang_diberikan - $transaksi['total']);

unset($_SESSION['nota']);
unset($_SESSION['nama_kasir']);
unset($_SESSION['uang_diberikan']);
unset($_SESSION['kembalian']);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Nota Transaksi #<?= $transaksi_id ?> - RakitinAja</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .nota-container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: var(--shadow);
            padding: 32px;
            font-family: 'Consolas', 'Courier New', monospace; /* Font gaya nota/struk */
            color: #333;
        }
        .nota-header {
            text-align: center;
            margin-bottom: 24px;
            border-bottom: 2px dashed #ccc;
            padding-bottom: 16px;
        }
        .nota-header h2 {
            margin: 0 0 8px 0;
            color: var(--primary);
            font-size: 1.8em;
        }
        .nota-header p {
            margin: 0 0 4px 0;
            font-size: 0.9em;
            color: #555;
        }
        .nota-info {
            margin-bottom: 24px;
            font-size: 0.9em;
        }
        .nota-info p {
            margin: 4px 0;
        }
        .nota-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        .nota-table th, .nota-table td {
            padding: 8px 0;
            text-align: left;
            font-size: 0.9em;
        }
         .nota-table td.qty, .nota-table td.harga, .nota-table td.subtotal {
             text-align: right;
             padding-right: 5px;
         }
         .nota-table th {
             border-bottom: 1px dashed #ccc;
             font-weight: 600;
             padding-bottom: 4px;
         }
        .nota-table td {
            border-bottom: 1px dashed #eee;
            padding-top: 4px;
            padding-bottom: 4px;
        }
         .nota-table tr:last-child td {
             border-bottom: none;
         }
         .nota-item-bundle {
             font-weight: 600;
             color: var(--primary);
             margin-top: 8px;
             padding-top: 8px;
             padding-bottom: 4px;
             border-bottom: 1px dashed #ccc;
         }
         .nota-item-komponen {
             font-size: 0.85em;
             color: #555;
             padding-left: 10px;
             padding-top: 2px;
             padding-bottom: 2px;
         }
        .nota-summary {
            margin-top: 24px;
            border-top: 2px dashed #ccc;
            padding-top: 16px;
            font-size: 1em;
        }
        .nota-summary .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .nota-summary .row span:last-child {
            font-weight: 600;
            color: var(--primary);
        }
         .nota-summary .row.total span:last-child {
             font-size: 1.2em;
         }
        .nota-footer {
            text-align: center;
            margin-top: 32px;
            padding-top: 16px;
            border-top: 2px dashed #ccc;
            font-size: 0.9em;
            color: #666;
        }
        @media print {
            body { background: none; }
            .sidebar, .content h2, .nota-action { display: none; }
            .nota-container { box-shadow: none; margin: 0; padding: 0; max-width: none; font-size: 10pt; width: 100%; box-sizing: border-box; }
            .nota-header, .nota-info, .nota-table, .nota-summary, .nota-footer { border-color: #000 !important; }
            
            .nota-table { width: 100% !important; }
            .nota-table th, .nota-table td {
                 font-size: 9pt;
                 padding: 1px 0;
                 border-bottom-color: #000 !important;
            }
             .nota-table th {
                 border-bottom-width: 1px !important;
                 padding-bottom: 2px;
             }
             .nota-table td.qty, .nota-table td.harga, .nota-table td.subtotal {
                  padding-right: 2px;
             }
            .nota-item-bundle {
                 font-size: 9pt;
                 margin-top: 4px;
                 padding-top: 4px;
                 padding-bottom: 2px;
                 border-bottom-color: #000 !important;
                 font-weight: 700;
             }
             .nota-item-komponen {
                 font-size: 8pt;
                 padding-left: 8px;
                  padding-top: 1px;
                  padding-bottom: 1px;
             }

             .nota-summary {
                 margin-top: 15px;
                 padding-top: 8px;
                 border-top-color: #000 !important;
             }
             .nota-summary .row { font-size: 9pt; margin-bottom: 3px;}
             .nota-summary .row span:last-child { font-weight: 700; }
             .nota-summary .row.total span:last-child { font-size: 10pt; }
             
             .nota-footer { font-size: 8pt; margin-top: 10px; padding-top: 5px; border-top-color: #000 !important; }
        }
    </style>
</head>
<body>
<?php include 'sidebar.php';?>
<div class="content">
    <div class="nota-container">
        <div class="nota-header">
            <h2>RakitinAja</h2>
            <p>Nota Transaksi #<?= $transaksi['id'] ?></p>
            <p><?= date('d M Y H:i', strtotime($transaksi['tanggal'])) ?></p>
        </div>
        <div class="nota-info">
            <p>Kasir: <?= htmlspecialchars($nama_kasir) ?></p>
            <p>Jenis Transaksi: <?= $transaksi['bundle_id'] ? 'Bundle Paket' : 'Produk Satuan' ?></p>
        </div>

        <table class="nota-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="qty">Qty</th>
                    <th class="harga">Harga</th>
                    <th class="subtotal">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($transaksi['bundle_id']):?>
                    <tr>
                        <td colspan="4" class="nota-item-bundle">Bundle: <?= htmlspecialchars($transaksi['nama_bundle']) ?></td>
                    </tr>
                     <?php mysqli_data_seek($q_detail, 0);?>
                     <?php while($item = mysqli_fetch_assoc($q_detail)): ?>
            <tr>
                            <td class="nota-item-komponen">- <?= htmlspecialchars($item['nama_produk']) ?></td>
                            <td class="qty"><?= $item['jumlah'] ?></td>
                            <td class="harga">Rp. <?= number_format($item['harga']) ?></td>
                            <td class="subtotal">Rp. <?= number_format($item['subtotal']) ?></td>
                         </tr>
                     <?php endwhile; ?>
                <?php else:?>
                    <?php while($item = mysqli_fetch_assoc($q_detail)): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['nama_produk']) ?></td>
                        <td class="qty"><?= $item['jumlah'] ?></td>
                        <td class="harga">Rp. <?= number_format($item['harga']) ?></td>
                        <td class="subtotal">Rp. <?= number_format($item['subtotal']) ?></td>
            </tr>
            <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="nota-summary">
            <div class="row">
                <span>Total:</span>
                <span>Rp. <?= number_format($transaksi['total']) ?></span>
            </div>
            <div class="row">
                <span>Bayar:</span>
                <span>Rp. <?= number_format($uang_diberikan) ?></span>
            </div>
            <div class="row total">
                <span>Kembali:</span>
                <span>Rp. <?= number_format($kembalian) ?></span>
            </div>
        </div>

        <div class="nota-footer">
            Terima kasih telah berbelanja di RakitinAja!
        </div>
         <div class="nota-action" style="text-align: center; margin-top: 24px;">
             <button onclick="window.print()" style="padding: 10px 20px; background: var(--primary); color: #fff; border: none; border-radius: 8px; cursor: pointer; font-size: 1em;">Cetak Nota</button>
             <a href="transaksi.php" style="margin-left: 10px; padding: 10px 20px; background: #ccc; color: #333; border: none; border-radius: 8px; text-decoration: none; font-size: 1em;">Transaksi Baru</a>
        </div>
    </div>
</div>
</body>
</html>