<?php

// Koneksi database
include __DIR__ . '/koneksi.php';

// Ambil dan validasi ID dari URL
$id_kelas = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id_kelas <= 0) {
	header('Location: /akademik/kelas.php');
	exit;
}

// Hapus dengan prepared statement
$stmt = mysqli_prepare($koneksi, "DELETE FROM kelas WHERE id_kelas = ?");
if ($stmt) {
	mysqli_stmt_bind_param($stmt, 'i', $id_kelas);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
}

// Redirect
header('Location: /akademik/kelas.php');
exit;
?>
