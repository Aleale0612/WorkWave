<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    // Redirect to the login page
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];

if (isset($_POST['upload'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["logo_perusahaan"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["logo_perusahaan"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.<br>";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.<br>";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["logo_perusahaan"]["size"] > 500000) {
        echo "Sorry, your file is too large.<br>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.<br>";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["logo_perusahaan"]["tmp_name"], $target_file)) {
            // Update logo_perusahaan in database
            $query = "UPDATE users SET logo_perusahaan = ? WHERE username = ?";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param('ss', $target_file, $username);

            if ($stmt->execute()) {
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js'></script>";
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                          Swal.fire({
                            title: 'Success!',
                            text: 'Logo berhasil diupload.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                          }).then((result) => {
                            if (result.isConfirmed) {
                              window.location.href = 'profil.php';
                            }
                          });
                        });
                      </script>";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.<br>";
        }
    }
}
?>
