<?php
include __DIR__ . '/koneksi.php';

$id_jurusan = isset($_POST['id_jurusan']) ? (int) $_POST['id_jurusan'] : 0;
$nama_jurusan = isset($_POST['nama_jurusan']) ? trim($_POST['nama_jurusan']) : '';

if ($id_jurusan <= 0 || $nama_jurusan === '') {
    header('Location: /akademik/jurusan.php');
    exit;
}

$stmt = mysqli_prepare($koneksi, "UPDATE jurusan SET nama_jurusan = ? WHERE id_jurusan = ?");
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'si', $nama_jurusan, $id_jurusan);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

header('Location: /akademik/jurusan.php');
exit;
?>
<?php

// Koneksi database
include '../koneksi.php';

// Menangkap data yang dikirim dari form edit
$id_jurusan = $_POST['id_jurusan'];
$nama_jurusan = $_POST['nama_jurusan'];

// Update data ke database
mysqli_query($koneksi, "UPDATE jurusan SET nama_jurusan='$nama_jurusan' WHERE id_jurusan='$id_jurusan'");

// Mengalihkan halaman kembali ke jurusan.php
header("location:../pages/jurusan.php");
?>
