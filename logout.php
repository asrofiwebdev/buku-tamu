<?php
// Mulai session
session_start();

// Hapus semua variabel session
$_SESSION = array();

// Hancurkan session
session_destroy();

// Tampilkan pesan dan redirect ke halaman login
echo "<script>alert('Anda telah berhasil logout');
document.location='index.php';</script>";
exit;
?>