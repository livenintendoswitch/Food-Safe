@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">My Orders</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if($orders->isEmpty())
        <div class="bg-white rounded-lg shadow-sm p-8 text-center border border-gray-200">
            <p class="text-gray-500 text-lg">You haven't placed any orders yet.</p>
            <a href="{{ route('dashboard') }}" class="mt-4 inline-block text-green-600 font-semibold hover:text-green-700">Browse Surplus Food</a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center">
                    
                    <div class="mb-4 sm:mb-0">
                        <div class="flex items-center space-x-3 mb-2">
                            <span class="text-sm font-bold text-gray-500">#{{ $order->order_number ?? $order->id }}</span>
                            
                            <!-- Payment Status Badge -->
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $order->payment_status === 'PAID' ? 'bg-green-100 text-green-800' : 
                                  ($order->payment_status === 'FAILED' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ $order->payment_status }}
                            </span>

                            <!-- Order Status Badge -->
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $order->status }}
                            </span>
                        </div>
                        
                        <h3 class="text-lg font-bold text-gray-800">{{ $order->listing->food_name ?? 'Unknown Food' }}</h3>
                        <p class="text-gray-600 text-sm">{{ $order->listing->restaurant->name ?? 'Unknown Restaurant' }}</p>
                        <p class="text-gray-500 text-xs mt-1">Pickup: {{ $order->listing->pickup_window ?? 'TBA' }}</p>
                    </div>

                    <div class="text-left sm:text-right flex flex-col sm:items-end w-full sm:w-auto">
                        <p class="text-sm text-gray-600 mb-1">Qty: {{ $order->quantity }}</p>
                        <!-- Using Backend Total -->
                        <p class="text-lg font-bold text-green-600 mb-3">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        
                        <a href="{{ route('customer.orders.show', $order->id) }}" class="inline-block px-4 py-2 border border-gray-300 text-gray-700 rounded hover:bg-gray-50 transition-colors text-sm font-medium text-center w-full sm:w-auto">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('scripts')
    @vite('resources/js/customer/orders.js')
@endpush