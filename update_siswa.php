<?php

// Koneksi database
include __DIR__ . '/koneksi.php';

// Menangkap dan membersihkan data yang dikirim dari form
$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
$siswa = isset($_POST['siswa']) ? trim($_POST['siswa']) : '';
$jk = isset($_POST['jk']) ? $_POST['jk'] : '';
$tanggal_lahir = isset($_POST['tanggal_lahir']) ? $_POST['tanggal_lahir'] : null;
$id_kelas = isset($_POST['id_kelas']) ? (int) $_POST['id_kelas'] : null;
$id_jurusan = isset($_POST['id_jurusan']) ? (int) $_POST['id_jurusan'] : null;
$keterangan = isset($_POST['keterangan']) ? trim($_POST['keterangan']) : '';

// Basic validation
if ($id <= 0) {
	header('Location: /akademik/siswa.php');
	exit;
}

// Update data ke database using prepared statement
$stmt = mysqli_prepare($koneksi, "UPDATE siswa SET nama = ?, jk = ?, tgl_lahir = ?, kelas = ?, jurusan = ?, keterangan = ? WHERE id = ?");
if ($stmt) {
	mysqli_stmt_bind_param($stmt, 'sssiisi', $siswa, $jk, $tanggal_lahir, $id_kelas, $id_jurusan, $keterangan, $id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
} else {
	// In development, show DB error. In production, log instead.
	die('Prepare failed: ' . mysqli_error($koneksi));
}

// Mengalihkan halaman kembali ke siswa.php
header('Location: /akademik/siswa.php');
exit;
?>