<?php
// Mulai sesi PHP
session_start();

// Hapus semua data sesi
session_unset();

// Hancurkan sesi
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <!-- Tambahkan SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>
<body>
    <script>
        // Tampilkan pesan SweetAlert2
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Berhasil Logout',
                text: 'Anda telah berhasil logout.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect ke halaman login setelah menutup pesan
                    window.location.href = 'login.php';
                }
            });
        });
    </script>
</body>
</html>
