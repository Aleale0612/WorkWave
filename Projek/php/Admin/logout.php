<?php
// Mulai sesi PHP
session_start();

// Hapus semua data sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login atau halaman lainnya setelah logout
header("Location: loginAdmin.php");
exit;
?>
