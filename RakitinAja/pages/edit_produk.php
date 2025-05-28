<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['user']['role']!='admin') header("Location: login.php");
include '../config/db.php';
$kategoriList = ['Processor', 'RAM', 'Graphics Card', 'Motherboard', 'Power Supply', 'Casing', 'Storage', 'Software', 'Lainnya'];
$id = $_GET['id'];
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];
    if ($_FILES['gambar']['name']) {
        $gambar = $_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], "../assets/img/".$gambar);
        mysqli_query($koneksi, "UPDATE produk SET nama='$nama', harga='$harga', stok='$stok', gambar='$gambar', kategori='$kategori' WHERE id='$id'");
    } else {
        mysqli_query($koneksi, "UPDATE produk SET nama='$nama', harga='$harga', stok='$stok', kategori='$kategori' WHERE id='$id'");
    }
    header("Location: dashboard.php");
}
$q = mysqli_query($koneksi, "SELECT * FROM produk WHERE id='$id'");
$d = mysqli_fetch_assoc($q);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk - RakitinAja</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="content">
    <h2>Edit Komponen Komputer</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="nama" value="<?= $d['nama'] ?>" required><br>
        <select name="kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <?php foreach($kategoriList as $kat): ?>
                <option value="<?= $kat ?>" <?= $d['kategori']==$kat?'selected':'' ?>><?= ucfirst($kat) ?></option>
            <?php endforeach; ?>
        </select><br>
        <input type="number" name="harga" value="<?= $d['harga'] ?>" required><br>
        <input type="number" name="stok" value="<?= $d['stok'] ?>" required><br>
        <img src="../assets/img/<?= $d['gambar'] ?>" width="80"><br>
        <input type="file" name="gambar"><br>
        <button name="simpan">Update</button>
    </form>
</div>
</body>
</html> 