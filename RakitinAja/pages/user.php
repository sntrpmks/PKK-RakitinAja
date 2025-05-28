<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['user']['role']!='admin') header("Location: login.php");
include '../config/db.php';

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    mysqli_query($koneksi, "DELETE FROM detail_transaksi WHERE transaksi_id IN (SELECT id FROM transaksi WHERE user_id = '$id')");

    mysqli_query($koneksi, "DELETE FROM transaksi WHERE user_id = '$id'");

    mysqli_query($koneksi, "DELETE FROM users WHERE id = '$id'");
    
    header("Location: user.php");
}

if (isset($_POST['tambah'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    mysqli_query($koneksi, "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')");
    header("Location: user.php");
}

$q = mysqli_query($koneksi, "SELECT * FROM users");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manajemen User - RakitinAja</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .user-card {background:#fff;padding:32px 36px;border-radius:16px;box-shadow:0 2px 16px rgba(25,114,120,0.10);max-width:700px;margin-bottom:24px;}
        .user-card h2 {margin-top:0;margin-bottom:18px;color:#197278;}
        .user-card form { display: flex; flex-direction: column; gap: 16px; margin-bottom: 24px; }
        .user-card .form-group { display: flex; flex-direction: column; }
        .user-card .form-group label { font-weight: bold; margin-bottom: 6px; color: #555; }
        .user-card .form-group input, .user-card .form-group select { padding: 10px 14px; border-radius: 8px; border: 1px solid #e0e0e0; font-size: 1em; }
        .user-card form button { padding: 12px 20px; border-radius: 8px; background:#197278; color:#fff; border:none; font-weight:bold; cursor:pointer; transition:background .2s; font-size: 1.1em; margin-top: 8px; }
        .user-card form button:hover { background:#1251a3; }
        .user-card table {width:100%;margin-top:10px;border-collapse: separate; border-spacing: 0;}
        .user-card th {background:#197278;color:#fff;font-weight:bold;text-align:left;padding:12px 15px;}
        .user-card td {padding:10px 15px;text-align:left;border-bottom:1px solid #eee;}
        .user-card th:first-child { border-top-left-radius: 10px; }
        .user-card th:last-child { border-top-right-radius: 10px; }
        .user-card tr:last-child td { border-bottom: none; }
        .user-card tr:nth-child(even) {background:#f9f9f9;}
        .btn-hapus {background:#e74c3c;color:#fff;padding:6px 12px;border:none;border-radius:6px;cursor:pointer;font-weight:normal;transition:background .2s;font-size:0.9em;}
        .btn-hapus:hover {background:#b71c1c;}
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="content">
    <div class="user-card">
    <h2>Manajemen User</h2>
    <form method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" placeholder="Username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Password" required>
        </div>
        <div class="form-group">
            <label for="role">Role:</label>
            <select name="role" id="role">
                <option value="admin">Admin</option>
                <option value="kasir">Kasir</option>
            </select>
        </div>
        <button name="tambah">Tambah User</button>
    </form>
    <table border="0" cellpadding="0" cellspacing="0">
        <thead>
            <tr><th>No</th><th>Username</th><th>Password</th><th>Role</th><th>Aksi</th></tr>
        </thead>
        <tbody>
        <?php $no=1; while($d = mysqli_fetch_assoc($q)): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($d['username']) ?></td>
            <td><?= htmlspecialchars($d['password']) ?></td>
            <td><?= ucfirst($d['role']) ?></td>
            <td>
                <?php if($d['username']!='admin'): ?>
                <a href="?hapus=<?= $d['id'] ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>
</body>
</html> 