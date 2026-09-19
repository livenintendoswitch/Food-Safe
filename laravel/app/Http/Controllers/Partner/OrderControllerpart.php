<?php

namespace App\Http\Controllers\Partner;

use App\Models\Order;
use App\Services\Transaction\PickupService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController
{
    use AuthorizesRequests;

    public function __construct(
        private PickupService $pickupService,
    ) {
    }

    public function index(): View
    {
        $orders = Order::query()
            ->whereHas(
                'restaurant',
                fn ($query) => $query->where('owner_id', Auth::id())
            )
            ->with(['customer', 'listing', 'restaurant'])
            ->latest()
            ->get();

        return view('partner.orders', compact('orders'));
    }

    public function show(Order $order): View
    {
        $this->authorize('view', $order);

        $order->load(['customer', 'listing', 'restaurant']);

        return view('partner.order-detail', compact('order'));
    }

    public function completePickup(
        Request $request,
        Order $order,
    ): RedirectResponse {
        $this->authorize('completePickup', $order);

        $validated = $request->validate([
            'pickup_code' => ['required', 'string', 'size:12'],
        ]);

        $this->pickupService->completePickup(
            $order,
            $request->user(),
            $validated['pickup_code'],
        );

        return redirect()
            ->route('partner.orders.show', $order)
            ->with('success', 'Pickup verified. Order completed.');
    }
}