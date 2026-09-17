<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Add this import
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Listing extends Model
{
    use HasFactory; // Add this trait

    protected $fillable = [
        'restaurant_id', 'name', 'description', 'image',
        'original_price', 'surplus_price', 'quantity',
        'pickup_start', 'pickup_end', 'status',
    ];

    protected function casts(): array
    {
        return [
            'original_price' => 'decimal:2',
            'surplus_price' => 'decimal:2',
            'pickup_start' => 'datetime',
            'pickup_end' => 'datetime',
        ];
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function isAvailable(): bool
    {
        return $this->status === 'ACTIVE' 
            && $this->quantity > 0 
            && $this->pickup_end->isFuture();
    }
}