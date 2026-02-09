<?php
$koneksi = mysqli_connect("localhost", "root", "", "sekolah");

// Check connection and provide useful error message
if (!$koneksi) {
    // Stop execution with error message (change to logging in production)
    die('Koneksi database gagal: ' . mysqli_connect_error());
}

// Set proper charset
mysqli_set_charset($koneksi, 'utf8mb4');
?>