<?php

namespace App\Services\Supply;

use App\Models\Listing;

class ListingService
{
    public function createListing(array $validatedData): Listing
    {
        // Ensure a listing doesn't accidentally go live before the partner is ready
        $validatedData['status'] = $validatedData['status'] ?? 'DRAFT';
        
        return Listing::create($validatedData);
    }

    public function updateListing(Listing $listing, array $validatedData): bool
    {
        return $listing->update($validatedData);
    }
}