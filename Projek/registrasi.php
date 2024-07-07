<?php
 error_reporting(E_ALL);
 ini_set('display_errors', 1);
 include 'php/Admin/prosesRegis.php';
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

  <!-- MAIN CSS -->
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

            <span class="d-inline-block d-lg-none"><a href="#" class=" site-menu-toggle js-menu-toggle py-5 "><span class="icon-menu h3 text-black"></span></a></span>

            <nav class="site-navigation text-right ml-auto d-none d-lg-block" role="navigation">
              <ul class="site-menu main-menu js-clone-nav ml-auto ">
                <li><a href="tentangkami.php" class="nav-link">Tentang Kami</a></li>
                <li><a href="utama.php" class="nav-link">Utama</a></li>
                <li><a href="grafik.php" class="nav-link">Grafik</a></li>
                <li><a href="bursakerja.php" class="nav-link">Bursa Kerja</a></li>
                <li class="active"><a href="registrasi.php" class="nav-link">Registrasi</a></li>
                <li><a href="login.php" class="nav-link">Masuk</a></li>
              </ul>
            </nav>
          </div>


        </div>
      </div>

    </header>


    <div class="site-section-cover overlay" style="background-image: url('images/Image3.jpg');">

      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-lg-10 text-center">
            <h1><strong>Registrasi</strong></h1>
          </div>
        </div>
      </div>
    </div>




    <div class="site-section bg-light" id="contact-section">
      <div class="container">
        
        <div class="row">
          <div class="col-lg-8 mb-5" >
            <h2>Registrasi Sebagai Perusahaan</h2>
            <form action="php/Admin/prosesRegis.php" method="post" enctype="multipart/form-data">
    <div class="form-group row">
        <div class="col-md-12">
            <input type="text" class="form-control" name="nama_perusahaan" placeholder="Nama Perusahaan">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12">
            <input type="text" class="form-control" name="industri" placeholder="Industri">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12">
            <textarea class="form-control" name="deskripsi_perusahaan" placeholder="Deskripsi Perusahaan" rows="5"></textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12">
            <input type="text" class="form-control" name="media_sosial" placeholder="Media Sosial">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12">
            <input type="text" class="form-control" name="website" placeholder="Website">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12">
            <textarea class="form-control" name="alamat" placeholder="Alamat Perusahaan" rows="5"></textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12">
            <input type="text" class="form-control" name="username" placeholder="Username">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12">
            <input type="password" class="form-control" name="password" placeholder="Kata Sandi">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6 mr-auto">
            <input type="submit" name="register" class="btn btn-block btn-primary text-white py-3 px-5" value="Daftar">
        </div>
    </div>
</form>

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
                    <li><a href="registrasi.php">Registrasi</a></li>
                    <li><a href="login.html">Masuk</a></li>
                    <li><a href="#">Beli paket</a></li>
                  </ul>
                </div>
              </div>
            </div>
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
  <script src="js/registrasi.js"></script>
  <script src="js/main.js"></script>

</body>

</html>

