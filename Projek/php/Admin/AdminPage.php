<?php
//koneksi ke database
include "koneksi.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Periksa admin login
if (!isset($_SESSION['admin_username'])) {
    // Redirect ke halaman login jika admin belum login
    header("Location: loginAdmin.php");
    exit();
}

// Ambil nama admin dari session
$admin_username = $_SESSION['admin_username'];

// Query untuk mengambil nama admin dari tabel admin
$sql = "SELECT Nama FROM admin WHERE Username = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("s", $admin_username);
$stmt->execute();
$stmt->bind_result($admin_nama);
$stmt->fetch();
$stmt->close();

// Query untuk mengambil total perusahaan, lowongan, admin, dan event
$totalPerusahaanQuery = "SELECT COUNT(*) FROM users";
$totalLowonganQuery = "SELECT COUNT(*) FROM loker";
$totalAdminQuery = "SELECT COUNT(*) FROM admin";
$totalEventQuery = "SELECT COUNT(*) FROM event";

// Menjalankan query dan mendapatkan hasil
$totalPerusahaan = $koneksi->query($totalPerusahaanQuery)->fetch_row()[0];
$totalLowongan = $koneksi->query($totalLowonganQuery)->fetch_row()[0];
$totalAdmin = $koneksi->query($totalAdminQuery)->fetch_row()[0];
$totalEvent = $koneksi->query($totalEventQuery)->fetch_row()[0];

// Query untuk mendapatkan lowongan terbaru
$lowonganTerbaruQuery = "
    SELECT posisi, nama_perusahaan, tanggal_dipost
    FROM loker
    JOIN users ON loker.user_id = users.id
    ORDER BY tanggal_dipost DESC
    LIMIT 5";
$lowonganTerbaruResult = $koneksi->query($lowonganTerbaruQuery);

// Query untuk mendapatkan perusahaan terbaru
$perusahaanTerbaruQuery = "
    SELECT nama_perusahaan, created_at
    FROM users
    ORDER BY created_at DESC
    LIMIT 5";
$perusahaanTerbaruResult = $koneksi->query($perusahaanTerbaruQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/dashboardadmin.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <h1>Selamat datang, Admin <?php echo htmlspecialchars($admin_nama); ?></h1>
                <p>Ruang Kerja Kamu.</p>
            </div>
            <div class="user-info">
                <p>Powered by <strong>Kuadran</strong></p>
            </div>
        </header>
        <div class="content">
            <div class="cards">
                <div class="card bg-primary">
                    <h3>Total Perusahaan</h3>
                    <p><?php echo $totalPerusahaan; ?></p>
                </div>
                <div class="card bg-success">
                    <h3>Total Lowongan</h3>
                    <p><?php echo $totalLowongan; ?></p>
                </div>
                <div class="card bg-warning">
                    <h3>Total Admin</h3>
                    <p><?php echo $totalAdmin; ?></p>
                </div>
                <div class="card bg-danger">
                    <h3>Total Event</h3>
                    <p><?php echo $totalEvent; ?></p>
                </div>
            </div>
            <div class="charts">
                <div class="chart-container">
                    <h2 id="Grafik-title">Grafik Transaksi</h2>
                    <canvas id="transactionsChart"></canvas>
                </div>
                <div class="chart-container2">
                    <h2 id="Grafik-title2">Grafik Perusahaan</h2>
                    <canvas id="perusahaanChart"></canvas>
                </div>
            </div>
            <div class="latest-data">
                <div class="table-container">
                    <h2>Lowongan Terbaru</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Posisi</th>
                                <th>Perusahaan</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $lowonganTerbaruResult->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['posisi']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_perusahaan']); ?></td>
                                    <td><?php echo htmlspecialchars($row['tanggal_dipost']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <div class="table-container">
                    <h2>Perusahaan Terbaru</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama Perusahaan</th>
                                <th>Tanggal Bergabung</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $perusahaanTerbaruResult->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['nama_perusahaan']); ?></td>
                                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Fetch data for charts from GrafikAdmin.php
    $.ajax({
        url: 'GrafikAdmin.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                console.error('Data retrieval failed:', data.error);
                return;
            }

            let totalGold = data.transactions.data.reduce((acc, item) => acc + item.gold, 0);
            let totalSilver = data.transactions.data.reduce((acc, item) => acc + item.silver, 0);
            let totalBronze = data.transactions.data.reduce((acc, item) => acc + item.bronze, 0);

            var ctx1 = document.getElementById('transactionsChart').getContext('2d');
            var transactionsChart = new Chart(ctx1, {
                type: 'pie',
                data: {
                    labels: ['Gold', 'Silver', 'Bronze'],
                    datasets: [{
                        label: 'Transactions',
                        data: [totalGold, totalSilver, totalBronze],
                        backgroundColor: [
                            'rgba(255, 215, 0, 0.2)',
                            'rgba(192, 192, 192, 0.2)',
                            'rgba(205, 127, 50, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 215, 0, 1)',
                            'rgba(192, 192, 192, 1)',
                            'rgba(205, 127, 50, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });

            var ctx2 = document.getElementById('perusahaanChart').getContext('2d');
            var perusahaanChart = new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: data.perusahaan.labels,
                    datasets: [{
                        label: '# of Perusahaan',
                        data: data.perusahaan.data,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching chart data:', error);
        }
    });
    
    document.getElementById('Grafik-title').addEventListener('click', function() {
        $.ajax({
            url: 'GrafikAdmin.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.error) {
                    console.error('Data retrieval failed:', data.error);
                    return;
                }

                let totalGold = data.transactions.data.reduce((acc, item) => acc + item.gold, 0);
                let totalSilver = data.transactions.data.reduce((acc, item) => acc + item.silver, 0);
                let totalBronze = data.transactions.data.reduce((acc, item) => acc + item.bronze, 0);
                let totalTransactions = totalGold + totalSilver + totalBronze;

                Swal.fire({
                    title: 'Total Transaksi Berhasil saat ini',
                    html: `
                        <strong>Gold:</strong> ${totalGold.toLocaleString()}<br>
                        <strong>Silver:</strong> ${totalSilver.toLocaleString()}<br>
                        <strong>Bronze:</strong> ${totalBronze.toLocaleString()}<br>
                        <strong>Total:</strong> ${totalTransactions.toLocaleString()}
                    `,
                    icon: 'info'
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching chart data:', error);
            }
        });
    });

    document.getElementById('Grafik-title2').addEventListener('click', function() {
        $.ajax({
            url: 'GrafikAdmin.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.error) {
                    console.error('Data retrieval failed:', data.error);
                    return;
                }

                let infoText = '';
                data.perusahaan.labels.forEach((month, index) => {
                    infoText += `<strong>Bulan ${month}:</strong> ${data.perusahaan.data[index]} perusahaan<br>`;
                });

                Swal.fire({
                    title: 'Informasi Total Perusahaan',
                    html: infoText,
                    icon: 'info'
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching chart data:', error);
            }
        });
    });
        </script>

</body>
</html>
