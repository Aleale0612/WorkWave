<?php
// Start session
session_start();

// Include koneksi database atau file yang diperlukan
include 'koneksi.php'; // Pastikan file koneksi.php sesuai dengan pengaturan database Anda

// Function untuk membersihkan input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Membersihkan dan mengambil nilai input username dan password
    $username = sanitize_input($_POST['username']);
    $password = sanitize_input($_POST['password']);
    
    // Query untuk memeriksa keberadaan admin dengan username dan password yang sesuai
    $query = "SELECT * FROM admin WHERE Username = '$username' AND Password = '$password'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) == 1) {
        // Admin ditemukan, set session dan redirect ke halaman dashboard admin
        $_SESSION['admin_username'] = $username;
        header("Location: AdminPage.php");
        exit();
    } else {
        // Jika admin tidak ditemukan, tampilkan pesan error
        echo "<script>alert('Username atau password salah. Silakan coba lagi.');</script>";
        echo "<script>window.location.href='loginAdmin.php';</script>";
    }
} else {
    // Jika form tidak disubmit, redirect ke halaman login
    header("Location: loginAdmin.php");
    exit();
}

// Tutup koneksi database
mysqli_close($koneksi);
?>

