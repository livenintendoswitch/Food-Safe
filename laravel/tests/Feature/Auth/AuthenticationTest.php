<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Customer Test',
            'email' => 'customer@example.test',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'role' => 'customer',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'customer@example.test',
            'role' => 'customer',
        ]);

        $user = User::query()->where('email', 'customer@example.test')->firstOrFail();

        $this->assertTrue(Hash::check('Password123!', $user->password));
    }

    public function test_customer_can_log_in(): void
    {
        $user = User::query()->create([
            'name' => 'Existing Customer',
            'email' => 'existing@example.test',
            'password' => Hash::make('Password123!'),
            'role' => 'customer',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'Password123!',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_rejects_invalid_credentials(): void
    {
        User::query()->create([
            'name' => 'Existing Customer',
            'email' => 'existing@example.test',
            'password' => Hash::make('Password123!'),
            'role' => 'customer',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => 'existing@example.test',
            'password' => 'WrongPassword123!',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_authenticated_user_can_log_out(): void
    {
        $user = User::query()->create([
            'name' => 'Existing Customer',
            'email' => 'existing@example.test',
            'password' => Hash::make('Password123!'),
            'role' => 'customer',
        ]);

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
