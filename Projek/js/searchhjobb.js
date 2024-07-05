$(document).ready(function () {
    $('#advanced-search-form').on('submit', function (e) {
      e.preventDefault();
      var kategori = $('#kategori').val();
      var status = $('#status').val();
      $.ajax({
        url: 'php/Admin/search_jobs.php',
        type: 'POST',
        data: { kategori: kategori, status: status },
        success: function (data) {
          $('#job-results').html(data);
        },
        error: function () {
          alert('Terjadi kesalahan dalam pengambilan data.');
        }
      });
    });
  });