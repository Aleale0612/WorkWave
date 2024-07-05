<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Surat Lamaran</title>
</head>
<link rel="stylesheet" href="buatsuratlamaran.css">
<body>
    <h1>Buat Surat Lamaran Otomatis</h1>
    <form action="lihatHasil.php" method="post">
        <label for="name">Nama Lengkap:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="birth_place">Tempat Lahir:</label>
        <input type="text" id="birth_place" name="birth_place" required><br><br>

        <label for="dob">Tanggal Lahir:</label>
        <input type="date" id="dob" name="dob" required><br><br>

        <label for="phone">No. HP:</label>
        <input type="text" id="phone" name="phone" required><br><br>

        <label for="address">Alamat:</label>
        <input type="text" id="address" name="address" required><br><br>

        <label for="city">Domisili:</label>
        <input type="text" id="city" name="city" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="education">Pendidikan:</label>
        <textarea id="education" name="education" required></textarea><br><br>

        <label for="experience">Pengalaman Kerja:</label>
        <textarea id="experience" name="experience" required></textarea><br><br>

        <label for="skills">Keterampilan:</label>
        <textarea id="skills" name="skills" required></textarea><br><br>

        <label for="reason">Alasan untuk mengambil posisi ini:</label>
        <textarea id="reason" name="reason" required></textarea><br><br>

        <label for="company">Nama Perusahaan:</label>
        <input type="text" id="company" name="company" required><br><br>

        <label for="position">Posisi yang Dilamar:</label>
        <input type="text" id="position" name="position" required><br><br>

        <input type="submit" value="Lihat Surat Lamaran">
    </form>
    <a href="../utama.php" class="fixed-button">Kembali</a>
</body>
</html>
