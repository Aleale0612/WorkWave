<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';

// Tes apakah autoload berfungsi dengan mencoba memuat kelas dari library yang diinstal dengan Composer
try {
    $client = new \GuzzleHttp\Client();
    echo "Autoload berfungsi!";
} catch (Exception $e) {
    echo 'Autoload gagal: ',  $e->getMessage(), "\n";
}
