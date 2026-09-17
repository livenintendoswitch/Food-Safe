<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
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

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
