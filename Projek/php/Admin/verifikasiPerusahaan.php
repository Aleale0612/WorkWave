<?php
// Pastikan metode yang digunakan adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan data yang dibutuhkan terdefinisi
    if (isset($_POST['id'])) {
        // Ambil nilai dari formulir
        $id = $_POST['id'];

        // Include file koneksi
        include 'koneksi.php';

        // Lakukan operasi sesuai kebutuhan Anda

        // Tutup koneksi (jika perlu)
        $koneksi->close();
    } else {
        echo "Data yang dibutuhkan tidak lengkap.";
    }
} else {
    echo "Metode yang digunakan harus POST.";
}
?>
