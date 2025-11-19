document.addEventListener('DOMContentLoaded', function () {
    // Filter functionality
    document.getElementById('menuFilter').addEventListener('keyup', function () {
        const query = this.value.toLowerCase();
        const cards = document.querySelectorAll('.menu-grid .menu-cards');
        cards.forEach(card => {
            const text = card.textContent.toLowerCase();
            card.parentElement.style.display = text.includes(query) ? '' : 'none';
        });
    });


});