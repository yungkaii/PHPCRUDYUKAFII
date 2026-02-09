<?php

include __DIR__ . '/koneksi.php';

$id_jurusan = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id_jurusan <= 0) {
	header('Location: /akademik/jurusan.php');
	exit;
}

$stmt = mysqli_prepare($koneksi, "DELETE FROM jurusan WHERE id_jurusan = ?");
if ($stmt) {
	mysqli_stmt_bind_param($stmt, 'i', $id_jurusan);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
}

header('Location: /akademik/jurusan.php');
exit;
?>
