<?php

// Koneksi database
include __DIR__ . '/koneksi.php';

// Menangkap dan membersihkan data yang dikirim dari form
$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
$nis = isset($_POST['nis']) ? (int) $_POST['nis'] : 0;
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

// Fetch existing row so we can preserve values if form posts empty/invalid values
$existing_nis = null;
$existing_kelas = null;
$existing_jurusan = null;
$select = mysqli_prepare($koneksi, "SELECT nis, kelas, jurusan FROM siswa WHERE id = ?");
if ($select) {
	mysqli_stmt_bind_param($select, 'i', $id);
	mysqli_stmt_execute($select);
	mysqli_stmt_bind_result($select, $existing_nis, $existing_kelas, $existing_jurusan);
	mysqli_stmt_fetch($select);
	mysqli_stmt_close($select);
}

// If POSTed values are missing or invalid, keep existing values
if ($nis <= 0 && $existing_nis !== null) {
	$nis = (int) $existing_nis;
}
if (empty($id_kelas) && $existing_kelas !== null) {
	$id_kelas = (int) $existing_kelas;
}
if (empty($id_jurusan) && $existing_jurusan !== null) {
	$id_jurusan = (int) $existing_jurusan;
}

// Validate that kelas and jurusan IDs exist in their tables; if not, revert to existing
if ($id_kelas > 0) {
	$chk = mysqli_prepare($koneksi, "SELECT COUNT(*) FROM kelas WHERE id_kelas = ?");
	if ($chk) {
		mysqli_stmt_bind_param($chk, 'i', $id_kelas);
		mysqli_stmt_execute($chk);
		mysqli_stmt_bind_result($chk, $countK);
		mysqli_stmt_fetch($chk);
		mysqli_stmt_close($chk);
		if (empty($countK)) {
			$id_kelas = (int) $existing_kelas;
		}
	}
}
if ($id_jurusan > 0) {
	$chk = mysqli_prepare($koneksi, "SELECT COUNT(*) FROM jurusan WHERE id_jurusan = ?");
	if ($chk) {
		mysqli_stmt_bind_param($chk, 'i', $id_jurusan);
		mysqli_stmt_execute($chk);
		mysqli_stmt_bind_result($chk, $countJ);
		mysqli_stmt_fetch($chk);
		mysqli_stmt_close($chk);
		if (empty($countJ)) {
			$id_jurusan = (int) $existing_jurusan;
		}
	}
}

// Update data ke database using prepared statement (including nis)
$stmt = mysqli_prepare($koneksi, "UPDATE siswa SET nis = ?, nama = ?, jk = ?, tgl_lahir = ?, kelas = ?, jurusan = ?, keterangan = ? WHERE id = ?");
if ($stmt) {
	mysqli_stmt_bind_param($stmt, 'isssiisi', $nis, $siswa, $jk, $tanggal_lahir, $id_kelas, $id_jurusan, $keterangan, $id);
	if (!mysqli_stmt_execute($stmt)) {
		die('Execute failed: ' . mysqli_stmt_error($stmt));
	}
	$affected = mysqli_stmt_affected_rows($stmt);
	mysqli_stmt_close($stmt);
} else {
	// In development, show DB error. In production, log instead.
	die('Prepare failed: ' . mysqli_error($koneksi));
}

// Redirect back to siswa.php with a status flag so we can see if update changed anything
if (isset($affected) && $affected > 0) {
	header('Location: /akademik/siswa.php?updated=1');
} else {
	header('Location: /akademik/siswa.php?updated=0');
}
exit;
?>