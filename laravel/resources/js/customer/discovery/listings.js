document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('#listing-search');
    const filterButtons = document.querySelectorAll('.filter-button');
    const grid = document.querySelector('.listing-grid');
    const cards = grid ? Array.from(grid.querySelectorAll('.food-card')) : [];

    if (!searchInput || !grid) {
        return;
    }

    let currentFilter = 'all';
    const originalOrder = [...cards];

    const applyListings = () => {
        const keyword = searchInput.value.toLowerCase().trim();

        cards.forEach((card) => {
            const matchesSearch = card.textContent
                .toLowerCase()
                .includes(keyword);

            card.hidden = !matchesSearch;
        });

        if (currentFilter === 'cheapest') {
            cards
                .filter((card) => !card.hidden)
                .sort(
                    (a, b) =>
                        Number(a.dataset.price) - Number(b.dataset.price),
                )
                .forEach((card) => grid.appendChild(card));
        } else {
            originalOrder.forEach((card) => grid.appendChild(card));
        }
    };

    searchInput.addEventListener('input', applyListings);

    filterButtons.forEach((button) => {
        button.addEventListener('click', () => {
            filterButtons.forEach((item) => {
                item.classList.remove('active');
            });

            button.classList.add('active');
            currentFilter = button.dataset.filter;
            applyListings();
        });
    });
});