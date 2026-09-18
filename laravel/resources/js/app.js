document.addEventListener('DOMContentLoaded', () => {
    const searchInput =
        document.querySelector('#browse-search') ||
        document.querySelector('.search-input');

    const filterButtons = document.querySelectorAll('.filter-button');
    const cards = document.querySelectorAll('.food-card');

    if (!searchInput || cards.length === 0) {
        return;
    }

    let currentFilter = 'all';

    function updateListings() {
        const keyword = searchInput.value.toLowerCase().trim();

        cards.forEach((card) => {
            const name =
                card.dataset.name?.toLowerCase() ||
                card.querySelector('h3')?.textContent.toLowerCase() ||
                '';

            const restaurant =
                card.dataset.restaurant?.toLowerCase() ||
                card.querySelector('.restaurant-name')?.textContent.toLowerCase() ||
                '';

            const distance = Number(card.dataset.distance || 0);
            const price = Number(card.dataset.price || 0);

            const matchesSearch =
                name.includes(keyword) ||
                restaurant.includes(keyword);

            let matchesFilter = true;

            if (currentFilter === 'nearest') {
                matchesFilter = distance <= 1.5;
            }

            if (currentFilter === 'cheapest') {
                matchesFilter = price <= 15000;
            }

            if (currentFilter === 'today') {
                matchesFilter = true;
            }

            card.style.display =
                matchesSearch && matchesFilter ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', updateListings);

    filterButtons.forEach((button) => {
        button.addEventListener('click', () => {
            filterButtons.forEach((item) => {
                item.classList.remove('active');
            });

            button.classList.add('active');
            currentFilter = button.dataset.filter;

            updateListings();
        });
    });
});
