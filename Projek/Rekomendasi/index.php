<!DOCTYPE html>
<html>
<head>
    <title>Rekomendasi Loker</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Form Rekomendasi Loker</h1>
    <form action="groq.php" method="post">
        <label for="kategori_pekerjaan">Kategori Pekerjaan:</label>
        <select name="kategori_pekerjaan" id="kategori_pekerjaan">
            <?php
                include 'koneksi.php';
                $result = $koneksi->query("SELECT id, nama_kategori FROM kategori_pekerjaan");

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['nama_kategori'] . "</option>";
                    }
                }
                $koneksi->close();
            ?>
        </select>
        <br>
        <label for="posisi">Posisi:</label>
        <input type="text" name="posisi" id="posisi" required>
        <br>
        <br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
