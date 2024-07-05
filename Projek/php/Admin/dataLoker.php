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

include "koneksi.php";

// Atur jumlah data per halaman
$items_per_page = 5;

// Tentukan halaman saat ini untuk setiap tabel
$current_page_loker = isset($_GET['page_loker']) ? $_GET['page_loker'] : 1;

// Hitung offset berdasarkan halaman saat ini untuk tabel loker
$offset_loker = ($current_page_loker - 1) * $items_per_page;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Lowongan Pekerjaan</title>
    <link rel="stylesheet" href="css/adminpageloker.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
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
                <h1>Data Lowongan Pekerjaan</h1>
                <p>Informasi lowongan pekerjaan</p>
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
                    <th>ID</th>
                    <th>Nama Perusahaan</th>
                    <th>Kategori Pekerjaan</th>
                    <th>Posisi</th>
                    <th>Tingkat Pendidikan</th>
                    <th>Gender</th>
                    <th>Status Kerja</th>
                    <th>Besaran Gaji</th>
                    <th>Lokasi Bekerja</th>
                    <th>Syarat Pekerjaan</th>
                    <th>Tanggal Dipost</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query untuk mengambil data lowongan pekerjaan dengan limit dan offset
                $query_loker = "SELECT l.*, u.nama_perusahaan, kp.nama_kategori
                                FROM loker l
                                INNER JOIN users u ON l.user_id = u.id
                                INNER JOIN kategori_pekerjaan kp ON l.kategori_pekerjaan_id = kp.id
                                LIMIT $items_per_page OFFSET $offset_loker";
                $result_loker = mysqli_query($koneksi, $query_loker);

                // Loop through each row and display data in table rows
                while ($row = mysqli_fetch_assoc($result_loker)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['nama_perusahaan'] . "</td>";
                    echo "<td>" . $row['nama_kategori'] . "</td>";
                    echo "<td>" . $row['posisi'] . "</td>";
                    echo "<td>" . $row['tingkat_pendidikan'] . "</td>";
                    echo "<td>" . $row['gender'] . "</td>";
                    echo "<td>" . $row['status_kerja'] . "</td>";
                    echo "<td>Rp " . number_format($row['besaran_gaji'], 0, ',', '.') . "</td>";
                    echo "<td>" . $row['lokasi_bekerja'] . "</td>";
                    echo "<td><button class='btn view-data' data-syarat='" . htmlspecialchars($row['syarat_pekerjaan'], ENT_QUOTES) . "'>View</button></td>";
                    echo "<td>" . $row['tanggal_dipost'] . "</td>";
                    echo "</tr>";
                }

                // Hitung total data lowongan pekerjaan
                $sql_count_loker = "SELECT COUNT(*) AS total FROM loker";
                $result_count_loker = mysqli_query($koneksi, $sql_count_loker);
                $row_count_loker = mysqli_fetch_assoc($result_count_loker);
                $total_data_loker = $row_count_loker['total'];
                ?>
            </tbody>
        </table>

        <!-- Modal untuk menampilkan syarat pekerjaan -->
        <div id="viewModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h5>Syarat Pekerjaan</h5>
                <p id="syaratPekerjaan"></p>
            </div>
        </div>
    </div>
</div>

                <!-- Tombol Navigasi Halaman (Lowongan Pekerjaan) -->
                <div class="pagination">
                    <?php if ($current_page_loker > 1): ?>
                        <a href="?page_loker=<?php echo ($current_page_loker - 1); ?>">Previous</a>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= ceil($total_data_loker / $items_per_page); $i++): ?>
                        <a href="?page_loker=<?php echo $i; ?>" <?php echo ($current_page_loker == $i) ? 'class="active"' : ''; ?>><?php echo $i; ?></a>
                    <?php endfor; ?>
                    <?php if ($current_page_loker < ceil($total_data_loker / $items_per_page)): ?>
                        <a href="?page_loker=<?php echo ($current_page_loker + 1); ?>">Next</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="js/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function () {
        var modal = $('#viewModal');

        $('.view-data').click(function () {
            var syarat = $(this).data('syarat');

            $('#syaratPekerjaan').text(syarat);

            modal.show();
        });

        $('.close').click(function () {
            modal.hide();
        });

        $(window).click(function (event) {
            if (event.target == modal[0]) {
                modal.hide();
            }
        });
    });
</script>

</body>
</html>
