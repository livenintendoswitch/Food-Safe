<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('original_price', 12, 2);
            $table->decimal('surplus_price', 12, 2);
            $table->unsignedInteger('quantity');
            $table->dateTime('pickup_start');
            $table->dateTime('pickup_end');
            $table->enum('status', ['DRAFT', 'ACTIVE', 'SOLD_OUT', 'EXPIRED'])->default('DRAFT');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
