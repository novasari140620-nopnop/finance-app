<?php 
require_once('conn.php'); 
$id_user = $_POST['id_user']; 
$id_usaha = $_POST['id_usaha']; 
$tgl_transaksi = $_POST['tgl_transaksi']; 
$nilai_transaksi = $_POST['nilai_transaksi']; 
$ket_transaksi = isset($_POST['ket_transaksi']) ? $_POST['ket_transaksi'] : ''; 
$status = $_POST['status']; 
if (!$id_user || !$id_usaha || !$tgl_transaksi || !$nilai_transaksi || !$status) { 
echo json_encode(array('message' => 'Data tidak lengkap')); 
exit; 
} 
$sql = "INSERT INTO tbl_transaksi (id_user, id_usaha, tgl_transaksi, nilai_transaksi, ket_transaksi, status) 
VALUES ('$id_user', '$id_usaha', '$tgl_transaksi', '$nilai_transaksi', '$ket_transaksi', '$status')"; 
if (mysqli_query($connect, $sql)) { 
echo json_encode(array('message' => 'Data berhasil disimpan')); 
} else { 
echo json_encode(array('message' => 'Gagal menyimpan data: ' . mysqli_error($connect))); 
} 
mysqli_close($connect); 
?>