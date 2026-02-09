<?php

// Koneksi
include __DIR__ . '/koneksi.php';

// Ambil data dari form
$id_kelas = isset($_POST['id_kelas']) ? (int) $_POST['id_kelas'] : 0;
$nama_kelas = isset($_POST['nama_kelas']) ? trim($_POST['nama_kelas']) : '';

if ($id_kelas <= 0) {
    header('Location: /akademik/kelas.php');
    exit;
}

// Basic validation
if ($nama_kelas === '') {
    // Nama kelas wajib diisi — kembali ke form atau ke daftar
    header('Location: /akademik/edit_kelas.php?id=' . $id_kelas);
    exit;
}

// Update using prepared statement — only nama_kelas exists in the schema
$stmt = mysqli_prepare($koneksi, "UPDATE kelas SET nama_kelas = ? WHERE id_kelas = ?");
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'si', $nama_kelas, $id_kelas);
    if (!mysqli_stmt_execute($stmt)) {
        // Execution failed
        die('Execute failed: ' . mysqli_stmt_error($stmt));
    }
    mysqli_stmt_close($stmt);
} else {
    die('Prepare failed: ' . mysqli_error($koneksi));
}

header('Location: /akademik/kelas.php');
exit;
?>