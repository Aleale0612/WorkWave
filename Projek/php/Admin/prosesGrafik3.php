<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'koneksi.php';

// Initialize arrays to store labels and data
$labels = [];
$data = [];

// Fetch data from 'loker' table
$query = "SELECT posisi, COUNT(*) as jumlah FROM loker GROUP BY posisi ORDER BY posisi";
$result = mysqli_query($koneksi, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $labels[] = $row['posisi'];
        $data[] = $row['jumlah'];
    }
}
?>

