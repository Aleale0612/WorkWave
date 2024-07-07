<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'koneksi.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Ambil informasi pengguna dari session
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$status = $_SESSION['status'];
$package_purchased = $_SESSION['package_purchased'];

// Check the user's current limit_publish_users
$query = "SELECT limit_publish_users FROM users WHERE id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($limit_publish_users);
$stmt->fetch();
$stmt->close();


// Ambil data pengguna dari database
$query = "SELECT * FROM users WHERE username = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$stmt->close();
$koneksi->close();
?>
<!doctype html>
<html lang="en">

<head>
    <title>WorkWave</title>
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
    <link rel="stylesheet" href="css/profileusers.css">
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
                <div class="col-2">
                        <div class="site-logo">
                            <a href="utama.php">
                                <img src="images/logo.png" alt="WorkWave Logo" width="175px">
                            </a>
                        </div>
                    </div>
                    <div class="col-10 text-right">
                        <span class="d-inline-block d-lg-none">
                            <a href="#" class="site-menu-toggle js-menu-toggle py-5">
                                <span class="icon-menu h3 text-black"></span>
                            </a>
                        </span>
                        <nav class="site-navigation text-right ml-auto d-none d-lg-block" role="navigation">
                    <ul class="site-menu main-menu js-clone-nav ml-auto">
                        <li><a href="tentangkami.php" class="nav-link">Tentang Kami</a></li>
                        <li><a href="utama.php" class="nav-link">Utama</a></li>
                        <li><a href="grafik.php" class="nav-link">Grafik</a></li>
                        <li><a href="bursakerja.php" class="nav-link">Bursa Kerja</a></li>
                        <?php if (!$user_id) : ?>
                            <li><a href="registrasi.php" class="nav-link">Registrasi</a></li>
                            <li><a href="login.php" class="nav-link">Masuk</a></li>
                        <?php endif; ?>
                        <?php if ($user_id) : ?>
                            <li><a href="lowongan.php" class="nav-link">Lowongan</a><span class="badge badge-info"><?= $limit_publish_users ?></span></li>
                            <li><a href="paket.php" class="nav-link">Beli Paket</a></li>
                            <li><a href="analisiscv.php" class="nav-link">Analisis CV</a></li>
                            <li class="active"><a href="profil.php" class="nav-link">Profil</a></li>
                            <li><a href="logout.php" class="nav-link">Keluar</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
                    </div>
                </div>
            </div>
        </header>

        <div class="site-section-cover overlay" style="background-image: url('images/Image8.jpg');">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-10 text-center">
                        <h1>Profil <strong>W</strong>ork<strong>W</strong>ave Anda</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="profil">
            <div class="container bootstrap snippets bootde">
                <div class="panel-body inf-content">
                    <div class="row">
                        <div class="col-md-4">
                        <div class="profile-logo">
                                <?php if ($user_data['logo_perusahaan']): ?>
                                    <img id="logoperus" src="<?= htmlspecialchars($user_data['logo_perusahaan']) ?>" alt="Logo Perusahaan" class="logo-img">
                                <?php endif; ?>
                            </div>
                            <ul title="Ratings" class="list-inline ratings text-center">
                                <li><a href="#"><span class="glyphicon glyphicon-star"></span></a></li>
                                <li><a href="#"><span class="glyphicon glyphicon-star"></span></a></li>
                                <li><a href="#"><span class="glyphicon glyphicon-star"></span></a></li>
                                <li><a href="#"><span class="glyphicon glyphicon-star"></span></a></li>
                                <li><a href="#"><span class="glyphicon glyphicon-star"></span></a></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <strong>Information</strong><br>
                            <div class="table-responsive">
                                <table class="table table-user-information">
                                    <tbody>
                                        <tr>        
                                            <td>
                                                <strong>
                                                    <span class="glyphicon glyphicon-asterisk text-primary"></span>
                                                    User ID                                               
                                                </strong>
                                            </td>
                                            <td class="text-primary-inf">
                                                <?= htmlspecialchars($user_data['username']) ?>
                                            </td>
                                        </tr>
                                        <tr>    
                                            <td>
                                                <strong>
                                                    <span class="glyphicon glyphicon-user  text-primary"></span>    
                                                    Nama Perusahaan                                                
                                                </strong>
                                            </td>
                                            <td class="text-primary-inf">
                                                <?= htmlspecialchars($user_data['nama_perusahaan']) ?> 
                                            </td>
                                        </tr>
                                        <tr>    
                                            <td>
                                                <strong>
                                                    <span class="glyphicon glyphicon-user  text-primary"></span>    
                                                    Deskripsi Perusahaan                                                
                                                </strong>
                                            </td>
                                            <td class="text-primary-inf">
                                                <?= htmlspecialchars($user_data['deskripsi_perusahaan']) ?> 
                                            </td>
                                        </tr>
                                        <tr>        
                                            <td>
                                                <strong>
                                                    <span class="glyphicon glyphicon-cloud text-primary"></span>  
                                                    Industri                                                
                                                </strong>
                                            </td>
                                            <td class="text-primary-inf">
                                                <?= htmlspecialchars($user_data['industri']) ?>  
                                            </td>
                                        </tr>
                                        <tr>        
                                            <td>
                                                <strong>
                                                    <span class="glyphicon glyphicon-bookmark text-primary"></span> 
                                                    Media Sosial                                                
                                                </strong>
                                            </td>
                                            <td class="text-primary-inf">
                                                <?= htmlspecialchars($user_data['media_sosial']) ?> 
                                            </td>
                                        </tr>
                                        <tr>        
                                            <td>
                                                <strong>
                                                    <span class="glyphicon glyphicon-eye-open text-primary"></span> 
                                                    Website                                               
                                                </strong>
                                            </td>
                                            <td class="text-primary-inf">
                                                <a href="<?= htmlspecialchars($user_data['website']) ?>" target="_blank"><?= htmlspecialchars($user_data['website']) ?></a>
                                            </td>
                                        </tr>
                                        <tr>        
                                            <td>
                                                <strong>
                                                    <span class="glyphicon glyphicon-envelope text-primary"></span> 
                                                    Alamat Perusahaan                                                
                                                </strong>
                                            </td>
                                            <td class="text-primary-inf">
                                                <?= htmlspecialchars($user_data['alamat_perusahaan']) ?> 
                                            </td>
                                        </tr>                                        
                                        <tr> 
                                            <td colspan="2">
                                                <div class="upload-section">
                                                    <h3>Upload Logo Perusahaan</h3>
                                                    <p>Ukuran maks. 500kb</p>
                                                    <form action="uploadLogo.php" method="post" enctype="multipart/form-data">
                                                        <input type="file" name="logo_perusahaan" required>
                                                        <button type="submit" name="upload">Upload</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>                                    
                                    </tbody>
                                </table>
                            </div>
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
                        <p>WorkWave adalah platform interaktif terdepan yang memudahkan pencarian kerja, perekrutan, dan partisipasi komunitas di Yogyakarta.</p>
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
        </footer>

    </div>

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
