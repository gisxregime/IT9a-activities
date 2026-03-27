document.addEventListener('DOMContentLoaded', function () {
    // Keep focus behavior predictable for Bootstrap modals.
    var modals = document.querySelectorAll('.modal');
    modals.forEach(function (modalElement) {
        modalElement.addEventListener('shown.bs.modal', function () {
            var firstInput = modalElement.querySelector('input, select, textarea, button');
            if (firstInput) {
                firstInput.focus();
            }
        });
    });
});
