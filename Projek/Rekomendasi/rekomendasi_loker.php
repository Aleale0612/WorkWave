<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Rekomendasi Loker</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <h1>Hasil Rekomendasi Loker</h1>
    <div id="loker">
        <?php
        if (isset($_SESSION['resultGroq'])) {
            $data = $_SESSION['resultGroq'];
            $lines = explode("\n", $data);
            $job = [];
            foreach ($lines as $line) {
                if (strpos($line, 'ID:') !== false) {
                    if (!empty($job)) {
                        // Display the previous job before starting a new one
                        echo '<div class="card mb-3">';
                        echo '<div class="row g-0">';
                        echo '<div class="col-md-4">';
                        echo '</div>';
                        echo '<div class="col-md-8">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . htmlspecialchars($job["Posisi"] ?? 'Posisi tidak tersedia') . '</h5>';
                        echo '<p class="card-text">' . htmlspecialchars($job["Syarat Pekerjaan"] ?? 'Syarat pekerjaan tidak tersedia') . '</p>';
                        echo '<span class="badge rounded-pill text-bg-secondary">' . htmlspecialchars($job["Besaran Gaji"] ?? 'Gaji tidak tersedia') . '</span>';
                        echo '</div>';
                        echo '<div class="card-footer text-end text-muted">Last updated today.</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    // Start a new job
                    $job = [];
                }

                // Extract job details
                if (strpos($line, 'Posisi:') !== false) {
                    $job["Posisi"] = trim(explode(':', $line, 2)[1]);
                }
                if (strpos($line, 'Tingkat Pendidikan:') !== false) {
                    $job["Tingkat Pendidikan"] = trim(explode(':', $line, 2)[1]);
                }
                if (strpos($line, 'Gender:') !== false) {
                    $job["Gender"] = trim(explode(':', $line, 2)[1]);
                }
                if (strpos($line, 'Status Kerja:') !== false) {
                    $job["Status Kerja"] = trim(explode(':', $line, 2)[1]);
                }
                if (strpos($line, 'Besaran Gaji:') !== false) {
                    $job["Besaran Gaji"] = trim(explode(':', $line, 2)[1]);
                }
                if (strpos($line, 'Syarat Pekerjaan:') !== false) {
                    $job["Syarat Pekerjaan"] = trim(explode(':', $line, 2)[1]);
                }
                if (strpos($line, 'Kategori Pekerjaan:') !== false) {
                    $job["Kategori Pekerjaan"] = trim(explode(':', $line, 2)[1]);
                }
            }

            // Display the last job
            if (!empty($job)) {
                echo '<div class="card mb-3">';
                echo '<div class="row g-0">';
                echo '<div class="col-md-4">';
                echo '</div>';
                echo '<div class="col-md-8">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . htmlspecialchars($job["Posisi"] ?? 'Posisi tidak tersedia') . '</h5>';
                echo '<p class="card-text">' . htmlspecialchars($job["Syarat Pekerjaan"] ?? 'Syarat pekerjaan tidak tersedia') . '</p>';
                echo '<span class="badge rounded-pill text-bg-secondary">' . htmlspecialchars($job["Besaran Gaji"] ?? 'Gaji tidak tersedia') . '</span>';
                echo '</div>';
                echo '<div class="card-footer text-end text-muted">Last updated today.</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }

            unset($_SESSION['resultGroq']);
        } else {
            echo "Tidak ada rekomendasi yang tersedia.";
        }
        ?>
    </div>
    <a href="index.php">Kembali</a>
</body>
</html>
