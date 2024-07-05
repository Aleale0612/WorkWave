<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $status = 'diterima';

    $query = "UPDATE users SET status = ? WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param('si', $status, $id);

    if ($stmt->execute()) {
        echo "User accepted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
