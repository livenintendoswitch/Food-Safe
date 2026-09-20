document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('#listing-search');
    const filterButtons = document.querySelectorAll('.filter-button');
    const cards = document.querySelectorAll('.food-card');

    if (!searchInput || cards.length === 0) {
        return;
    }

    let currentFilter = 'all';

    function updateListings() {
        const keyword = searchInput.value.toLowerCase().trim();

        cards.forEach((card) => {
            const text = card.textContent.toLowerCase();
            const matchesSearch = text.includes(keyword);

            /*
             * Filter-specific backend fields are not available yet.
             * Do not independently calculate distance, price,
             * pickup date, or availability in frontend.
             */
            const matchesFilter = currentFilter === 'all';

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
