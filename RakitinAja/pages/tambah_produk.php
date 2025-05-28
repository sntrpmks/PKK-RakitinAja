<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['user']['role']!='admin') header("Location: login.php");
include '../config/db.php';
$kategoriList = ['Processor', 'RAM', 'Graphics Card', 'Motherboard', 'Power Supply', 'Casing', 'Storage', 'Software', 'Lainnya'];

if (isset($_POST['simpan_produk'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];
    $spesifikasi = $_POST['spesifikasi'];
    $gambar = $_FILES['gambar']['name'];
    move_uploaded_file($_FILES['gambar']['tmp_name'], "../assets/img/".$gambar);
    mysqli_query($koneksi, "INSERT INTO produk (nama, harga, stok, gambar, kategori, spesifikasi) VALUES ('$nama', '$harga', '$stok', '$gambar', '$kategori', '$spesifikasi')");
    header("Location: dashboard.php");
}

if(isset($_POST['simpan_bundle'])) {
    $nama = $_POST['nama_bundle'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga_bundle'];

    $gambar = $_FILES['gambar_bundle']['name'];
    $tmp = $_FILES['gambar_bundle']['tmp_name'];
    $ext = pathinfo($gambar, PATHINFO_EXTENSION);
    $gambar = uniqid() . '.' . $ext;
    move_uploaded_file($tmp, "../assets/img/$gambar");

    mysqli_query($koneksi, "INSERT INTO bundle (nama, deskripsi, harga, gambar) VALUES ('$nama', '$deskripsi', '$harga', '$gambar')");
    $bundle_id = mysqli_insert_id($koneksi);

    foreach($_POST['produk_id'] as $key => $produk_id) {
        $qty = $_POST['qty'][$key];
        mysqli_query($koneksi, "INSERT INTO bundle_items (bundle_id, produk_id, qty) VALUES ('$bundle_id', '$produk_id', '$qty')");
    }
    
    header("Location: dashboard.php");
}

$q_produk = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY nama ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk - RakitinAja</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .tambah-container {
            background: #fff;
            padding: 32px;
            border-radius: 20px;
            box-shadow: var(--shadow);
            margin-bottom: 24px;
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
            margin-bottom: 24px;
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
        
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }
        
        .items-container {
            margin-top: 32px;
        }
        
        .item-row {
            display: grid;
            grid-template-columns: 2fr 1fr auto;
            gap: 16px;
            margin-bottom: 16px;
            align-items: center;
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
        }
        
        .btn-add:hover {
            background: #1251a3;
            transform: translateY(-2px);
        }
        
        .btn-remove {
            background: #ff4757;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-remove:hover {
            background: #ff6b81;
            transform: translateY(-2px);
        }
        
        .btn-submit {
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
            margin-top: 32px;
        }
        
        .btn-submit:hover {
            background: #1251a3;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="content">
    <div class="tambah-container">
        <div class="tab-container">
            <div class="tab-buttons">
                <button class="tab-button active" onclick="openTab('produk')">Tambah Produk</button>
                <button class="tab-button" onclick="openTab('bundle')">Tambah Bundle</button>
            </div>
            
            <div id="produk" class="tab-content active">
    <h2>Tambah Komponen Komputer</h2>
    <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nama">Nama Produk</label>
                        <input type="text" name="nama" id="nama" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select name="kategori" id="kategori" class="form-control" required>
            <option value="">-- Pilih Kategori --</option>
            <?php foreach($kategoriList as $kat): ?>
                <option value="<?= $kat ?>"><?= ucfirst($kat) ?></option>
            <?php endforeach; ?>
        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" name="harga" id="harga" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" name="stok" id="stok" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="spesifikasi">Spesifikasi</label>
                        <textarea name="spesifikasi" id="spesifikasi" class="form-control" rows="5" placeholder="Tulis spesifikasi produk di sini..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="gambar">Gambar</label>
                        <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*" required>
                    </div>
                    
                    <button type="submit" name="simpan_produk" class="btn-submit">Simpan Produk</button>
                </form>
            </div>
            
            <div id="bundle" class="tab-content">
                <h2>Tambah Bundle Paket</h2>
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nama_bundle">Nama Bundle</label>
                        <input type="text" name="nama_bundle" id="nama_bundle" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="harga_bundle">Harga Bundle</label>
                        <input type="number" name="harga_bundle" id="harga_bundle" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="gambar_bundle">Gambar Bundle</label>
                        <input type="file" name="gambar_bundle" id="gambar_bundle" class="form-control" accept="image/*" required>
                    </div>
                    
                    <div class="items-container">
                        <h3>Komponen Bundle</h3>
                        <div id="items">
                            <div class="item-row">
                                <select name="produk_id[]" class="form-control" required>
                                    <option value="">Pilih Produk</option>
                                    <?php while($p = mysqli_fetch_assoc($q_produk)): ?>
                                    <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nama']) ?> - Rp. <?= number_format($p['harga']) ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <input type="number" name="qty[]" class="form-control" placeholder="Jumlah" min="1" required>
                                <button type="button" class="btn-remove" onclick="this.parentElement.remove()">×</button>
                            </div>
                        </div>
                        
                        <button type="button" class="btn-add" onclick="addItem()">+ Tambah Komponen</button>
                    </div>
                    
                    <button type="submit" name="simpan_bundle" class="btn-submit">Simpan Bundle</button>
    </form>
            </div>
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

function addItem() {
    const items = document.getElementById('items');
    const itemRow = document.createElement('div');
    itemRow.className = 'item-row';
    itemRow.innerHTML = `
        <select name="produk_id[]" class="form-control" required>
            <option value="">Pilih Produk</option>
            <?php 
            mysqli_data_seek($q_produk, 0);
            while($p = mysqli_fetch_assoc($q_produk)): 
            ?>
            <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nama']) ?> - Rp. <?= number_format($p['harga']) ?></option>
            <?php endwhile; ?>
        </select>
        <input type="number" name="qty[]" class="form-control" placeholder="Jumlah" min="1" required>
        <button type="button" class="btn-remove" onclick="this.parentElement.remove()">×</button>
    `;
    items.appendChild(itemRow);
}
</script>
</body>
</html> 