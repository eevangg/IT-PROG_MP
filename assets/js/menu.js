document.addEventListener('DOMContentLoaded', function () {
    const menuSearch = document.getElementById('menuSearch');
    const categoryFilter = document.getElementById('categoryFilter');
    const priceFilter = document.getElementById('priceFilter');
    
    // Function to check if item matches all filters
    function filterItems() {
        const searchQuery = menuSearch?.value.toLowerCase() || '';
        const selectedCategory = categoryFilter?.value || '';
        const selectedPrice = priceFilter?.value || '';
        
        const cards = document.querySelectorAll('.menu-grid .menu-cards');
        
        cards.forEach(card => {
            const itemName = card.getAttribute('data-name') || '';
            const itemCategory = card.getAttribute('data-category') || '';
            const itemPrice = parseFloat(card.getAttribute('data-price')) || 0;
            
            // Search filter (only name)
            const searchMatch = itemName.includes(searchQuery);
            
            // Category filter
            const categoryMatch = !selectedCategory || itemCategory === selectedCategory;
            
            // Price range filter
            let priceMatch = true;
            if (selectedPrice) {
                const [minPrice, maxPrice] = selectedPrice.split('-').map(Number);
                priceMatch = itemPrice >= minPrice && itemPrice <= maxPrice;
            }
            
            // Show card only if all filters match
            const shouldShow = searchMatch && categoryMatch && priceMatch;
            card.parentElement.style.display = shouldShow ? '' : 'none';
        });
    }
    
    // Event listeners
    if (menuSearch) {
        menuSearch.addEventListener('keyup', filterItems);
    }
    if (categoryFilter) {
        categoryFilter.addEventListener('change', filterItems);
    }
    if (priceFilter) {
        priceFilter.addEventListener('change', filterItems);
    }
});