<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';

// Ambil parameter dari POST request
$kategori = isset($_POST['kategori']) ? (int)$_POST['kategori'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';

// Bangun kueri SQL dengan filter
$sql = "SELECT loker.*, users.logo_perusahaan 
        FROM loker 
        LEFT JOIN users ON loker.user_id = users.id 
        WHERE 1=1";
$params = [];
$types = "";

if ($kategori) {
    $sql .= " AND kategori_pekerjaan_id = ?";
    $params[] = $kategori;
    $types .= "i";
}

if ($status) {
    $sql .= " AND status_kerja = ?";
    $params[] = $status;
    $types .= "s";
}

$stmt = $koneksi->prepare($sql);

// Gunakan call_user_func_array untuk mengikat parameter secara dinamis
if ($params) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$loker_result = $stmt->get_result();

// Bangun HTML untuk hasil pencarian
$output = '';

if ($loker_result->num_rows > 0) {
    while ($row = $loker_result->fetch_assoc()) {
        $output .= '
            <div class="d-flex tutorial-item mb-4">
                <div>
                    <h3><a href="#">' . htmlspecialchars($row['posisi']) . '</a></h3>
                    <p>' . htmlspecialchars($row['syarat_pekerjaan']) . '</p>
                    <p class="meta">
                        <span class="mr-2 mb-2">' . htmlspecialchars($row['tingkat_pendidikan']) . '</span>
                        <span class="mr-2 mb-2">' . htmlspecialchars($row['gender']) . '</span>
                        <span class="mr-2 mb-2">' . htmlspecialchars($row['tanggal_dipost']) . '</span>
                    </p>
                    <p><a href="#" class="btn btn-primary custom-btn" data-toggle="modal" data-target="#viewModal' . $row['id'] . '">View</a></p>
                </div>
            </div>
            <div class="modal fade" id="viewModal' . $row['id'] . '" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel' . $row['id'] . '" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewModalLabel' . $row['id'] . '">Job Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Position:</strong> ' . htmlspecialchars($row['posisi']) . '</p>
                            <p><strong>Requirements:</strong> ' . htmlspecialchars($row['syarat_pekerjaan']) . '</p>
                            <p><strong>Education Level:</strong> ' . htmlspecialchars($row['tingkat_pendidikan']) . '</p>
                            <p><strong>Gender:</strong> ' . htmlspecialchars($row['gender']) . '</p>
                            <p><strong>Posted on:</strong> ' . htmlspecialchars($row['tanggal_dipost']) . '</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="redirectPage()">Buat Surat Lamaran</button>
                            <script>
                                function redirectPage() {
                                    $(".modal").modal("hide");
                                    window.location.href = "buatSurat/bikin.php";
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>';
    }
} else {
    $output .= '<p>Tidak ada data lowongan kerja.</p>';
}

echo $output;
?>
