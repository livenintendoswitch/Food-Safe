<?php

namespace App\Services\Supply;

use App\Models\Listing;
use Exception;

class InventoryService
{
    /**
     * Contract for Backend 2: Validates if an order can proceed.
     */
    public function validateStockAvailable(Listing $listing, int $requestedQuantity): bool
    {
        // Inventory Rule 4: A SOLD_OUT or EXPIRED listing cannot accept a new order
        if ($listing->status === 'SOLD_OUT' || $listing->status === 'EXPIRED' || $listing->status === 'DRAFT') {
            return false;
        }

        // Inventory Rule 1: Stock cannot become negative
        return $listing->quantity >= $requestedQuantity;
    }

    /**
     * Contract for Backend 2: Executed when a customer successfully checks out.
     */
    public function decreaseStock(Listing $listing, int $orderedQuantity): void
    {
        if (!$this->validateStockAvailable($listing, $orderedQuantity)) {
            throw new Exception('Order failed: Insufficient stock or listing unavailable.');
        }

        // Inventory Rule 2: Decrease the stock by the ordered amount
        $listing->quantity -= $orderedQuantity;

        // Inventory Rule 3: If stock hits zero, automatically mark as SOLD_OUT
        if ($listing->quantity === 0) {
            $listing->status = 'SOLD_OUT';
        }

        $listing->save();
    }
}