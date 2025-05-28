<?php
session_start();
if (!isset($_SESSION['login'])) header("Location: login.php");
include '../config/db.php';
$type = isset($_GET['type']) ? $_GET['type'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($type == 'produk') {
    $q = mysqli_query($koneksi, "SELECT * FROM produk WHERE id = $id");
    $data = mysqli_fetch_assoc($q);
    if (!$data) die('Produk tidak ditemukan');
} elseif ($type == 'bundle') {
    $q = mysqli_query($koneksi, "SELECT * FROM bundle WHERE id = $id");
    $data = mysqli_fetch_assoc($q);
    if (!$data) die('Bundle tidak ditemukan');
    $q_items = mysqli_query($koneksi, "SELECT bi.*, p.nama, p.harga, p.stok, p.gambar, p.spesifikasi FROM bundle_items bi JOIN produk p ON bi.produk_id = p.id WHERE bi.bundle_id = $id");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Spesifikasi <?= $type == 'produk' ? 'Produk' : 'Bundle' ?> - RakitinAja</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .spesifikasi-container {
            max-width: 1000px;
            margin: 40px auto;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(25,114,120,0.1);
            padding: 32px;
            border: 1px solid rgba(25,114,120,0.1);
        }
        .spesifikasi-header {
            display: flex;
            gap: 32px;
            align-items: flex-start;
            margin-bottom: 32px;
            padding-bottom: 32px;
            border-bottom: 1px dashed #ccc;
        }
        .spesifikasi-header img {
            width: 220px;
            height: 220px;
            object-fit: contain;
            border-radius: 16px;
            background: #f5f5f5;
            box-shadow: 0 2px 8px rgba(25,114,120,0.07);
            border: 1px solid #eee;
        }
        .spesifikasi-info {
            flex: 1;
        }
        .spesifikasi-info h2 {
            margin: 0 0 12px 0;
            color: var(--primary);
            font-size: 2.2em;
            font-weight: 700;
        }
        .spesifikasi-info .harga {
            color: var(--primary);
            font-size: 1.4em;
            font-weight: 700;
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid #eee;
        }
        .spesifikasi-info .desc {
            color: #555;
            margin-bottom: 16px;
            font-size: 1em;
            line-height: 1.6;
        }
        .spesifikasi-info .spesifikasi {
            color: #333;
            background: #f8f9fa;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 16px;
            font-size: 1em;
            line-height: 1.5;
            border: 1px solid #eee;
        }
        .bundle-komponen {
            margin-top: 32px;
            padding-top: 32px;
            border-top: 1px dashed #ccc;
        }
        .bundle-komponen h3 {
            color: var(--primary);
            font-size: 1.5em;
            font-weight: 600;
            margin-bottom: 18px;
        }
        .komponen-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .komponen-item {
            display: flex;
            align-items: center;
            gap: 20px;
            background: #f8f9fa;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 16px;
            box-shadow: 0 1px 6px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            border: 1px solid #eee;
        }
         .komponen-item:hover {
             background: #f0f0f0;
         }
        .komponen-item img {
            width: 70px;
            height: 70px;
            object-fit: contain;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 1px 4px rgba(25,114,120,0.07);
             border: 1px solid #eee;
        }
        .komponen-info {
            flex: 1;
        }
        .komponen-info .nama {
            font-weight: 600;
            color: #333;
            font-size: 1.1em;
            margin-bottom: 4px;
        }
        .komponen-info .qty {
            color: var(--primary);
            font-size: 1em;
            font-weight: 500;
            margin-left: 8px;
        }
        .komponen-info .harga {
            color: #666;
            font-size: 0.95em;
        }
        .komponen-info .stok {
            font-size: 0.9em;
            margin-left: 12px;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 500;
        }
        .komponen-info .stok.low { background: #ffe5e5; color: #dc3545; }
        .komponen-info .stok.medium { background: #fff3cd; color: #ffc107; }
        .komponen-info .stok.safe { background: #d4edda; color: #28a745; }
         .komponen-spesifikasi {
             font-size: 0.9em;
             color: #555;
             margin-top: 8px;
             padding-top: 8px;
             border-top: 1px dashed #ddd;
         }

        .bundle-layout-grid {
            display: grid;
            grid-template-columns: 1.2fr 2fr;
            gap: 40px;
        }

        .bundle-info-section .spesifikasi-header {
            display: flex;
            gap: 32px;
            align-items: flex-start;
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        
        .bundle-info-section .spesifikasi-header img {
            width: 180px;
            height: 180px;
            margin-bottom: 24px;
        }

        .bundle-info-section .spesifikasi-info {
            flex: none;
            width: 100%;
        }

        .bundle-info-section .spesifikasi-info h2 {
            font-size: 1.8em;
            margin-bottom: 8px;
        }

         .bundle-info-section .spesifikasi-info .harga {
             font-size: 1.2em;
             margin-bottom: 16px;
             padding-bottom: 16px;
             border-bottom: 1px dashed #eee;
         }

        .bundle-info-section .spesifikasi-info .desc {
            font-size: 0.95em;
            color: #555;
            text-align: left;
        }

        .bundle-komponen-section .bundle-komponen {
            margin-top: 0;
            padding-top: 0;
            border-top: none;
        }

        .bundle-komponen-section h3 {
            margin-bottom: 18px;
            font-size: 1.4em;
        }

        .komponen-item {
            display: flex;
            align-items: center;
            gap: 20px;
            background: #f8f9fa;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 16px;
            box-shadow: 0 1px 6px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            border: 1px solid #eee;
        }
         .komponen-item:hover {
             background: #f0f0f0;
         }
        .komponen-item img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 1px 4px rgba(25,114,120,0.07);
             border: 1px solid #eee;
             padding: 4px;
        }
        .komponen-info {
            flex: 1;
        }
        .komponen-info .nama {
            font-weight: 600;
            color: #333;
            font-size: 1em;
            margin-bottom: 2px;
        }
        .komponen-info .qty {
            color: var(--primary);
            font-size: 0.95em;
            font-weight: 500;
            margin-left: 8px;
        }
        .komponen-info .harga {
            color: #666;
            font-size: 0.9em;
        }
        .komponen-info .stok {
            font-size: 0.85em;
            margin-left: 12px;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 500;
        }
        .komponen-info .stok.low { background: #ffe5e5; color: #dc3545; }
        .komponen-info .stok.medium { background: #fff3cd; color: #ffc107; }
        .komponen-info .stok.safe { background: #d4edda; color: #28a745; }
         .komponen-spesifikasi {
             font-size: 0.85em;
             color: #555;
             margin-top: 6px;
             padding-top: 6px;
             border-top: 1px dashed #ddd;
         }

        @media (max-width: 768px) {
             .bundle-layout-grid {
                 grid-template-columns: 1fr;
                 gap: 32px;
             }

             .bundle-info-section .spesifikasi-header {
                 flex-direction: row;
                 text-align: left;
                 align-items: flex-start;
                 margin-bottom: 24px;
                 padding-bottom: 24px;
                 border-bottom: 1px dashed #ccc;
             }

             .bundle-info-section .spesifikasi-header img {
                 width: 120px;
                 height: 120px;
                 margin-bottom: 0;
             }

             .bundle-info-section .spesifikasi-info {
                 flex: 1;
                 width: auto;
             }

             .bundle-info-section .spesifikasi-info h2 {
                 font-size: 1.8em;
             }

             .bundle-komponen-section .bundle-komponen {
                 margin-top: 0;
                 padding-top: 0;
                 border-top: none;
             }

             .komponen-item {
                 flex-direction: column;
                 align-items: flex-start;
                 gap: 12px;
             }

              .komponen-item img {
                 width: 50px;
                 height: 50px;
             }

              .komponen-info .nama, .komponen-info .qty, .komponen-info .harga, .komponen-info .stok {
                 margin-left: 0;
             }

         }

         .spesifikasi-container .btn-proses {
             display: inline-block;
             width: auto;
             padding: 14px 32px;
             font-size: 1.1em;
             font-weight: 700;
             background: var(--gradient);
             color: var(--white);
             border: none;
             border-radius: 12px;
             text-align: center;
             text-decoration: none;
             cursor: pointer;
             transition: var(--transition);
             box-shadow: 0 6px 20px rgba(25,114,120,0.25);
         }

         .spesifikasi-container .btn-proses:hover {
             background: var(--primary-dark);
             transform: translateY(-3px);
             box-shadow: 0 10px 25px rgba(25,114,120,0.35);
         }

    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="content">
    <div class="spesifikasi-container">
        <?php if($type=='bundle'): ?>
            <div class="bundle-layout-grid">
                <div class="bundle-info-section">
                    <div class="spesifikasi-header">
                        <img src="../assets/img/<?= $data['gambar'] ?>" alt="<?= htmlspecialchars($data['nama']) ?>">
                        <div class="spesifikasi-info">
                            <h2><?= htmlspecialchars($data['nama']) ?></h2>
                            <div class="harga">Rp. <?= number_format($data['harga']) ?></div>
                            <div class="desc"><?= htmlspecialchars($data['deskripsi'] ?? '') ?></div>
                        </div>
                    </div>
                </div>
                <div class="bundle-komponen-section">
                    <div class="bundle-komponen">
                        <h3>Spesifikasi Komponen Bundle</h3>
                        <ul class="komponen-list">
                            <?php mysqli_data_seek($q_items, 0); while($item = mysqli_fetch_assoc($q_items)): ?>
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
            <?php if(isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'kasir'): ?>
            <div style="margin-top:32px;">
                <a href="transaksi_bundle.php?id=<?= $data['id'] ?>" class="btn-proses">Proses Bundle</a>
            </div>
            <?php endif; ?>
            <?php if(isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'admin'): ?>
            <div style="margin-top:32px;">
                <a href="edit_bundle.php?id=<?= $data['id'] ?>" class="btn-proses" style="background: var(--primary);">Edit Bundle</a>
            </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="spesifikasi-header">
                <img src="../assets/img/<?= $data['gambar'] ?>" alt="<?= htmlspecialchars($data['nama']) ?>">
                <div class="spesifikasi-info">
                    <h2><?= htmlspecialchars($data['nama']) ?></h2>
                    <div class="harga">Rp. <?= number_format($data['harga']) ?></div>
                    <div class="desc"><?= htmlspecialchars($data['deskripsi'] ?? '') ?></div>
                    <?php if(!empty($data['spesifikasi'])): ?>
                        <div class="spesifikasi"><b>Spesifikasi:</b><br><?= nl2br(htmlspecialchars($data['spesifikasi'])) ?></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html> 