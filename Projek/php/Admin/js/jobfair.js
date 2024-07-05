function updateStatus(eventId, status) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../EventStatus.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = xhr.responseText.trim();
            alert(response);
            location.reload();
        }
    };
    xhr.send("id=" + eventId + "&status=" + status);
}

function EventStatus() {}