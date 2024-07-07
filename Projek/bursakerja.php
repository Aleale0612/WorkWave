<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Number of records to display per page
$records_per_page = 6;

// Get the current page number from the URL, if not set default to 1
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $records_per_page;

// Periksa apakah pengguna memiliki paket yang valid
$query = "SELECT limit_publish_users, package_purchased FROM users WHERE id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($limit_publish_users, $package_purchased);
$stmt->fetch();
$stmt->close();


// Query to get total number of records
$total_records_query = "SELECT COUNT(*) FROM event";
$total_records_result = $koneksi->query($total_records_query);
$total_records = $total_records_result->fetch_row()[0];

// Query to get records for the current page
$query = "SELECT * FROM event LIMIT $offset, $records_per_page";
$result = $koneksi->query($query);
?>
<!doctype html>
<html lang="en">

<head>
    <title>Work Wave</title>
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

    <style>
        .thumbnail-link img {
            transition: transform 0.3s ease;
        }

        .thumbnail-link:hover img {
            transform: scale(1.1);
        }
    </style>
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

                <div class="col-2">
                        <div class="site-logo">
                            <a href="utama.php">
                                <img src="images/logo.png" alt="WorkWave Logo" width="175px">
                            </a>
                        </div>
                    </div>
                    <div class="col-10 text-right">

                        <span class="d-inline-block d-lg-none"><a href="#" class=" site-menu-toggle js-menu-toggle py-5 "><span class="icon-menu h3 text-black"></span></a></span>

                        <nav class="site-navigation text-right ml-auto d-none d-lg-block" role="navigation">
                            <ul class="site-menu main-menu js-clone-nav ml-auto ">
                                <li><a href="tentangkami.php" class="nav-link">Tentang Kami</a></li>
                                <li><a href="utama.php" class="nav-link">Utama</a></li>
                                <li><a href="grafik.php" class="nav-link">Grafik</a></li>
                                <li class="active"><a href="bursakerja.php" class="nav-link">Bursa Kerja</a></li>
                                <?php if (!$user_id): ?>
                                    <li><a href="registrasi.php" class="nav-link">Registrasi</a></li>
                                    <li><a href="login.php" class="nav-link">Masuk</a></li>
                                <?php endif; ?>
                                <?php if ($user_id): ?>
                                    <li><a href="lowongan.php" class="nav-link">Lowongan</a><span class="badge badge-info"><?= $limit_publish_users ?></span></li>
                                    <li><a href="paket.php" class="nav-link">Beli Paket</a></li>
                                    <li><a href="analisiscv.php" class="nav-link">Analisis CV</a></li>
                                    <li><a href="profil.php" class="nav-link">Profil</a></li>
                                    <li><a href="logout.php" class="nav-link">Keluar</a></li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

        </header>

        <div class="site-section-cover overlay" style="background-image: url('images/Image5.jpg');">

            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-10 text-center">
                        <h1>Bursa <strong>Kerja</strong></h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-section bg-light">
            <div class="container">
                <div class="row">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="post-entry-1 h-100">
                                <a href="event_detail.php?id=<?php echo $row['id']; ?>" class="thumbnail-link">
                                    <img src="<?php echo $row['foto_poster']; ?>" alt="Image" class="img-fluid">
                                </a>
                                <div class="post-entry-1-contents">
                                    <h2><a href="event_detail.php?id=<?php echo $row['id']; ?>"><?php echo $row['nama_acara']; ?></a></h2>
                                    <span class="meta d-inline-block mb-3"><?php echo date('M d, Y', strtotime($row['tanggal_acara'])); ?></span>
                                    <p><?php echo $row['tempat_acara']; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <div class="row">
                    <div class="col-12">
                        <ul class="pagination">
                            <?php
                            $total_pages = ceil($total_records / $records_per_page);
                            for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php if ($current_page == $i) echo 'active'; ?>">
                                    <a class="page-link" href="bursakerja.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
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
                                <li><a href="blog.html">Bursa Kerja</a></li>
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
        <a href="uploadbk.php" class="fixed-button">Tambah Event</a>

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

        <script src="js/main.js"></script>

</body>

</html>

<?php
// Close the connection
$koneksi->close();
?>
