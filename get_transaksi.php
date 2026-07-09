<?php 
// mengambil file koneksi ke database 
require_once('conn.php'); 
 
// Ambil parameter dari URL (gunakan ternary operator untuk menghindari error) 
$role = isset($_GET['role']) ? $_GET['role'] : ''; 
$id_user = isset($_GET['id_user']) ? $_GET['id_user'] : ''; 
$id_usaha = isset($_GET['id_usaha']) ? $_GET['id_usaha'] : ''; 
 
// Cek apakah parameter penting tersedia 
if ($role === 'admin' && empty($id_usaha)) { 
    die(json_encode(['error' => 'id_usaha wajib dikirim untuk role admin'])); 
} elseif ($role === 'karyawan' && empty($id_user)) { 
    die(json_encode(['error' => 'id_user wajib dikirim untuk role karyawan'])); 
} 
 
// Siapkan query dasar 
$query = ""; 
 
// Cek role untuk menentukan query 
if ($role === 'admin') { 
    // Query untuk Admin (berdasarkan id_usaha) 
    $query = "SELECT u.id_user, u.nama_user, t.tgl_transaksi, t.nilai_transaksi, t.ket_transaksi, 
t.status 
              FROM tbl_transaksi t 
              INNER JOIN tbl_user u ON t.id_user = u.id_user 
              WHERE u.level='$role' and t.id_usaha = '$id_usaha' 
              ORDER BY DATE(t.tgl_transaksi) DESC"; 
} else { 
    // Query untuk Karyawan (berdasarkan id_user) 
    $query = "SELECT u.id_user, u.nama_user, t.tgl_transaksi, t.nilai_transaksi, t.ket_transaksi, 
t.status 
              FROM tbl_transaksi t 
              INNER JOIN tbl_user u ON t.id_user = u.id_user 
              WHERE u.id_user = '$id_user' 
              ORDER BY DATE(t.tgl_transaksi) DESC"; 
} 
 
// Eksekusi query 
$result = mysqli_query($connect, $query); 
// Cek jika query gagal 
if (!$result) { 
die('Query failed: ' . mysqli_error($connect)); 
} 
// Ambil data dan ubah ke dalam array 
$data = array(); 
while ($row = mysqli_fetch_assoc($result)) { 
$row['tgl_transaksi'] = date('Y-m-d', strtotime($row['tgl_transaksi'])); 
$data[] = $row; 
} 
// Ubah ke format JSON 
echo json_encode($data); 
?> 
