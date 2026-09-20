<?php

namespace App\Services\Supply;

use App\Models\Listing;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ListingService
{
    public function createListing(array $validatedData): Listing
    {
        $validatedData = $this->handleImage($validatedData);

        $validatedData['status'] = $validatedData['status'] ?? 'DRAFT';

        return Listing::create($validatedData);
    }

    public function updateListing(Listing $listing, array $validatedData): bool
    {
        $validatedData = $this->handleImage($validatedData, $listing);

        return $listing->update($validatedData);
    }

    private function handleImage(
        array $validatedData,
        ?Listing $listing = null,
    ): array {
        $image = $validatedData['image'] ?? null;

        if (! $image instanceof UploadedFile) {
            unset($validatedData['image']);

            return $validatedData;
        }

    if ($listing?->image) {
        $oldPath = parse_url($listing->image, PHP_URL_PATH) ?? '';

        if (Str::startsWith($oldPath, '/storage/')) {
            Storage::disk('public')->delete(
                Str::after($oldPath, '/storage/')
            );
        }
    }

    $path = $image->store('listings', 'public');

    /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
    $disk = Storage::disk('public');

    $validatedData['image'] = $disk->url($path);

    return $validatedData;
    }
}