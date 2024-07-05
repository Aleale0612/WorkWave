// Fungsi untuk menerima pengguna
function acceptUser(userId) {
    if (confirm('Are you sure to accept this user?')) {
        // Kirim permintaan AJAX untuk memperbarui status pengguna menjadi "diterima"
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Refresh halaman setelah berhasil
                window.location.reload();
            }
        };
        xhttp.open("POST", "prosesTerima.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("id=" + userId);
    }
}

// Fungsi untuk menolak pengguna
function rejectUser(userId) {
    if (confirm('Are you sure to reject this user?')) {
        // Kirim permintaan AJAX untuk memperbarui status pengguna menjadi "ditolak"
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Refresh halaman setelah berhasil
                window.location.reload();
            }
        };
        xhttp.open("POST", "prosesTolak.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("id=" + userId);
    }
}
