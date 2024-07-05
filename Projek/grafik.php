<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include 'php/Admin/prosesGrafik3.php';  // Kode untuk Grafik 1
include 'php/Admin/prosesGrafik2.php';  // Kode untuk Grafik 2

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Check the user's current limit_publish_users
include 'koneksi.php';
$query = "SELECT limit_publish_users FROM users WHERE id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($limit_publish_users);
$stmt->fetch();
$stmt->close();
?>
<!doctype html>
<html lang="id">

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
    <link rel="stylesheet" href="css/grafik.css">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .container-grafik {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .grafik {
            width: 48%;
        }
        .container-grafik {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .grafik {
            width: 48%;
        }
        .form-prediksi {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .form-prediksi h2 {
            margin-bottom: 20px;
        }
        .form-prediksi label {
            display: block;
            margin-bottom: 5px;
        }
        .form-prediksi select,
        .form-prediksi input,
        .form-prediksi button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .form-prediksi button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-prediksi button:hover {
            background-color: #0056b3;
        }
        .prediction-result {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #e9ecef;
        }

         /* Modal Style */
         .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
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

                <div class="col-3">
                    <div class="site-logo">
                        <a href="utama.php"><strong>W</strong>ork<strong>W</strong>ave</a>
                    </div>
                </div>

                <div class="col-9 text-right">
                    <span class="d-inline-block d-lg-none"><a href="#" class="site-menu-toggle js-menu-toggle py-5"><span class="icon-menu h3 text-black"></span></a></span>
                    <nav class="site-navigation text-right ml-auto d-none d-lg-block" role="navigation">
                        <ul class="site-menu main-menu js-clone-nav ml-auto ">
                            <li><a href="utama.php" class="nav-link">Utama</a></li>
                            <li class="active"><a href="grafik.php" class="nav-link">Grafik</a></li>
                            <li><a href="bursakerja.php" class="nav-link">Bursa Kerja</a></li>
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

    <div class="site-section-cover overlay" style="background-image: url('images/Image4.jpg');">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1>Grafik Tren<strong> Lowongan Pekerjaan</strong></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section bg-light">
        <div class="container container-grafik">
            <div class="grafik">
                <h2>Jumlah Lowongan Berdasarkan Kategori</h2>
                <div id="bar-chart"></div>
            </div>
            <div class="grafik">
                <h2>Tren Lowongan Pekerjaan Per Bulan</h2>
                <div id="line-chart"></div>
            </div>
        </div>
        <div class="form-prediksi">
            <h2>Prediksi Lowongan Pekerjaan Anda Disini!</h2>
            <form id="prediction-form">
                <label for="kategori_pekerjaan_id">Kategori Pekerjaan:</label>
                <select name="kategori_pekerjaan_id" id="kategori_pekerjaan_id" required>
                    <?php
                    include 'koneksi.php';
                    $result = $koneksi->query("SELECT id, nama_kategori FROM kategori_pekerjaan");

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['nama_kategori'] . "</option>";
                        }
                    }
                    ?>
                </select>
                <label for="date">Bulan:</label>
                <input type="month" name="date" id="date" required>
                <button type="submit" class="btn btn-primary">Dapatkan Prediksi</button>
            </form>
        </div>
         <!-- The Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="predictionResult"></p>
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
                                <li><a href="bursakerja.php">Bursa Kerja</a></li>
                                <li><a href="#">Partisipasi Bursa Kerja</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3">
                            <h2 class="footer-heading mb-4"></h2>
                            <ul class="list-unstyled">
                                <li><a href="registrasi.php">Registrasi</a></li>
                                <li><a href="login.php">Masuk</a></li>
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
        // Data untuk Grafik Bar
        var barOptions = {
            chart: {
                type: 'bar',
                height: 350
            },
            series: [{
                name: 'Jumlah Lowongan Pekerjaan',
                data: <?php echo json_encode($data); ?>
            }],
            xaxis: {
                categories: <?php echo json_encode($labels); ?>,
                title: {
                    text: 'Kategori Pekerjaan'
                }
            },
            yaxis: {
                title: {
                    text: 'Jumlah Lowongan'
                }
            },
            colors: ['#008FFB']
        };

        var barChart = new ApexCharts(document.querySelector("#bar-chart"), barOptions);
        barChart.render();

        // Data untuk Grafik Line
        var lineOptions = {
            chart: {
                type: 'line',
                height: 350
            },
            series: [],
            xaxis: {
                categories: [],
                title: {
                    text: 'Bulan'
                }
            },
            colors: ['#00E396', '#FEB019', '#FF4560', '#775DD0']
        };

        var lineChart = new ApexCharts(document.querySelector("#line-chart"), lineOptions);

        var dataKategori = <?php echo json_encode($data_kategori); ?>;
        var bulan = <?php echo json_encode(array_keys($data_bulan)); ?>;

        var namaBulan = bulan.map(function(bulanAngka) {
            var date = new Date();
            date.setMonth(bulanAngka - 1);
            return date.toLocaleString('default', { month: 'long' });
        });

        for (var kategori in dataKategori) {
            var seriesData = [];
            for (var i = 0; i < bulan.length; i++) {
                seriesData.push(dataKategori[kategori][bulan[i]] || 0);
            }
            lineOptions.series.push({ name: kategori, data: seriesData });
        }
        lineOptions.xaxis.categories = namaBulan;

        lineChart.render();

        // Handle form submission
        document.getElementById('prediction-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            const formData = new FormData(this);

            fetch('Prediksi/groq.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('predictionResult').textContent = 'Error: ' + data.error;
                } else {
                    document.getElementById('predictionResult').textContent = 'Prediction: ' + data.prediction;
                }
                modal.style.display = "block";
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('predictionResult').textContent = 'Error: ' + error;
                modal.style.display = "block";
            });
        });

        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</div>

</body>
</html>
