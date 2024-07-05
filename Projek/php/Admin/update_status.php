<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';

// Ensure the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure required data is defined
    if (isset($_POST['userId']) && isset($_POST['status'])) {
        // Get values from the form
        $id = $_POST['userId'];
        $status = $_POST['status'];

        // Prepare and execute SQL statement to update status
        $sql = "UPDATE users SET status=? WHERE id=?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param('si', $status, $id);

        if ($stmt->execute()) {
            echo "Status berhasil diperbarui.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Data yang dibutuhkan tidak lengkap.";
    }
} else {
    echo "Metode yang digunakan harus POST.";
}

// Close connection
$koneksi->close();
?>
