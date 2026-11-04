<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->admin = User::where('role', 'admin')->firstOrFail();
    }

    public function test_admin_pages_require_admin(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));
        $this->actingAs(User::factory()->agent()->create())->get('/admin')->assertForbidden();

        foreach (['/admin', '/admin/locations', '/admin/properties', '/admin/orders', '/admin/agents', '/admin/settings'] as $url) {
            $this->actingAs($this->admin)->get($url)->assertOk();
        }
    }

    public function test_dashboard_data_is_valid_json_with_real_counts(): void
    {
        $this->actingAs($this->admin)->getJson('/admin/dashboard/data')
            ->assertOk()
            ->assertJsonPath('property', Hotel::count())
            ->assertJsonPath('agent', User::where('role', 'agent')->count())
            ->assertJsonPath('orders', Booking::count())
            ->assertJsonPath('kamar', (int) RoomType::sum('total_rooms'))
            ->assertJsonStructure(['locations', 'kamar_tersedia', 'kamar_dipakai', 'kamar_per_hotel' => [['hotel', 'tersedia', 'dipakai']]]);
    }

    public function test_admin_can_update_order_and_total_is_recalculated(): void
    {
        $order = Booking::firstOrFail();
        $checkIn = now()->addDays(30);

        $this->actingAs($this->admin)->put("/admin/orders/{$order->id}", [
            'customer_name' => 'Nama Baru',
            'check_in' => $checkIn->toDateString(),
            'check_out' => $checkIn->copy()->addDays(3)->toDateString(),
            'status' => 'confirmed',
        ])->assertRedirect(route('admin.orders.index'));

        $order->refresh();
        $this->assertSame('confirmed', $order->status);
        $this->assertSame(3, $order->nights);
        $this->assertSame(Booking::quote($order->roomType, $order->check_in, $order->check_out)['total'], (int) $order->total);
    }

    public function test_delete_order_requires_delete_method(): void
    {
        $order = Booking::firstOrFail();

        // Versi lama: GET ?delete= langsung menghapus
        $this->actingAs($this->admin)->get("/admin/orders?delete={$order->id}")->assertOk();
        $this->assertModelExists($order);

        $this->actingAs($this->admin)->delete("/admin/orders/{$order->id}");
        $this->assertModelMissing($order);
    }

    public function test_admin_can_manage_agents(): void
    {
        $this->actingAs($this->admin)->post('/admin/agents', [
            'name' => 'Agen Baru', 'email' => 'agenbaru@example.com', 'password' => 'rahasia123',
            'phone' => '0812', 'location' => 'Medan', 'bio' => 'Agen di Medan',
        ])->assertSessionHasNoErrors();

        $agent = User::where('email', 'agenbaru@example.com')->firstOrFail();
        $this->assertTrue($agent->isAgent());

        // agent baru bisa login
        $this->post('/logout');
        $this->post('/agent/login', ['email' => 'agenbaru@example.com', 'password' => 'rahasia123'])->assertRedirect(route('agent.dashboard'));
    }

    public function test_admin_can_manage_room_types(): void
    {
        $hotel = Hotel::firstOrFail();

        $this->actingAs($this->admin)->post("/admin/properties/{$hotel->id}/rooms", [
            'name' => 'Presidential Suite', 'total_rooms' => 1, 'price_multiplier' => 5,
        ])->assertSessionHasNoErrors();

        $room = $hotel->roomTypes()->where('name', 'Presidential Suite')->firstOrFail();
        $this->actingAs($this->admin)->put("/admin/rooms/{$room->id}", ['name' => 'Presidential', 'total_rooms' => 2, 'price_multiplier' => 4]);
        $this->assertSame(2, $room->fresh()->total_rooms);
    }

    public function test_website_settings_are_applied_to_site(): void
    {
        $this->actingAs($this->admin)->put('/admin/settings', [
            'site_title' => 'Hotel Hebat',
            'primary_color' => '#112233',
            'secondary_color' => '#445566',
            'default_language' => 'id',
            'timezone' => 'Asia/Jakarta',
            'footer_text' => 'Footer Baru',
        ])->assertSessionHasNoErrors();

        $this->get('/')->assertSee('Hotel Hebat')->assertSee('Footer Baru');
    }

    public function test_settings_reject_invalid_color(): void
    {
        $this->actingAs($this->admin)->put('/admin/settings', [
            'site_title' => 'X', 'primary_color' => 'red;}</style><script>', 'secondary_color' => '#445566',
            'default_language' => 'id', 'timezone' => 'Asia/Jakarta',
        ])->assertSessionHasErrors('primary_color');
    }
}
