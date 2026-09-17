<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('restaurant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('listing_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('quantity');
            $table->decimal('total_price', 12, 2);
            $table->enum('payment_status', ['PENDING', 'PAID', 'FAILED'])->default('PENDING');
            $table->enum('order_status', ['PENDING', 'PAID', 'READY_FOR_PICKUP', 'COMPLETED', 'CANCELLED', 'EXPIRED'])->default('PENDING');
            $table->string('pickup_code', 12)->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
