document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.purchase-button').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const formId = this.closest('form').id;
            document.getElementById(formId).submit();
        });
    });
});
