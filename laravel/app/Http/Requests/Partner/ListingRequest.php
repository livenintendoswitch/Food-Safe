<?php

namespace App\Http\Requests\Partner;

use Illuminate\Foundation\Http\FormRequest;

class ListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'restaurant_id' => 'required|exists:restaurants,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'original_price' => 'required|numeric|min:0',
            // Enforce business rule: Surplus price must be strictly less than original price
            'surplus_price' => 'required|numeric|min:0|lt:original_price',
            // Enforce Inventory Rule 1: Stock cannot be negative
            'quantity' => 'required|integer|min:1', 
            'pickup_start' => 'required|date|after_or_equal:today',
            'pickup_end' => 'required|date|after:pickup_start',
            'status' => 'nullable|in:DRAFT,ACTIVE,SOLD_OUT,EXPIRED',
        ];
    }

    public function messages(): array
    {
        return [
            'surplus_price.lt' => 'The surplus price must be cheaper than the original retail price.',
            'pickup_end.after' => 'The pickup end time must be later than the pickup start time.',
            'quantity.min' => 'You must list at least 1 item for sale.',
        ];
    }
}