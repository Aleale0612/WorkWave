<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$status = $_SESSION['status'];
$package_purchased = $_SESSION['package_purchased'];

$query = "SELECT limit_publish_users FROM users WHERE id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($limit_publish_users);
$stmt->fetch();
$stmt->close();

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
    <link rel="stylesheet" href="css/paket.css">
    <link rel="stylesheet" href="css/style.css">  
    <link rel="stylesheet" href="css/analisiscv.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-9zm0L8TLN8ymMiJv"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <div class="col-9  text-right">
              <span class="d-inline-block d-lg-none"><a href="#" class=" site-menu-toggle js-menu-toggle py-5 "><span class="icon-menu h3 text-black"></span></a></span>
              <nav class="site-navigation text-right ml-auto d-none d-lg-block" role="navigation">
                <ul class="site-menu main-menu js-clone-nav ml-auto ">
                  <li><a href="utama.php" class="nav-link">Utama</a></li>
                  <li><a href="grafik.php" class="nav-link">Grafik</a></li>
                  <li><a href="bursakerja.php" class="nav-link">Bursa Kerja</a></li>
                  <?php if (!$user_id): ?>
                    <li><a href="registrasi.php" class="nav-link">Registrasi</a></li>
                    <li><a href="login.php" class="nav-link">Masuk</a></li>
                  <?php endif; ?>
                  <?php if ($user_id): ?>
                    <li><a href="lowongan.php?status=<?= $status ?>&user_id=<?= $user_id ?>&package_purchased=<?= $package_purchased ?>" class="nav-link">Lowongan</a><span class="badge badge-info"><?= $limit_publish_users ?></span></li>
                    <li><a href="paket.php?status=<?= $status ?>&user_id=<?= $user_id ?>&package_purchased=<?= $package_purchased ?>" class="nav-link">Beli Paket</a></li>
                    <li class="active"><a href="analisiscv.php?status=<?= $status ?>&user_id=<?= $user_id ?>&package_purchased=<?= $package_purchased ?>" class="nav-link">Analisis CV</a></li>
                    <li><a href="profil.php?status=<?= $status ?>&user_id=<?= $user_id ?>&package_purchased=<?= $package_purchased ?>" class="nav-link">Profil</a></li>
                    <li><a href="logout.php" class="nav-link">Keluar</a></li>
                  <?php endif; ?>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </header>

      <div class="site-section-cover overlay" style="background-image: url('images/Image11.jpg');">
        <div class="container">
          <div class="row align-items-center justify-content-center">
            <div class="col-lg-10 text-center">
              <h1>Analisis <strong>CV</strong></h1>
            </div>
          </div>
        </div>
      </div>

      <div class="analisiscv">
      <form action="AnalisisCv/groq.php" method="post" enctype="multipart/form-data">
        <label for="cv">Upload CV (PDF):</label>
        <input type="file" name="cv" id="cv" accept="application/pdf" required><br><br>
        <label for="cover_letter">Upload Surat Lamaran Kerja (PDF):</label>
        <input type="file" name="cover_letter" id="cover_letter" accept="application/pdf" required><br><br>
        <input type="submit" value="Upload dan Analisis">
    </form>
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
      </footer>

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
