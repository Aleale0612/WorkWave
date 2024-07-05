<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'koneksi.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Get event ID from URL
$event_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Query to get event details
$query = "SELECT * FROM event WHERE id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param('i', $event_id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();

// Check if event exists
if (!$event) {
    echo "Event tidak ditemukan.";
    exit;
}

?>
<!doctype html>
<html lang="en">

<head>
    <title><?php echo $event['nama_acara']; ?> - Work Wave</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="fonts/brand/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/aos.css">

    <!-- MAIN CSS -->
     <link rel="stylesheet" href="css/bursastyle.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="site-wrap" id="home-section">

        <div class="site-mobile-menu site-navbar-target">
            <div class="site-mobile-menu-header">
                <div class="site-mobile-menu-close mt-3">
                    <span class="icon-close2 js-menu-toggle"></span>
                </div>
            </div>
            <div class="site-mobile-menu-body"></div>
        </div>

        <header class="site-navbar light site-navbar-target" role="banner">
            <div class="container">
                <div class="row align-items-center position-relative">
                    <div class="col-3">
                        <div class="site-logo">
                            <a href="utama.php"><strong>W</strong>ork<strong>W</strong>ave</a>
                        </div>
                    </div>
                    <div class="col-9 text-right">
                        <span class="d-inline-block d-lg-none"><a href="#" class=" site-menu-toggle js-menu-toggle py-5 "><span class="icon-menu h3 text-black"></span></a></span>
                        <nav class="site-navigation text-right ml-auto d-none d-lg-block" role="navigation">
                            <ul class="site-menu main-menu js-clone-nav ml-auto ">
                                <li><a href="utama.php" class="nav-link">Utama</a></li>
                                <li><a href="grafik.php" class="nav-link">Grafik</a></li>
                                <li class="active"><a href="bursakerja.php" class="nav-link">Bursa Kerja</a></li>
                                <?php if (!$user_id): ?>
                                    <li><a href="registrasi.php" class="nav-link">Registrasi</a></li>
                                    <li><a href="login.php" class="nav-link">Masuk</a></li>
                                <?php endif; ?>
                                <?php if ($user_id): ?>
                                    <li><a href="lowongan.php" class="nav-link">Lowongan</a></li>
                                    <li><a href="paket.html" class="nav-link">Beli Paket</a></li>
                                    <li><a href="profil.php" class="nav-link">Profil</a></li>
                                    <li><a href="logout.php" class="nav-link">Keluar</a></li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </header>

        <div class="site-section-cover overlay" style="background-image: url('images/Image9.jpg');"></div>

        <div class="site-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <ul class="list-unstyled tutorial-section-list">
                            <li>
                                <h2><?php echo $event['nama_acara']; ?></h2>
                                <div class="img-wrap">
                                    <a href="#"><img src="<?php echo $event['foto_poster']; ?>" alt="Image" class="img-fluid"></a>
                                </div>
                            </li>
                            <li>
                                <span><?php echo nl2br($event['deskripsi_acara']); ?></span>
                            </li>
                            <li>
                                <h2>Tanggal:</h2>
                                <a><?php echo date('d M Y', strtotime($event['tanggal_acara'])); ?></a>
                            </li>
                            <li>
                                <h2>Waktu:</h2>
                                <a><?php echo $event['waktu_acara']; ?></a>
                            </li>
                            <li>
                                <h2>Tempat:</h2>
                                <a><?php echo $event['tempat_acara']; ?></a>
                            </li>
                            <li>
                                <h2>Biaya Pendaftaran:</h2>
                                <a>Rp. <?php echo number_format($event['biaya_pendaftaran'], 0, ',', '.'); ?></a>
                            </li>
                            <li>
                                <h2>Kontak</h2>
                                <a>
                                    <ion-icon name="call-outline"></ion-icon> <a><?php echo $event['kontak_penyelenggara']; ?></a> <br>
                                    <ion-icon name="mail-outline"></ion-icon> <a><?php echo $event['url_pendaftaran']; ?></a>
                                </a>
                            </li>
                            <li>
                                <h2>Instruksi Tambahan</h2>
                                <a><?php echo nl2br($event['Instruksi_tambahan']); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <h2 class="footer-heading mb-4">WorkWave</h2>
                    <p>WorkWave adalah platform interaktif terdepan yang memudahkan pencarian kerja, perekrutan, dan partisipasi komunitas di Yogyakarta. </p>
                    <ul class="list-unstyled social">
                        <li><a href="#"><span class="icon-facebook"></span></a></li>
                        <li><a href="#"><span class="icon-instagram"></span></a></li>
                        <li><a href="#"><span class="icon-twitter"></span></a></li>
                        <li><a href="#"><span class="icon-linkedin"></span></a></li>
                    </ul>
                </div>
                <div class="col-lg-8 ml-auto">
                    <div class="row">
                        <div class="col-lg-3">
                            <h2 class="footer-heading mb-4"></h2>
                            <ul class="list-unstyled">
                                <li><a href="utama.php">Lowongan Pekerjaan</a></li>
                                <li><a href="grafik.php">Grafik</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3">
                            <h2 class="footer-heading mb-4"></h2>
                            <ul class="list-unstyled">
                                <li><a href="bursakerja.html">Bursa Kerja</a></li>
                                <li><a href="#">Partisipasi Bursa Kerja</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3">
                            <h2 class="footer-heading mb-4"></h2>
                            <ul class="list-unstyled">
                                <li><a href="registrasi.html">Registrasi</a></li>
                                <li><a href="login.html">Masuk</a></li>
                                <li><a href="#">Beli paket</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="bursakerja.php" class="fixed-button">Kembali ke awal</a>

        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/jquery.sticky.js"></script>
        <script src="js/jquery.waypoints.min.js"></script>
        <script src="js/jquery.animateNumber.min.js"></script>
        <script src="js/jquery.fancybox.min.js"></script>
        <script src="js/jquery.easing.1.3.js"></script>
        <script src="js/bootstrap-datepicker.min.js"></script>
        <script src="js/aos.js"></script>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <script src="js/main.js"></script>

</body>

</html>

<?php
// Close the connection
$koneksi->close();
?>
