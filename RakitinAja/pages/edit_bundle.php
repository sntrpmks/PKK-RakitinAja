<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['user']['role']!='admin') header("Location: login.php");
include '../config/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$q_bundle = mysqli_query($koneksi, "SELECT * FROM bundle WHERE id = $id");
$bundle = mysqli_fetch_assoc($q_bundle);

if (!$bundle) {
    die('Bundle tidak ditemukan.');
}

$q_bundle_items = mysqli_query($koneksi, "SELECT * FROM bundle_items WHERE bundle_id = $id");
$bundle_items = [];
while($item = mysqli_fetch_assoc($q_bundle_items)) {
    $bundle_items[] = $item;
}

$q_produk = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY nama ASC");

if(isset($_POST['update_bundle'])) {
    $nama = $_POST['nama_bundle'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga_bundle'];

    $gambar = $bundle['gambar'];
    if($_FILES['gambar_bundle']['name']) {
        if($bundle['gambar']) {
            unlink("../assets/img/" . $bundle['gambar']);
        }
        $gambar_baru = $_FILES['gambar_bundle']['name'];
        $tmp = $_FILES['gambar_bundle']['tmp_name'];
        $ext = pathinfo($gambar_baru, PATHINFO_EXTENSION);
        $gambar = uniqid() . '.' . $ext;
        move_uploaded_file($tmp, "../assets/img/$gambar");
    }
 
    mysqli_query($koneksi, "UPDATE bundle SET nama='$nama', deskripsi='$deskripsi', harga='$harga', gambar='$gambar' WHERE id=$id");

    mysqli_query($koneksi, "DELETE FROM bundle_items WHERE bundle_id = $id");

    if(isset($_POST['produk_id'])) {
        foreach($_POST['produk_id'] as $key => $produk_id) {
            $qty = $_POST['qty'][$key];
            if ($produk_id && $qty > 0) {
                 mysqli_query($koneksi, "INSERT INTO bundle_items (bundle_id, produk_id, qty) VALUES ('$id', '$produk_id', '$qty')");
            }
        }
    }
    
    header("Location: laporan.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Bundle - RakitinAja</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .edit-container {
            background: #fff;
            padding: 32px;
            border-radius: 20px;
            box-shadow: var(--shadow);
            margin-bottom: 24px;
            border: 1px solid rgba(25,114,120,0.1);
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
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
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
        
        .current-image {
            margin-top: 12px;
            display: block;
            max-width: 150px;
            height: auto;
        }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="content">
    <div class="edit-container">
        <h2>Edit Bundle Paket: <?= htmlspecialchars($bundle['nama']) ?></h2>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_bundle">Nama Bundle</label>
                <input type="text" name="nama_bundle" id="nama_bundle" class="form-control" value="<?= htmlspecialchars($bundle['nama']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" required><?= htmlspecialchars($bundle['deskripsi']) ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="harga_bundle">Harga Bundle</label>
                <input type="number" name="harga_bundle" id="harga_bundle" class="form-control" value="<?= $bundle['harga'] ?>" required>
            </div>
            
            <div class="form-group">
                <label for="gambar_bundle">Gambar Bundle</label>
                <input type="file" name="gambar_bundle" id="gambar_bundle" class="form-control" accept="image/*">
                <?php if($bundle['gambar']): ?>
                    <img src="../assets/img/<?= $bundle['gambar'] ?>" class="current-image" alt="Current Bundle Image">
                <?php endif; ?>
            </div>
            
            <div class="items-container">
                <h3>Komponen Bundle</h3>
                <div id="items">
                    <?php if (!empty($bundle_items)): ?>
                        <?php foreach($bundle_items as $item): ?>
                            <div class="item-row">
                                <select name="produk_id[]" class="form-control" required>
                                    <option value="">Pilih Produk</option>
                                    <?php 
                                    mysqli_data_seek($q_produk, 0);
                                    while($p = mysqli_fetch_assoc($q_produk)): 
                                    ?>
                                    <option value="<?= $p['id'] ?>" <?= $p['id'] == $item['produk_id'] ? 'selected' : '' ?>><?= htmlspecialchars($p['nama']) ?> - Rp. <?= number_format($p['harga']) ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <input type="number" name="qty[]" class="form-control" placeholder="Jumlah" min="1" value="<?= $item['qty'] ?>" required>
                                <button type="button" class="btn-remove" onclick="this.parentElement.remove()">×</button>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                         <div class="item-row">
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
                        </div>
                    <?php endif; ?>
                </div>
                
                <button type="button" class="btn-add" onclick="addItem()">+ Tambah Komponen</button>
            </div>
            
            <button type="submit" name="update_bundle" class="btn-submit">Update Bundle</button>
        </form>
    </div>
</div>

<script>
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