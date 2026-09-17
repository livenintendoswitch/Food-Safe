<?php

namespace App\Http\Controllers\Customer;

use App\Http\Requests\Customer\OrderRequest;
use App\Services\Transaction\OrderService;
use App\Models\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OrderController
{
    use AuthorizesRequests;

    public function index(): View
    {
        $orders = Order::query()
            ->where('customer_id', Auth::id())
            ->with(['listing', 'restaurant'])
            ->latest()
            ->get();

        return view('customer.orders', compact('orders'));
    }

    public function show(Order $order): View
    {
        $this->authorize('view', $order);

        $order->load(['listing', 'restaurant']);

        return view('customer.order-detail', compact('order'));
    }

    public function __construct(
    private OrderService $orderService,
    ) {
    }

    public function store(OrderRequest $request): RedirectResponse
    {
        $order = $this->orderService->createOrder(
            $request->user(),
            $request->integer('listing_id'),
            $request->integer('quantity'),
        );

        return redirect()
            ->route('customer.orders.show', $order)
            ->with('success', 'Order created. Continue to payment.');
    }
}

