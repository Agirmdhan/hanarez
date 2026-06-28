<?php

namespace Tests\Feature\Auth;

use App\Models\Kamar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
        $this->assertDatabaseHas('users', [
            'nama' => 'Test User',
            'id_kamar' => 1,
            'email' => 'test@example.com',
            'role' => 'penghuni',
            'status' => 'aktif',
        ]);
        $response->assertRedirect(route('login', absolute: false));
    }

    public function test_registration_is_closed_when_all_six_rooms_are_filled(): void
    {
        for ($i = 1; $i <= 6; $i++) {
            $this->post('/register', [
                'name' => 'Penghuni '.$i,
                'email' => 'penghuni'.$i.'@example.com',
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);
        }

        $response = $this->post('/register', [
            'name' => 'Penghuni 7',
            'email' => 'penghuni7@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('users', [
            'email' => 'penghuni7@example.com',
        ]);
    }

    public function test_registration_skips_rooms_that_are_already_used_by_any_user(): void
    {
        Kamar::ensureDefaultRooms();

        User::factory()->create([
            'id_kamar' => 1,
            'role' => 'admin',
        ]);

        $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseHas('users', [
            'nama' => 'Test User',
            'email' => 'test@example.com',
            'id_kamar' => 2,
        ]);
    }
}
