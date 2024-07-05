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

// Check the user's current limit_publish_users
$query = "SELECT limit_publish_users FROM users WHERE id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($limit_publish_users);
$stmt->fetch();
$stmt->close();

// Prevent the user from purchasing a new package if they still have publishing limits remaining
if ($limit_publish_users > 0) {
  echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js'></script>";
  echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              title: 'Peringatan',
              text: 'Anda masih memiliki batas publikasi yang tersisa. Silakan gunakan batas publikasi Anda sebelum membeli paket baru.',
              icon: 'warning',
              confirmButtonText: 'OK'
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = 'lowongan.php';
              }
            });
          });
        </script>";
  exit();
}



// Fetch package details
$query = "SELECT * FROM paketloker";
$result = $koneksi->query($query);
$packages = $result->fetch_all(MYSQLI_ASSOC);


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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-9zm0L8TLN8ymMiJv"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                                    <li><a href="lowongan.php?status=<?= $status ?>&user_id=<?= $user_id ?>&package_purchased=<?= $package_purchased ?>" class="nav-link">Lowongan</a><span class="badge badge-info"><?= $limit_publish_users ?></span></li>
                                    <li class="active"><a href="paket.php?status=<?= $status ?>&user_id=<?= $user_id ?>&package_purchased=<?= $package_purchased ?>" class="nav-link">Beli Paket</a></li>
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

      <div class="site-section-cover overlay" style="background-image: url('images/hero_bg.jpg');">
        <div class="container">
          <div class="row align-items-center justify-content-center">
            <div class="col-lg-10 text-center">
              <h1>Paket <strong>Lowongan Pekerjaan</strong></h1>
            </div>
          </div>
        </div>
      </div>
      <div class="container1">
            <?php foreach ($packages as $package): ?>
                <div class="package-item purchase-item">
                    <div class="title"><img src="images/<?= strtolower($package['nama_paket']) ?>-icon.png" alt="<?= $package['nama_paket'] ?> Package Icon" /></div>
                    <div class="package-title"><?= $package['nama_paket'] ?></div>
                    <div class="package-price">Rp<?= number_format($package['price'], 0, ',', '.') ?></div>
                    <ul class="package-benefits">
                        <li><i class="fas fa-star"></i> <?= $package['nama_paket'] == 'Gold' ? 'Paket super efektif' : ($package['nama_paket'] == 'Silver' ? 'Kandidat lebih banyak' : 'Paket dasar') ?></li>
                        <li><i class="fas fa-newspaper"></i> <?= $package['limit_publish'] ?> kali publikasi di Workwave.co.id</li>
                        <li><i class="fas fa-globe"></i> Website & Aplikasi</li>
                        <li><i class="fab fa-instagram"></i> Instagram Post & Story</li>
                        <li><i class="fab fa-google"></i> Google Jobs & Bisnis</li>
                        <li><i class="fab fa-facebook"></i> Facebook Post & Story</li>
                        <li><i class="fab fa-twitter"></i> Twitter in Linkedin</li>
                        <li><i class="fab fa-telegram"></i> Telegram</li>
                    </ul>
                    <div class="">
                        <button type="button" class="purchase-button" data-package-id="<?= $package['package_id'] ?>">Beli sekarang</button>
                    </div>
                </div>
            <?php endforeach; ?>
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
      <script>
        $(document).ready(function() {
    $('.purchase-button').click(function() {
        var packageId = $(this).data('package-id');
        $.ajax({
            url: 'midtrans/vendor/midtrans/midtrans-php/Midtrans/payment.php', // Update ke path yang benar
            type: 'POST',
            data: {
                package_id: packageId
            },
            success: function(response) {
                console.log("Response from payment.php:", response);
                if (response.snapToken) {
                    snap.pay(response.snapToken, {
                        onSuccess: function(result){
                            Swal.fire({
                                icon: 'success',
                                title: 'Pembayaran berhasil!',
                                text: 'Terima kasih atas pembayaran Anda.'
                            }).then(() => {
                                // Kirim detail transaksi ke server
                                $.ajax({
                                    url: 'save_transaction.php', // Endpoint baru untuk menyimpan transaksi
                                    type: 'POST',
                                    data: {
                                        user_id: <?= $user_id ?>, // Pastikan user_id dikirim dengan benar
                                        package_id: packageId,
                                        order_id: result.order_id,
                                        transaction_status: 'success', // Status hardcode menjadi success
                                        gross_amount: result.gross_amount,
                                        payment_type: result.payment_type
                                    },
                                    success: function(saveResponse) {
                                        console.log("Transaksi disimpan: ", saveResponse);
                                        setTimeout(function() {
                                            window.location.href = 'lowongan.php';
                                        }, 3000); // Delay count
                                    },
                                    error: function(saveXhr, saveStatus, saveError) {
                                        console.error("Error menyimpan transaksi: ", saveStatus, saveError);
                                    }
                                });
                            });
                            console.log(result);
                        },
                        onPending: function(result){
                            Swal.fire({
                                icon: 'info',
                                title: 'Menunggu pembayaran Anda!',
                                text: 'Silakan selesaikan pembayaran Anda.'
                            });
                            console.log(result);
                        },
                        onError: function(result){
                            Swal.fire({
                                icon: 'error',
                                title: 'Pembayaran gagal!',
                                text: 'Terjadi kesalahan saat pembayaran. Silakan coba lagi.'
                            });
                            console.log(result);
                        },
                        onClose: function(){
                            Swal.fire({
                                icon: 'warning',
                                title: 'Pembayaran belum selesai!',
                                text: 'Anda menutup popup tanpa menyelesaikan pembayaran.'
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.error
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error AJAX!',
                    text: 'Terjadi kesalahan AJAX. Silakan coba lagi.'
                });
            }
        });
    });
});


      </script>
  </body>
</html>
