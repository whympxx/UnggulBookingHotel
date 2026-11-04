<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class AgentTest extends TestCase
{
    use RefreshDatabase;

    private User $agent;
    private array $uploaded = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->agent = User::factory()->agent()->create();
    }

    protected function tearDown(): void
    {
        foreach ($this->uploaded as $path) {
            File::delete(public_path($path));
        }
        parent::tearDown();
    }

    public function test_dashboard_requires_agent_role(): void
    {
        $this->get('/agent')->assertRedirect(route('agent.login'));
        $this->actingAs(User::factory()->create())->get('/agent')->assertForbidden();
        $this->actingAs($this->agent)->get('/agent')->assertOk()->assertSee($this->agent->name);
    }

    public function test_agent_can_create_hotel_with_default_rooms(): void
    {
        $response = $this->actingAs($this->agent)->postJson('/agent/hotels', [
            'name' => 'Hotel Baru',
            'location' => 'Surabaya',
            'description' => 'Hotel nyaman',
            'price' => 450000,
            'rating' => 4,
            'image' => $this->realImage(),
        ])->assertCreated()->assertJsonPath('success', true);

        $hotel = Hotel::where('name', 'Hotel Baru')->firstOrFail();
        $this->uploaded[] = $hotel->image;

        $this->assertSame($this->agent->id, $hotel->agent_id);
        $this->assertSame(3, $hotel->roomTypes()->count());
        $this->assertFileExists(public_path($hotel->image));
        $response->assertJsonPath('data.id', $hotel->id);

        // muncul di halaman publik
        $this->get('/layanan')->assertSee('Hotel Baru');
    }

    public function test_create_hotel_validates_input(): void
    {
        $this->actingAs($this->agent)->postJson('/agent/hotels', ['name' => ''])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'location', 'description', 'price', 'rating', 'image']);
    }

    public function test_agent_lists_and_filters_only_own_hotels(): void
    {
        Hotel::factory()->create(['agent_id' => $this->agent->id, 'name' => 'Milik Saya', 'rating' => 4.5]);
        Hotel::factory()->create(['agent_id' => $this->agent->id, 'name' => 'Bintang Tiga', 'rating' => 3.2]);
        Hotel::factory()->create(['name' => 'Milik Orang Lain']);

        $this->actingAs($this->agent)->getJson('/agent/hotels')->assertJsonPath('total', 2);
        $this->actingAs($this->agent)->getJson('/agent/hotels?rating=4')->assertJsonPath('total', 1)->assertJsonPath('data.0.name', 'Milik Saya');
        $this->actingAs($this->agent)->getJson('/agent/hotels?search=bintang')->assertJsonPath('total', 1);
    }

    public function test_agent_can_update_and_delete_own_hotel(): void
    {
        $hotel = Hotel::factory()->create(['agent_id' => $this->agent->id]);

        $this->actingAs($this->agent)->putJson("/agent/hotels/{$hotel->id}", [
            'name' => 'Nama Baru', 'location' => 'Bandung', 'description' => 'x', 'price' => 600000, 'rating' => 5,
        ])->assertOk();
        $this->assertSame('Nama Baru', $hotel->fresh()->name);

        $this->actingAs($this->agent)->deleteJson("/agent/hotels/{$hotel->id}")->assertOk();
        $this->assertModelMissing($hotel);
    }

    public function test_agent_cannot_touch_other_agents_hotel(): void
    {
        $hotel = Hotel::factory()->create(['agent_id' => User::factory()->agent()->create()->id]);

        $this->actingAs($this->agent)->getJson("/agent/hotels/{$hotel->id}")->assertForbidden();
        $this->actingAs($this->agent)->deleteJson("/agent/hotels/{$hotel->id}")->assertForbidden();
        $this->assertModelExists($hotel);
    }

    public function test_hotel_with_active_booking_cannot_be_deleted(): void
    {
        $hotel = Hotel::factory()->withRooms()->create(['agent_id' => $this->agent->id]);
        $this->makeBooking($hotel, 'paid');

        $this->actingAs($this->agent)->deleteJson("/agent/hotels/{$hotel->id}")->assertUnprocessable();
    }

    public function test_reports_use_real_booking_data(): void
    {
        $hotel = Hotel::factory()->withRooms()->create(['agent_id' => $this->agent->id, 'name' => 'Hotel Laporan']);
        $paid = $this->makeBooking($hotel, 'paid');
        $this->makeBooking($hotel, 'pending');

        $this->actingAs($this->agent)->getJson('/agent/reports?type=monthly')
            ->assertJsonPath('total_bookings', 2)
            ->assertJsonPath('total_revenue', $paid->total)
            ->assertJsonPath('top_hotel', 'Hotel Laporan');

        $this->actingAs($this->agent)->getJson('/agent/reports?type=revenue')
            ->assertJsonPath('revenue_per_hotel.Hotel Laporan', $paid->total);
    }

    /** Salinan gambar asli (UploadedFile::fake()->image() butuh ekstensi GD). */
    private function realImage(): UploadedFile
    {
        $tmp = tempnam(sys_get_temp_dir(), 'img');
        copy(public_path('images/default-hotel.jpg'), $tmp);

        return new UploadedFile($tmp, 'hotel.jpg', 'image/jpeg', null, true);
    }

    private function makeBooking(Hotel $hotel, string $status): Booking
    {
        $room = $hotel->roomTypes()->first();
        $in = now()->startOfMonth()->addDays(1);
        $out = $in->copy()->addDays(2);

        return Booking::create(Booking::quote($room, $in, $out) + [
            'hotel_id' => $hotel->id, 'room_type_id' => $room->id,
            'customer_name' => 'Tamu', 'customer_email' => 't@example.com', 'customer_phone' => '0812345678',
            'check_in' => $in->toDateString(), 'check_out' => $out->toDateString(), 'guests' => 1, 'status' => $status,
        ]);
    }
}
