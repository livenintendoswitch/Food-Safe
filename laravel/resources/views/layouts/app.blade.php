<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Food Safe' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">
        @auth
        <nav class="bg-gray-900 text-white px-6 py-3 flex justify-between items-center">
            <a
                href="{{ route('customer.discovery.home') }}"
                class="font-bold text-white no-underline"
            >
                FoodSafe
            </a>
            <div class="flex gap-4 text-sm">
                @if ((auth()->user()->role ?? null) === 'partner')
                    <a href="{{ route('partner.restaurants.index') }}">Restaurant</a>
                    <a href="{{ route('partner.listings.index') }}">Listings</a>
                    <a href="{{ route('partner.orders') }}">Orders</a>
                @elseif ((auth()->user()->role ?? null) === 'customer')
                    <a href="{{ route('customer.orders') }}">Purchase History</a>
                @endif
                <span class="text-gray-300">
                    {{ auth()->user()->name }}
                    <span class="text-gray-500">
                        ({{ ucfirst(auth()->user()->role) }})
                    </span>
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </nav>
    @endauth

    @if (session('success'))
        <div class="max-w-3xl mx-auto mt-4 bg-green-100 text-green-800 px-4 py-2 rounded" data-flash>
            {{ session('success') }}
        </div>
    @endif
    {{ $slot ?? '' }}
    @yield('content')
    @stack('scripts')
</body>
</html>
