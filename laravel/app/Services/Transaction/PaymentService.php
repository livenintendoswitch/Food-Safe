<?php

namespace App\Services\Transaction;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PaymentService
{
    public function completeMockPayment(Order $order): Order
    {
        return DB::transaction(function () use ($order): Order {
            $order = Order::query()
                ->lockForUpdate()
                ->findOrFail($order->id);

            // Aman jika user tanpa sengaja menekan tombol bayar dua kali.
            if ($order->payment_status === 'PAID') {
                return $order;
            }

            if ($order->order_status !== 'PENDING') {
                throw ValidationException::withMessages([
                    'order' => 'This order can no longer be paid.',
                ]);
            }

            $order->update([
                'payment_status' => 'PAID',
                'order_status' => 'PAID',
            ]);

            return $order->fresh();
        });
    }

    public function failMockPayment(Order $order): Order
    {
        return DB::transaction(function () use ($order): Order {
            $order = Order::query()
                ->lockForUpdate()
                ->findOrFail($order->id);

            if ($order->order_status !== 'PENDING') {
                throw ValidationException::withMessages([
                    'order' => 'This order can no longer be paid.',
                ]);
            }

            $order->update([
                'payment_status' => 'FAILED',
            ]);

            return $order->fresh();
        });
    }
}