<?php

//koneksi database
include 'koneksi.php';

//menangkap sebuah data yang dikirim dari form
$id_jurusan = $_POST['id_jurusan'];
$nama_jurusan = $_POST['nama_jurusan'];

//menginput data ke database
mysqli_query($koneksi, "insert into jurusan value('$id_jurusan', '$nama_jurusan')");

//mengalihkan halaman kembali ke kelas.php
header("location:jurusan.php");
?>