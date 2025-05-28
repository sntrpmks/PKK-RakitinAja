<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

include '../config/db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
    exit;
}

$user_id = $data['user_id'];
$komponen = $data['komponen'];
$total_harga = $data['total_harga'];

$tanggal = date('Y-m-d H:i:s');
$komponen_json = json_encode($komponen);

$query = "INSERT INTO konfigurasi_pc (user_id, komponen, total_harga, tanggal) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "iids", $user_id, $komponen_json, $total_harga, $tanggal);

if (mysqli_stmt_execute($stmt)) {
    $id = mysqli_insert_id($koneksi);
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'id' => $id]);
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Database error']);
}

mysqli_stmt_close($stmt);
?> 