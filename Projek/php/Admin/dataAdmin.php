<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Periksa apakah admin sudah login
if (!isset($_SESSION['admin_username'])) {
    // Redirect ke halaman login jika admin belum login
    header("Location: loginAdmin.php");
    exit();
}

// Panggil koneksi ke database
include "koneksi.php";

// Ambil data admin dari database
$sql = "SELECT Username, Email, Nama FROM admin";
$result = $koneksi->query($sql);

// Inisialisasi pesan status
$status_message = "";

// Jika ada pesan dari halaman sebelumnya (misalnya setelah update atau insert)
if (isset($_SESSION['status_message'])) {
    $status_message = $_SESSION['status_message'];
    unset($_SESSION['status_message']); // Hapus pesan dari session setelah digunakan
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Admin</title>
    <link rel="stylesheet" href="css/adminpage4.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="sidebar">
    <div class="sidebar-header">
        <h2><strong>W</strong>ork<strong>W</strong>ave</h2>
    </div>
    <ul class="sidebar-menu">
            <li><a href="AdminPage.php">Dashboard</a></li>
            <li><a href="dataPerusahaan.php">Data Perusahaan</a></li>
            <li><a href="dataLoker.php">Data Lowongan Pekerjaan</a></li> 
            <li><a href="dataAdmin.php">Admin</a></li>
            <li><a href="databursakerja.php">Job Fair</a></li>
            <li><a href="logout.php" class="btn btn-danger">Keluar</a></li>
        </ul>
</div>
<div class="main-content">
    <header>
        <div class="header-title">
            <h1>Admin</h1>
            <?php if (!empty($status_message)) : ?>
                <div class="alert" role="alert">
                    <?php echo htmlspecialchars($status_message); ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="user-info">
        <p>Powered by <strong>Kuadran</strong/p>
            </div>
    </header>
    <div class="content">
        <div class="data-section">
        <h2><strong>W</strong>ork<strong>W</strong>ave.com</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Nama</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Username']); ?></td>
                            <td><?php echo htmlspecialchars($row['Email']); ?></td>
                            <td><?php echo htmlspecialchars($row['Nama']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
