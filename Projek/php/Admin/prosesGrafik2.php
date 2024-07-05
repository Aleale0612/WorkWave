<?php
include 'koneksi.php';

// Ambil data jumlah lowongan pekerjaan per bulan untuk setiap kategori
$query_kategori = "SELECT MONTH(tanggal_dipost) AS bulan, nama_kategori, COUNT(*) AS jumlah_lowongan FROM loker JOIN kategori_pekerjaan ON loker.kategori_pekerjaan_id = kategori_pekerjaan.id GROUP BY bulan, nama_kategori";
$result_kategori = mysqli_query($koneksi, $query_kategori);

$data_kategori = [];
while ($row = mysqli_fetch_assoc($result_kategori)) {
    $bulan = $row['bulan'];
    $kategori = $row['nama_kategori'];
    $jumlah_lowongan = $row['jumlah_lowongan'];

    if (!isset($data_kategori[$kategori])) {
        $data_kategori[$kategori] = [];
    }

    $data_kategori[$kategori][$bulan] = $jumlah_lowongan;
}

// Ambil data jumlah lowongan pekerjaan per bulan
$query_bulan = "SELECT MONTH(tanggal_dipost) AS bulan, COUNT(*) AS jumlah_lowongan FROM loker GROUP BY bulan";
$result_bulan = mysqli_query($koneksi, $query_bulan);

$data_bulan = [];
while ($row = mysqli_fetch_assoc($result_bulan)) {
    $bulan = $row['bulan'];
    $jumlah_lowongan = $row['jumlah_lowongan'];

    $data_bulan[$bulan] = $jumlah_lowongan;
}
mysqli_close($koneksi);
?>