<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_register_and_is_logged_in(): void
    {
        $this->post('/register', [
            'name' => 'Budi',
            'email' => 'budi@example.com',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ])->assertRedirect(route('home'));

        $this->assertAuthenticated();
        $this->assertSame('user', User::where('email', 'budi@example.com')->value('role'));
    }

    public function test_register_validates_password_confirmation_and_unique_email(): void
    {
        User::factory()->create(['email' => 'ada@example.com']);

        $this->post('/register', [
            'name' => 'X', 'email' => 'ada@example.com',
            'password' => 'rahasia123', 'password_confirmation' => 'beda12345',
        ])->assertSessionHasErrors(['email', 'password']);

        $this->assertGuest();
    }

    public function test_agent_registration_requires_agency(): void
    {
        $this->post('/agent/register', [
            'name' => 'Agen', 'email' => 'agen@example.com',
            'password' => 'rahasia123', 'password_confirmation' => 'rahasia123',
        ])->assertSessionHasErrors('agency');

        $this->post('/agent/register', [
            'name' => 'Agen', 'email' => 'agen@example.com', 'agency' => 'PT Agen',
            'password' => 'rahasia123', 'password_confirmation' => 'rahasia123',
        ])->assertRedirect(route('agent.dashboard'));
    }

    public function test_login_redirects_by_role(): void
    {
        $user = User::factory()->create();
        $agent = User::factory()->agent()->create();
        $admin = User::factory()->admin()->create();

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])->assertRedirect(route('home'));
        $this->post('/logout');
        $this->post('/agent/login', ['email' => $agent->email, 'password' => 'password'])->assertRedirect(route('agent.dashboard'));
        $this->post('/logout');
        $this->post('/admin/login', ['email' => $admin->email, 'password' => 'password'])->assertRedirect(route('admin.dashboard'));
    }

    public function test_cannot_login_on_another_roles_form(): void
    {
        $user = User::factory()->create();

        $this->post('/admin/login', ['email' => $user->email, 'password' => 'password'])->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_wrong_password_is_rejected(): void
    {
        $user = User::factory()->create();

        $this->post('/login', ['email' => $user->email, 'password' => 'salah'])->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_admin_registration_is_closed_without_code(): void
    {
        config(['app.admin_registration_code' => null]);
        $this->get('/admin/register')->assertNotFound();
    }

    public function test_admin_registration_requires_valid_code(): void
    {
        config(['app.admin_registration_code' => 'kode-rahasia']);
        $payload = ['name' => 'Admin', 'email' => 'adm@example.com', 'password' => 'rahasia123', 'password_confirmation' => 'rahasia123'];

        $this->post('/admin/register', $payload + ['admin_code' => 'salah'])->assertSessionHasErrors('admin_code');
        $this->post('/admin/register', $payload + ['admin_code' => 'kode-rahasia'])->assertRedirect(route('admin.dashboard'));
        $this->assertSame('admin', User::where('email', 'adm@example.com')->value('role'));
    }

    public function test_user_can_change_password(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->put('/settings/password', [
            'current_password' => 'salah', 'password' => 'baru12345', 'password_confirmation' => 'baru12345',
        ])->assertSessionHasErrors('current_password');

        $this->actingAs($user)->put('/settings/password', [
            'current_password' => 'password', 'password' => 'baru12345', 'password_confirmation' => 'baru12345',
        ])->assertSessionHasNoErrors();

        $this->assertTrue(\Hash::check('baru12345', $user->fresh()->password));
    }

    public function test_user_can_update_profile(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->put('/profile', ['name' => 'Nama Baru', 'email' => 'baru@example.com', 'phone' => '0812345678'])
            ->assertSessionHasNoErrors();

        $this->assertSame('Nama Baru', $user->fresh()->name);
    }

    public function test_password_reset_link_is_sent(): void
    {
        \Notification::fake();
        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email])->assertSessionHas('success');
        \Notification::assertSentTo($user, \Illuminate\Auth\Notifications\ResetPassword::class);
    }
}
