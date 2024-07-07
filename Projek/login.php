<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'php/Admin/prosesLogin.php';
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
  <link rel="stylesheet" href="css/style.css">
  <!-- SweetAlert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

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
                <li><a href="bursakerja.php" class="nav-link">Bursa Kerja</a></li>
                <li><a href="registrasi.php" class="nav-link">Registrasi</a></li>
                <li class="active"><a href="login.php" class="nav-link">Masuk</a></li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </header>
    <div class="site-section-cover overlay" style="background-image: url('images/Image8.jpg');">
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <h1><strong>Masuk</strong></h1>
        </div>
      </div>
    </div>
    <div class="site-section bg-light" id="contact-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mb-5">
            <form action="php/Admin/prosesLogin.php" method="post">
              <h2>Masuk Ke WorkWave</h2>
              <div class="form-group row">
                <div class="col-md-12">
                  <input type="text" name="log-username" class="form-control" placeholder="Username" required>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-12">
                  <input type="password" name="log-password" class="form-control" placeholder="Kata Sandi" required>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-6 mr-auto">
                  <input type="submit" name="login" class="btn btn-block btn-primary text-white py-3 px-5" value="Masuk">
                </div>
              </div>
            </form>
          </div>
          <div class="col-lg-4 ml-auto">
            <div class="bg-white p-3 p-md-5">
              <h3 class="text-black mb-4">Pengguna Baru</h3>
              <ul class="list-unstyled footer-link">
                <li class="d-block mb-3">
                  <span>Jika Anda belum memiliki akun, silakan melakukan registrasi terlebih dahulu sebagai Perusahaan.</span>
                </li>
                <p><a href="registrasi.php" class="btn btn-block btn-primary text-white py-3 px-5">Registrasi</a></p>
              </ul>
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
      </footer>
    </div>
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
