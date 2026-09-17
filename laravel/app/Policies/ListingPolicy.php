<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Listing;

class ListingPolicy
{
    public function update(User $user, Listing $listing): bool
    {
        return $listing->restaurant?->owner_id === $user->id;
    }

    public function delete(User $user, Listing $listing): bool
    {
        return $this->update($user, $listing);
    }
}
