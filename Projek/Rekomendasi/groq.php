<?php
require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/functions.php';
include 'koneksi.php';

use LucianoTonet\GroqPHP\Groq;

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$apiKey = getenv('GROQ_API_KEY');

session_start();

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $kategori_pekerjaan = filter_input(INPUT_POST, 'kategori_pekerjaan', FILTER_SANITIZE_NUMBER_INT);
        $posisi = filter_input(INPUT_POST, 'posisi', FILTER_SANITIZE_STRING);
        $lokasi_bekerja = filter_input(INPUT_POST, 'lokasi_bekerja', FILTER_SANITIZE_STRING);
    }
    
    $loker = getLokerDetails($koneksi);
    $groq = new Groq($apiKey);
    $lokerDetails = "Berikut adalah detail loker:\n";
    
    if ($loker != []) {
        while ($row = $loker->fetch_assoc()) {
            $lokerDetails .= "ID: " . $row['id'] . "\n";
            $lokerDetails .= "Posisi: " . $row['posisi'] . "\n";
            $lokerDetails .= "Tingkat Pendidikan: " . $row['tingkat_pendidikan'] . "\n";
            $lokerDetails .= "Gender: " . $row['gender'] . "\n";
            $lokerDetails .= "Status Kerja: " . $row['status_kerja'] . "\n";
            $lokerDetails .= "Besaran Gaji: " . $row['besaran_gaji'] . "\n";
            $lokerDetails .= "Syarat Pekerjaan: " . $row['syarat_pekerjaan'] . "\n";
            $lokerDetails .= "Kategori Pekerjaan: " . $row['nama_kategori'] . "\n";
            $lokerDetails .= "-----------------------------------\n";
        }
    } else {
        $lokerDetails = "Tidak ada detail loker yang tersedia.";
    }

    $chatCompletion = $groq->chat()->completions()->create([
        'model'    => 'mixtral-8x7b-32768', // Pastikan model ID ini benar
        'messages' => [
            [
                'role'    => 'system',
                'content' => 'Kamu adalah asisten yang memberikan rekomendasi loker berdasarkan data pengguna dan loker yang tersedia dalam bahasa indonesia. dan tidak menampilkan yang tidak diperlukan' . $lokerDetails
            ],
            [
                'role'    => 'user',
                'content' => 'Data saya: Kategori Pekerjaan: ' . $kategori_pekerjaan . ', Posisi: ' . $posisi . '. Tolong berikan rekomendasi loker yang sesuai dengan detail loker yang tersedia di atas.'
            ],
        ],
    ]);

    if (!is_null($chatCompletion)) {
        $_SESSION['resultGroq'] = $chatCompletion['choices'][0]['message']['content'];
        header("Location: rekomendasi_loker.php");
        die();
    } else {
        $_SESSION['resultGroq'] = "Terjadi kesalahan.";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
