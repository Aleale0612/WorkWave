<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
// Koneksi ke database
include 'koneksi.php';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$query = "SELECT limit_publish_users FROM users WHERE id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($limit_publish_users);
$stmt->fetch();
$stmt->close();

// Get filter parameters from GET request
$kategori = isset($_GET['kategori']) ? (int)$_GET['kategori'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$gaji_min = isset($_GET['gaji_min']) ? (int)$_GET['gaji_min'] : 0;
$gaji_max = isset($_GET['gaji_max']) ? (int)$_GET['gaji_max'] : PHP_INT_MAX;

// Number of records to display per page
$records_per_page = 5;

// Get the current page number from the URL, if not set default to 1
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $records_per_page;

// Build the SQL query with filters
$loker_sql = "SELECT loker.*, users.logo_perusahaan FROM loker LEFT JOIN users ON loker.user_id = users.id WHERE besaran_gaji BETWEEN ? AND ?";
$params = [$gaji_min, $gaji_max];

if ($kategori) {
    $loker_sql .= " AND kategori_pekerjaan_id = ?";
    $params[] = $kategori;
}

if ($status) {
    $loker_sql .= " AND status_kerja = ?";
    $params[] = $status;
}

$loker_sql .= " LIMIT ?, ?";
$params[] = $offset;
$params[] = $records_per_page;

$stmt = $koneksi->prepare($loker_sql);
$types = str_repeat('i', count($params) - 2) . 'ii'; // 'i' for integer and 's' for string
$stmt->bind_param($types, ...$params);
$stmt->execute();
$loker_result = $stmt->get_result();

// Fetch total number of records with salary filter
$total_query = "SELECT COUNT(*) FROM loker WHERE besaran_gaji BETWEEN ? AND ?";
$stmt_total = $koneksi->prepare($total_query);
$stmt_total->bind_param("ii", $gaji_min, $gaji_max);
$stmt_total->execute();
$stmt_total->bind_result($total_rows);
$stmt_total->fetch();
$stmt_total->close();
$total_pages = ceil($total_rows / $records_per_page);

// Fetch job categories
$query = "SELECT id, nama_kategori FROM kategori_pekerjaan";
$result = $koneksi->query($query);
$categories = $result->fetch_all(MYSQLI_ASSOC);

// Fetch status_kerja values
$status_kerja = [];
try {
    $stmt = $koneksi->prepare("SELECT DISTINCT status_kerja FROM loker");
    $stmt->execute();
    $stmt->bind_result($status);
    while ($stmt->fetch()) {
        $status_kerja[] = ['status_kerja' => $status];
    }
    $stmt->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Fetch records for the current page with salary filter
$loker_query = "
    SELECT loker.*, users.logo_perusahaan
    FROM loker
    LEFT JOIN users ON loker.user_id = users.id
    WHERE besaran_gaji BETWEEN ? AND ?
    LIMIT ?, ?
";
$stmt = $koneksi->prepare($loker_query);
$stmt->bind_param("iiii", $gaji_min, $gaji_max, $offset, $records_per_page);
$stmt->execute();
$loker_result = $stmt->get_result();

// Build the SQL query with filters
$loker_sql = "SELECT loker.*, users.logo_perusahaan, users.website, users.media_sosial FROM loker LEFT JOIN users ON loker.user_id = users.id WHERE besaran_gaji BETWEEN ? AND ?";
$params = [$gaji_min, $gaji_max];

// ... (rest of the code remains unchanged)

// Fetch records for the current page with salary filter
$loker_query = "
    SELECT loker.*, users.logo_perusahaan, users.website, users.media_sosial
    FROM loker
    LEFT JOIN users ON loker.user_id = users.id
    WHERE besaran_gaji BETWEEN ? AND ?
    LIMIT ?, ?
";
$stmt = $koneksi->prepare($loker_query);
$stmt->bind_param("iiii", $gaji_min, $gaji_max, $offset, $records_per_page);
$stmt->execute();
$loker_result = $stmt->get_result();


// Pagination untuk event
$records_per_page_event = 2;
$current_page_event = isset($_GET['page_event']) ? (int)$_GET['page_event'] : 1;
$offset_event = ($current_page_event - 1) * $records_per_page_event;

// Fetch total number of event records
$total_event_query = "SELECT COUNT(*) AS total FROM event";
$total_event_result = $koneksi->query($total_event_query);
$total_event = $total_event_result->fetch_assoc()['total'];
$total_pages_event = ceil($total_event / $records_per_page_event);

// Fetch event records for the current page
$event_query = "SELECT id, nama_acara, deskripsi_acara, foto_poster FROM event LIMIT $records_per_page_event OFFSET $offset_event";
$event_result = $koneksi->query($event_query);
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
    <link rel="stylesheet" href="css/styleutama.css">
    <link rel="stylesheet" href="css/utama.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/searchhjobb.js"></script>
    <style>
        /* Tambahkan CSS untuk chatbox */
        .chat-container {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 300px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: fixed;
            bottom: 20px;
            right: 50px;
            z-index: 1000;
            transition: all 0.3s ease-in-out;
        }

        .chat-container.minimized {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            justify-content: center;
            align-items: center;
            background-color: blue;
        }

        .chat-container.minimized .chat-header,
        .chat-container.minimized .chat-messages,
        .chat-container.minimized .chat-footer {
            display: none;
        }

        .chat-container .chat-header {
            background-color: blue;
            /* Ubah warna latar belakang menjadi biru */
            color: white;
            /* Ubah warna tulisan menjadi putih */
            padding: 10px;
            text-align: center;
            position: relative;
        }

        .chat-container .chat-header .close-btn {
            position: absolute;
            right: 10px;
            top: 10px;
            cursor: pointer;
            color: white;
            /* Warna tombol silang menjadi putih */
        }

        .chat-container .chat-messages {
            flex: 1;
            padding: 10px;
            overflow-y: auto;
            max-height: 400px;
        }

        .chat-container .chat-message {
            margin: 10px 0;
        }

        .chat-container .chat-message.user {
            text-align: right;
        }

        .chat-container .chat-message.assistant {
            text-align: left;
        }

        .chat-container .chat-footer {
            display: flex;
            border-top: 1px solid #ddd;
        }

        .chat-container .chat-footer input {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 0;
        }

        .chat-container .chat-footer button {
            padding: 10px;
            background-color: blue;
            /* Ubah warna tombol menjadi biru */
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .chat-icon {
            font-size: 24px;
            color: white;
            /* Ubah warna teks ikon menjadi putih */
            background-color: blue;
            /* Ubah warna latar belakang ikon menjadi biru */
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .chat-container {
                width: 100%;
                bottom: 0;
                right: 0;
                border-radius: 0;
            }

            .chat-container.minimized {
                width: 50px;
                height: 50px;
                bottom: 20px;
                right: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="site

-wrap" id="home-section">
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
                        <span class="d-inline-block d-lg-none">
                            <a href="#" class="site-menu-toggle js-menu-toggle py-5">
                                <span class="icon-menu h3 text-black"></span>
                            </a>
                        </span>
                        <nav class="site-navigation text-right ml-auto d-none d-lg-block" role="navigation">
                            <ul class="site-menu main-menu js-clone-nav ml-auto">
                                <li class="active"><a href="utama.php" class="nav-link">Utama</a></li>
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
                                    <li><a href="profil.php" class="nav-link">Profil</a></li>
                                    <li><a href="logout.php" class="nav-link">Keluar</a></li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </header>

        <div class="site-section-cover overlay" style="background-image: url('images/Image13.jpg');">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-10 text-center">
                        <h1><strong>W</strong>ork<strong>W</strong>ave</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-section bg-light pb-0">
    <div class="container">
        <div class="row align-items-stretch overlap">
            <div class="col-lg-8">
                <div class="box h-100 p-4">
                    <div class="form-container mb-4">
                        <h4 class="mb-3">Cari Pekerjaan</h4>
                        <form id="advanced-search-form" method="post">
                            <div class="form-group">
                                <label for="kategori">Jenis Pekerjaan:</label>
                                <select id="kategori" name="kategori" class="form-control">
                                    <option value="">Pilih Kategori</option>
                                    <?php foreach ($categories as $category) : ?>
                                        <option value="<?= htmlspecialchars($category['id']) ?>"><?= htmlspecialchars($category['nama_kategori']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">Status Kerja:</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="">Pilih Status</option>
                                    <?php foreach ($status_kerja as $status) : ?>
                                        <option value="<?= htmlspecialchars($status['status_kerja']) ?>"><?= htmlspecialchars($status['status_kerja']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Cari</button>
                        </form>
                    </div>
                    <div id="job-results">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <div class="site-section bg-light">
        <div class="container">
            <div class="row mb-5 align-items-center"></div>
            <div class="row">
                <div class="col-12">
                    <div class="heading mb-4">
                        <h2>Lowongan Pekerjaan, untuk kamu.</h2>
                    </div>
                </div>
                <div class="col-lg-8">
                    <?php if ($loker_result->num_rows > 0) : ?>
                        <?php while ($row = $loker_result->fetch_assoc()) : ?>
                            <div class="d-flex tutorial-item mb-4">
                                <?php if ($row['logo_perusahaan']) : ?>
                                    <img id="logoperus1" src="<?= htmlspecialchars($row['logo_perusahaan']) ?>" alt="Logo Perusahaan" class="logo-img">
                                <?php endif; ?>
                                <div>
                                    <h3><a href="#"><?= htmlspecialchars($row['posisi']) ?></a></h3>
                                    <p><?= htmlspecialchars($row['syarat_pekerjaan']) ?></p>
                                    <p class="meta">
                                        <span class="mr-2 mb-2"><?= htmlspecialchars($row['tingkat_pendidikan']) ?></span>
                                        <span class="mr-2 mb-2"><?= htmlspecialchars($row['gender']) ?></span>
                                        <span class="mr-2 mb-2"><?= htmlspecialchars($row['tanggal_dipost']) ?></span>
                                    </p>
                                    <p><a href="#" class="btn btn-primary custom-btn" data-toggle="modal" data-target="#viewModal<?= $row['id'] ?>">View</a></p>
                                </div>
                            </div>
                            <div class="modal fade" id="viewModal<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel<?= $row['id'] ?>" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewModalLabel<?= $row['id'] ?>">Job Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <?php if ($row['logo_perusahaan']) : ?>
                                                <div class="text-center mb-4">
                                                    <img src="<?= htmlspecialchars($row['logo_perusahaan']) ?>" alt="Logo Perusahaan" class="img-fluid logo-perusahaan">
                                                </div>
                                            <?php endif; ?>
                                            <div class="info-item">
                                                <p><strong>Posisi Pekerjaan :</strong> <?= htmlspecialchars($row['posisi']) ?></p>
                                            </div>
                                            <div class="info-item">
                                                <p><strong>Syarat Pekerjaan :</strong> <?= htmlspecialchars($row['syarat_pekerjaan']) ?></p>
                                            </div>
                                            <div class="info-item">
                                                <p><strong>Tingkat Pendidikan :</strong> <?= htmlspecialchars($row['tingkat_pendidikan']) ?></p>
                                            </div>
                                            <div class="info-item">
                                                <p><strong>Gender :</strong> <?= htmlspecialchars($row['gender']) ?></p>
                                            </div>
                                            <div class="info-item">
                                                <p><strong>Website :</strong> <?= htmlspecialchars($row['website']) ?></p>
                                            </div>
                                            <div class="info-item">
                                                <p><strong>Media Sosial :</strong> <?= htmlspecialchars($row['media_sosial']) ?></p>
                                            </div>
                                            <div class="info-item">
                                                <p><strong>Tanggal postingan :</strong> <?= htmlspecialchars($row['tanggal_dipost']) ?></p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" onclick="redirectPage()">Buat Surat Lamaran</button>
                                            <script>
                                                function redirectPage() {
                                                    $('.modal').modal('hide');
                                                    window.location.href = 'buatSurat/bikin.php';
                                                }
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <p>Tidak ada data lowongan kerja.</p>
                    <?php endif; ?>
                    <div class="custom-pagination">
                        <ul class="list-unstyled">
                            <?php for ($i = 1; $i <= max($total_pages, $total_pages_event); $i++) : ?>
                                <li><a href="?page=<?= $i ?>"><span><?= $i ?></span></a></li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                </div>
                <!-- Bagian Bursa Kerja -->
<div class="col-lg-4">
    <h4>Bursa Kerja</h4>
    <?php if ($event_result->num_rows > 0) : ?>
        <?php while ($event_row = $event_result->fetch_assoc()) : ?>
            <div class="box-side mb-3">
                <a href="event_detail.php?id=<?= $event_row['id'] ?>"><img src="<?= htmlspecialchars($event_row['foto_poster']) ?>" alt="<?= htmlspecialchars($event_row['nama_acara']) ?>" class="img-fluid"></a>
                <h3><?= htmlspecialchars($event_row['nama_acara']) ?></h3>
                <p><?= htmlspecialchars($event_row['deskripsi_acara']) ?></p>
            </div>
        <?php endwhile; ?>
    <?php else : ?>
        <p>Tidak ada acara yang tersedia.</p>
    <?php endif; ?>

    <!-- Navigasi Paginasi -->
    <div class="custom-pagination">
        <ul class="list-unstyled">
            <?php for ($i = 1; $i <= $total_pages_event; $i++) : ?>
                <li><a href="?page_event=<?= $i ?>"><span><?= $i ?></span></a></li>
            <?php endfor; ?>
        </ul>
    </div>
</div>

            </div>
        </div>
    </div>

    <div class="site-section bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center mb-5">
                    <div class="heading">
                        <span class="caption">Testimonials Perusahaan</span>
                        <h2>Users Reviews</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="testimonial-2">
                        <h3 class="h5">Website Pencari Kerja Terbaik di Yogyakarta!</h3>
                        <div>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star-o text-warning"></span>
                        </div>
                        <blockquote class="mb-4">
                            <p>"Memiliki banyak lowongan kerja dari berbagai perusahaan ternama, tampilan website mudah digunakan dan informatif, tersedia fitur filter yang lengkap untuk mempermudah pencarian lowongan kerja, proses pendaftaran dan lamaran kerja mudah dilakukan."</p>
                        </blockquote>
                        <div class="d-flex v-card align-items-center">
                            <img src="images/person_1.jpg" alt="Image" class="img-fluid mr-3">
                            <div class="author-name">
                                <span class="d-block">Joko</span>
                                <span>Owner, Ford</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="testimonial-2">
                        <h3 class="h5">Mantul!</h3>
                        <div>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star-o text-warning"></span>
                        </div>
                        <blockquote class="mb-4">
                            <p>"Menyediakan informasi gaji dan benefit yang transparan, memiliki fitur untuk pengembangan karir seperti bursa kerja dan konsultasi, tampilan website modern dan profesional."</p>
                        </blockquote>
                        <div class="d-flex v-card align-items-center">
                            <img src="images/person_2.jpg" alt="Image" class="img-fluid mr-3">
                            <div class="author-name">
                                <span class="d-block">Citra</span>
                                <span>Traveler</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="testimonial-2">
                        <h3 class="h5">Terima Kasih WorkWave!</h3>
                        <div>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star text-warning"></span>
                            <span class="icon-star-o text-warning"></span>
                        </div>
                        <blockquote class="mb-4">
                            <p>"Memiliki jumlah lowongan kerja yang sangat banyak dari berbagai sumber, tampilan website sederhana dan mudah dinavigasi, tersedia fitur filter yang lengkap dan sistem pencocokan lowongan kerja dengan profil pengguna, proses pendaftaran dan lamaran kerja mudah dilakukan."</p>
                        </blockquote>
                        <div class="d-flex v-card align-items-center">
                            <img src="images/person_3.jpg" alt="Image" class="img-fluid mr-3">
                            <div class="author-name">
                                <span class="d-block">Sari</span>
                                <span>Customer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section bg-primary py-5 cta">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 mb-4 mb-md-0">
                    <h2 class="mb-0 text-white">Kesulitan mencari pekerjaan yang cocok?</h2>
                    <p class="mb-0 opa-7">Kami akan bantu anda mendapatkan rekomendasi yang cocok dengan minat anda</p>
                </div>
                <div class="col-lg-5 text-md-right">
                    <a href="grafik.php" class="btn btn-primary btn-white">Klik disini!</a>
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
            <!-- Tambahkan Chatbox di sini -->
            <div class="chat-container minimized" id="chat-container">
                <div class="chat-header">
                    <span class="close-btn" id="close-chat">&times;</span>
                    <h10>JobAssist Datang Membantu</h10>
                </div>
                <div id="chat-messages" class="chat-messages"></div>
                <div class="chat-footer">
                    <input type="text" id="question" name="question" placeholder="Tuliskan pertanyaan anda" required>
                    <button id="send-button">Kirim</button>
                </div>
                <div class="chat-icon" id="open-chat">💬</div>
            </div>
        </div>

    </footer>

    <script>
        const chatContainer = document.getElementById('chat-container');
        const openChatBtn = document.getElementById('open-chat');
        const closeChatBtn = document.getElementById('close-chat');

        openChatBtn.addEventListener('click', () => {
            chatContainer.classList.remove('minimized');
        });

        closeChatBtn.addEventListener('click', () => {
            chatContainer.classList.add('minimized');
        });

        document.getElementById('send-button').addEventListener('click', async function() {
            const question = document.getElementById('question').value;
            if (question.trim() === '') return;

            addMessage('user', question);
            document.getElementById('question').value = '';

            try {
                const response = await fetch('LLM/groq.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        question
                    })
                });

                const data = await response.json();
                if (data.error) {
                    addMessage('assistant', 'Error: ' + data.error);
                } else if (Array.isArray(data.answer)) {
                    let answerText = '';
                    data.answer.for

                    Each(answer => {
                        answerText += `Posisi: ${answer.posisi}, Lokasi: ${answer.lokasi_bekerja}, Syarat: ${answer.syarat_pekerjaan}\n`;
                    });
                    addMessage('assistant', answerText);
                } else {
                    addMessage('assistant', data.answer);
                }
            } catch (error) {
                console.error('Error:', error);
                addMessage('assistant', 'Terjadi kesalahan.');
            }
        });

        function addMessage(role, content) {
            const messageElement = document.createElement('div');
            messageElement.className = `chat-message ${role}`;
            messageElement.innerText = content;
            document.getElementById('chat-messages').appendChild(messageElement);
            document.getElementById('chat-messages').scrollTop = document.getElementById('chat-messages').scrollHeight;
        }
    </script>
    </script>
    </script>
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

