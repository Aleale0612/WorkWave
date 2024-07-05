<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Job Prediction Form</title>
    <style>
        /* Modal Style */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Job Prediction Form</h1>
    <form id="predictionForm">
        <label for="kategori_pekerjaan_id">Kategori Pekerjaan:</label>
        <select name="kategori_pekerjaan_id" id="kategori_pekerjaan_id" required>
            <?php
            include 'koneksi.php';
            $result = $koneksi->query("SELECT id, nama_kategori FROM kategori_pekerjaan");

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nama_kategori'] . "</option>";
                }
            }
            ?>
        </select>
        <br>
        <label for="date">Bulan:</label>
        <input type="month" name="date" id="date" required>
        <br>
        <button type="submit">Dapatkan Prediksi</button>
    </form>

    <!-- The Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="predictionResult"></p>
        </div>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Handle form submission
        document.getElementById('predictionForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            const formData = new FormData(this);

            fetch('groq.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('predictionResult').textContent = 'Error: ' + data.error;
                } else {
                    document.getElementById('predictionResult').textContent = 'Prediction: ' + data.prediction;
                }
                modal.style.display = "block";
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('predictionResult').textContent = 'Error: ' + error;
                modal.style.display = "block";
            });
        });
    </script>
</body>
</html>
