<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_logout()
    {
        $user = User::factory()->create(['role' => 'guru']);

        // Login user
        $this->actingAs($user);

        // Make sure user is authenticated
        $this->assertAuthenticatedAs($user);

        // Perform logout
        $response = $this->post('/logout');

        // Should redirect to login
        $response->assertRedirect('/login');

        // User should be logged out
        $this->assertGuest();
    }
}