document.addEventListener('DOMContentLoaded', () => {
    const quantityInput = document.getElementById('quantity');
    const estimatedTotalDisplay = document.getElementById('estimated-total');

    if (quantityInput && estimatedTotalDisplay) {
        // Retrieve the backend-provided surplus price from the data attribute
        const basePrice = parseInt(quantityInput.dataset.price, 10);

        quantityInput.addEventListener('input', (e) => {
            // Default to 1 if the field is cleared or invalid
            const quantity = parseInt(e.target.value, 10) || 1;
            
            // Calculate visual estimate
            const estimatedTotal = basePrice * quantity;
            
            // Format as Indonesian Rupiah
            estimatedTotalDisplay.textContent = new Intl.NumberFormat('id-ID').format(estimatedTotal);
        });
    }
});