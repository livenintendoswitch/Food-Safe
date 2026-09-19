@extends('layouts.app')

@section('content')
<main class="p-6 max-w-md mx-auto">
    <h1 class="text-2xl font-bold mb-6">Create an account</h1>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium mb-1">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="w-full rounded-md border-gray-300 shadow-sm">
            @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                   class="w-full rounded-md border-gray-300 shadow-sm">
            @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <span class="block text-sm font-medium mb-1">I am a...</span>
            <div class="flex gap-4 text-sm">
                <label class="flex items-center gap-2">
                    <input type="radio" name="role" value="customer" {{ old('role', 'customer') === 'customer' ? 'checked' : '' }}>
                    Customer (looking for surplus food)
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="role" value="partner" {{ old('role') === 'partner' ? 'checked' : '' }}>
                    Partner (selling surplus food)
                </label>
            </div>
            @error('role')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium mb-1">Password</label>
            <input id="password" type="password" name="password" required
                   class="w-full rounded-md border-gray-300 shadow-sm">
            @error('password')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium mb-1">Confirm password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                   class="w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <button type="submit" class="w-full bg-gray-900 text-white rounded-md py-2 font-medium">
            Register
        </button>
    </form>

    <p class="text-sm text-gray-500 mt-4">
        Already have an account? <a href="{{ route('login') }}" class="underline">Log in</a>
    </p>
</main>
@endsection