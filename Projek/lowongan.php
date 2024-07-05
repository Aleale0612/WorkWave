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
$status = $_SESSION['status'];
$package_purchased = $_SESSION['package_purchased'];

// Periksa apakah pengguna memiliki paket yang valid
$query = "SELECT limit_publish_users, package_purchased FROM users WHERE id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($limit_publish_users, $package_purchased);
$stmt->fetch();
$stmt->close();

if ($package_purchased == 0 || $limit_publish_users <= 0) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js'></script>";
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Peringatan',
                text: 'Anda tidak memiliki paket yang valid untuk mengupload lowongan pekerjaan. Silakan beli paket baru.',
                icon: 'warning',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'paket.php?status=$status&user_id=$user_id&package_purchased=$package_purchased';
                }
            });
        });
    </script>";
    exit();
}

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
                        <span class="d-inline-block d-lg-none"><a href="#" class="site-menu-toggle js-menu-toggle py-5"><span class="icon-menu h3 text-black"></span></a></span>
                        <nav class="site-navigation text-right ml-auto d-none d-lg-block" role="navigation">
                            <ul class="site-menu main-menu js-clone-nav ml-auto">
                                <li><a href="utama.php" class="nav-link">Utama</a></li>
                                <li><a href="grafik.php" class="nav-link">Grafik</a></li>
                                <li><a href="bursakerja.php" class="nav-link">Bursa Kerja</a></li>
                                <?php if (!$user_id): ?>
                                    <li><a href="registrasi.php" class="nav-link">Registrasi</a></li>
                                    <li><a href="login.php" class="nav-link">Masuk</a></li>
                                <?php endif; ?>
                                <?php if ($user_id): ?>
                                    <li class="active"><a href="lowongan.php?status=<?= $status ?>&user_id=<?= $user_id ?>&package_purchased=<?= $package_purchased ?>" class="nav-link">Lowongan</a><span class="badge badge-info"><?= $limit_publish_users ?></span></li>
                                    <li><a href="paket.php?status=<?= $status ?>&user_id=<?= $user_id ?>&package_purchased=<?= $package_purchased ?>" class="nav-link">Beli Paket</a></li>
                                    <li><a href="analisiscv.php?status=<?= $status ?>&user_id=<?= $user_id ?>&package_purchased=<?= $package_purchased ?>" class="nav-link">Analisis CV</a></li>
                                    <li><a href="profil.php?status=<?= $status ?>&user_id=<?= $user_id ?>&package_purchased=<?= $package_purchased ?>" class="nav-link">Profil</a></li>
                                    <li><a href="logout.php" class="nav-link">Keluar</a></li>
                                     
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </header>

        <div class="site-section-cover overlay" style="background-image: url('images/image9.jpg');">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-10 text-center">
                        <h1>Upload <strong>Lowongan</strong></h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-section bg-light" id="contact-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 mb-5">
                        <h2>Upload Lowongan Anda</h2>
                        <form action="uploadloker.php" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="posisi" placeholder="Posisi Pekerjaan">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="tingkat_pendidikan" placeholder="Tingkat Pendidikan">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="kategori_pekerjaan_id">Kategori Pekerjaan:</label>
                                    <select name="kategori_pekerjaan_id" id="kategori_pekerjaan_id" required>
                                        <option value="">Pilih Kategori</option>
                                        <?php
                                        $result = $koneksi->query("SELECT id, nama_kategori FROM kategori_pekerjaan");
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . $row['id'] . '">' . $row['nama_kategori'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
    <div class="col-md-12">
        <label for="gender">Gender:</label>
        <select name="gender" id="gender" required>
            <option value="">Pilih Gender</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
            <option value="Semua">Semua</option>
        </select>
    </div>
</div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="status_kerja">Status Kerja:</label>
                                    <select name="status_kerja" id="status_kerja">
                                        <option value="Full-Time">Full-Time</option>
                                        <option value="Part-Time">Part-Time</option>
                                        <option value="Kontrak">Kontrak</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="besaran_gaji">Besaran Gaji:</label>
                                    <input type="number" required name="besaran_gaji" min="0" value="0" step="any">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <textarea class="form-control" name="lokasi_bekerja" placeholder="Lokasi Bekerja" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <textarea name="syarat_pekerjaan" class="form-control" placeholder="Syarat Pekerjaan" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 mr-auto">
                                    <input type="submit" class="btn btn-block btn-primary text-white py-3 px-5" value="Upload">
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
                    <li><a href="registrasi.html">Registrasi</a></li>
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

    <script src="js/main.js"></script>

  </body>

</html>

