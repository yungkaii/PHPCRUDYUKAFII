<?php

// Koneksi database
include __DIR__ . '/koneksi.php';

// Ambil data dari form (safely)
$nis         = isset($_POST['nis']) ? (int) $_POST['nis'] : 0;
$nama        = isset($_POST['nama']) ? trim($_POST['nama']) : '';
$jk          = isset($_POST['jk']) ? $_POST['jk'] : '';
$tgl_lahir   = isset($_POST['tgl_lahir']) ? $_POST['tgl_lahir'] : null;
$kelas       = isset($_POST['kelas']) ? (int) $_POST['kelas'] : 0;
$jurusan     = isset($_POST['jurusan']) ? (int) $_POST['jurusan'] : 0;
$keterangan  = isset($_POST['keterangan']) ? trim($_POST['keterangan']) : '';

// Basic validation
if ($nis <= 0 || $nama === '') {
    header('Location: tambahsiswa.php?error=missing');
    exit;
}

// Insert using prepared statement
$stmt = mysqli_prepare($koneksi, "INSERT INTO siswa (nis, nama, jk, tgl_lahir, kelas, jurusan, keterangan) VALUES (?, ?, ?, ?, ?, ?, ?)");
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'isssiis', $nis, $nama, $jk, $tgl_lahir, $kelas, $jurusan, $keterangan);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
} else {
    die('Prepare failed: ' . mysqli_error($koneksi));
}

// Arahkan kembali
header('Location: siswa.php');
exit;
?>