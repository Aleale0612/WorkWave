<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "koneksi.php";

// Ambil daftar event dari database
$sql = "SELECT id, nama_acara, deskripsi_acara, tanggal_acara, waktu_acara, tempat_acara, kategori_acara, biaya_pendaftaran, kontak_penyelenggara, url_pendaftaran FROM event";
$result = $koneksi->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="css/adminpage51.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet">
    <script src="js/jobfair.js"></script>
</head>
<body>
<div class="sidebar-wrapper">
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

    </div>
<div class="main-content">
    <header>
        <div class="header-title">
            <h1>Data Bursa Kerja</h1>
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
                        <th>Nama Acara</th>
                        <th>Deskripsi</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Tempat</th>
                        <th>Kategori</th>
                        <th>Biaya Pendaftaran</th>
                        <th>Kontak Penyelenggara</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nama_acara']); ?></td>
                            <td><?php echo htmlspecialchars($row['deskripsi_acara']); ?></td>
                            <td><?php echo htmlspecialchars($row['tanggal_acara']); ?></td>
                            <td><?php echo htmlspecialchars($row['waktu_acara']); ?></td>
                            <td><?php echo htmlspecialchars($row['tempat_acara']); ?></td>
                            <td><?php echo htmlspecialchars($row['kategori_acara']); ?></td>
                            <td><?php echo htmlspecialchars($row['biaya_pendaftaran']); ?></td>
                            <td><?php echo htmlspecialchars($row['kontak_penyelenggara']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
