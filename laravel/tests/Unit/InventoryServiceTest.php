<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Listing;
use App\Services\Supply\InventoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Exception;

class InventoryServiceTest extends TestCase
{
    // This trait automatically resets the test database after every single test
    use RefreshDatabase; 

    public function test_stock_cannot_become_negative(): void
    {
        // 1. Setup a dummy listing with exactly 5 items
        $listing = Listing::factory()->create(['quantity' => 5, 'status' => 'ACTIVE']);
        $inventoryService = new InventoryService();

        // 2. Action: Ask the service if we can buy 6 items
        $isAvailable = $inventoryService->validateStockAvailable($listing, 6);

        // 3. Assert: The service must explicitly say "false"
        $this->assertFalse($isAvailable);
    }

    public function test_stock_decreases_and_marks_sold_out_at_zero(): void
    {
        // 1. Setup a dummy listing with exactly 1 item left
        $listing = Listing::factory()->create(['quantity' => 1, 'status' => 'ACTIVE']);
        $inventoryService = new InventoryService();

        // 2. Action: Decrease the stock by 1
        $inventoryService->decreaseStock($listing, 1);

        // 3. Assert: The database must show 0 quantity and SOLD_OUT status
        $this->assertEquals(0, $listing->fresh()->quantity);
        $this->assertEquals('SOLD_OUT', $listing->fresh()->status);
    }

    public function test_sold_out_listings_reject_new_orders(): void
    {
        $listing = Listing::factory()->create(['quantity' => 0, 'status' => 'SOLD_OUT']);
        $inventoryService = new InventoryService();

        // The test expects the service to throw an Exception if Backend 2 tries to force an order
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Order failed: Insufficient stock or listing unavailable.');

        $inventoryService->decreaseStock($listing, 1);
    }
}