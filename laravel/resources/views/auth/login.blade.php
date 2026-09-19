@extends('layouts.app')

@section('content')
<main class="p-6 max-w-md mx-auto">
    <h1 class="text-2xl font-bold mb-6">Log in</h1>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full rounded-md border-gray-300 shadow-sm">
            @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium mb-1">Password</label>
            <input id="password" type="password" name="password" required
                   class="w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="remember">
            Remember me
        </label>

        <button type="submit" class="w-full bg-gray-900 text-white rounded-md py-2 font-medium">
            Log in
        </button>
    </form>

    <p class="text-sm text-gray-500 mt-4">
        Don't have an account? <a href="{{ route('register') }}" class="underline">Register</a>
    </p>
</main>
@endsection