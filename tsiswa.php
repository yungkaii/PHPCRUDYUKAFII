<?php

// Koneksi database
include 'koneksi.php';

// Ambil data dari form
$nama        = $_POST['nama'];
$jk          = $_POST['jk'];
$tgl_lahir   = $_POST['tgl_lahir'];
$kelas       = $_POST['kelas'];
$jurusan     = $_POST['jurusan'];
$keterangan  = $_POST['keterangan'];

// Pastikan semua nilai string **di dalam tanda kutip**
$query = "
    INSERT INTO siswa (nama, jk, tgl_lahir, kelas, jurusan, keterangan)
    VALUES ('$nama', '$jk', '$tgl_lahir', '$kelas', '$jurusan', '$keterangan')
";

// Jalankan query
mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

// Arahkan kembali
header("Location: siswa.php");
exit;
?>