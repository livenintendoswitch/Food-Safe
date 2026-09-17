<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Add this import
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model
{
    use HasFactory; // Add this trait

    protected $fillable = [
        'owner_id', 'name', 'description', 'address', 'latitude', 'longitude',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}