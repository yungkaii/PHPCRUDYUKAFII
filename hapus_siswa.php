<?php

// Koneksi database (use __DIR__ so include works regardless of caller path)
include __DIR__ . '/koneksi.php';

// Ambil dan validasi NIS dari URL
$nis = isset($_GET['nis']) ? trim($_GET['nis']) : '';
if ($nis === '') {
	header('Location: /akademik/siswa.php');
	exit;
}

// Hapus data dengan prepared statement untuk keamanan (nis as string)
$stmt = mysqli_prepare($koneksi, "DELETE FROM siswa WHERE nis = ?");
if ($stmt) {
	mysqli_stmt_bind_param($stmt, 's', $nis);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
}

// Redirect kembali ke daftar siswa
header('Location: /akademik/siswa.php');
exit;
?>