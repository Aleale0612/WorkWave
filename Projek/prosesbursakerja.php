<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'koneksi.php';

// Pastikan file ini dipanggil setelah form disubmit dengan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Tangkap data dari form
    $nama_acara = $_POST['nama_acara'];
    $deskripsi_acara = $_POST['deskripsi_acara'];
    $tanggal_acara = $_POST['tanggal_acara'];
    $waktu_acara = $_POST['waktu_acara'];
    $tempat_acara = $_POST['tempat_acara'];
    $kategori_acara = $_POST['kategori_acara'];
    $biaya_pendaftaran = $_POST['biaya_pendaftaran'];
    $kontak_penyelenggara = $_POST['kontak_penyelenggara'];
    $url_pendaftaran = $_POST['url_pendaftaran'];
    $instruksi_tambahan = $_POST['instruksi_tambahan'];

    // Proses upload foto/poster
    $target_dir = "uploads/"; // Direktori tempat menyimpan file
    $target_file = $target_dir . basename($_FILES["foto_poster"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["foto_poster"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File yang diunggah bukan gambar.<br>";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Maaf, file tersebut sudah ada.<br>";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["foto_poster"]["size"] > 500000) {
        echo "Maaf, ukuran file terlalu besar.<br>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diizinkan.<br>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Maaf, file Anda tidak diunggah.<br>";
    } else {
        if (move_uploaded_file($_FILES["foto_poster"]["tmp_name"], $target_file)) {
            echo "File " . htmlspecialchars(basename($_FILES["foto_poster"]["name"])) . " berhasil diunggah.<br>";
        } else {
            echo "Maaf, ada kesalahan saat mengunggah file.<br>";
        }
    }

    // Simpan path foto/poster ke dalam variabel untuk disimpan di database
    $foto_poster = $target_file; // Sesuaikan dengan cara Anda menyimpan lokasi foto/poster

    // Query untuk menyimpan data ke database
    $sql = "INSERT INTO event (nama_acara, deskripsi_acara, tanggal_acara, waktu_acara, tempat_acara, kategori_acara, biaya_pendaftaran, kontak_penyelenggara, url_pendaftaran, instruksi_tambahan, foto_poster)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Prepare statement
    $stmt = $koneksi->prepare($sql);
    if ($stmt === false) {
        die("Error in preparing statement: " . $koneksi->error);
    }

    // Bind parameters
    $stmt->bind_param('sssssssssss', $nama_acara, $deskripsi_acara, $tanggal_acara, $waktu_acara, $tempat_acara, $kategori_acara, $biaya_pendaftaran, $kontak_penyelenggara, $url_pendaftaran, $instruksi_tambahan, $foto_poster);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Acara berhasil disimpan.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();

    // Close the connection
    $koneksi->close();
}
?>
