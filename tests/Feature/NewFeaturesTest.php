<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Payment;
use App\Models\Promo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewFeaturesTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Hotel $hotel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->hotel = Hotel::factory()->withRooms()->create(['name' => 'Hotel Uji', 'price' => 500000, 'rating' => 4.0]);
    }

    private function book(string $status = 'pending'): Booking
    {
        $room = $this->hotel->roomTypes()->first();
        $in = now()->addDays(3);
        $out = now()->addDays(5);

        return Booking::create(Booking::quote($room, $in, $out) + [
            'user_id' => $this->user->id, 'hotel_id' => $this->hotel->id, 'room_type_id' => $room->id,
            'customer_name' => 'Budi', 'customer_email' => 'b@example.com', 'customer_phone' => '081234567890',
            'check_in' => $in->toDateString(), 'check_out' => $out->toDateString(), 'guests' => 2, 'status' => $status,
        ]);
    }

    public function test_hotel_detail_page_shows_rooms_and_facilities(): void
    {
        $this->get(route('hotels.show', $this->hotel))
            ->assertOk()
            ->assertSee('Hotel Uji')
            ->assertSee('Deluxe Room')
            ->assertSee('Free Wi-Fi');
    }

    public function test_inactive_hotel_detail_is_hidden(): void
    {
        $this->hotel->update(['status' => 'inactive']);
        $this->get(route('hotels.show', $this->hotel))->assertNotFound();
    }

    public function test_explore_filters_and_sorting(): void
    {
        Hotel::factory()->create(['name' => 'Murah Sekali', 'price' => 200000, 'rating' => 3.0]);
        Hotel::factory()->create(['name' => 'Mahal Sekali', 'price' => 5000000, 'rating' => 4.9]);

        $this->get(route('services', ['max_price' => 300000]))->assertSee('Murah Sekali')->assertDontSee('Mahal Sekali');
        $this->get(route('services', ['min_rating' => 4.5]))->assertSee('Mahal Sekali')->assertDontSee('Murah Sekali');

        $names = collect($this->getJson(route('hotels.search', ['sort' => 'price_asc']))->json())->pluck('name');
        $this->assertSame('Murah Sekali', $names->first());
        $this->assertSame('Mahal Sekali', $names->last());
    }

    public function test_wishlist_toggle(): void
    {
        $this->actingAs($this->user)->postJson(route('wishlist.toggle', $this->hotel))
            ->assertOk()->assertJson(['added' => true, 'count' => 1]);
        $this->get(route('wishlist.index'))->assertSee('Hotel Uji');

        $this->postJson(route('wishlist.toggle', $this->hotel))->assertJson(['added' => false, 'count' => 0]);
    }

    public function test_guest_wishlist_requires_login(): void
    {
        $this->postJson(route('wishlist.toggle', $this->hotel))->assertUnauthorized();
    }

    public function test_review_requires_paid_booking_and_updates_rating(): void
    {
        $this->actingAs($this->user)->post(route('reviews.store', $this->hotel), ['rating' => 5])->assertForbidden();

        $this->book('paid');
        $this->post(route('reviews.store', $this->hotel), ['rating' => 5, 'comment' => 'Mantap'])->assertSessionHas('success');
        $this->assertSame(5.0, $this->hotel->fresh()->rating);

        // ulasan kedua dari user yang sama = update, bukan duplikat
        $this->post(route('reviews.store', $this->hotel), ['rating' => 3]);
        $this->assertSame(1, $this->hotel->reviews()->count());
        $this->assertSame(3.0, $this->hotel->fresh()->rating);

        $this->get(route('hotels.show', $this->hotel))->assertSee('Mantap');
    }

    public function test_promo_code_discount_is_applied_server_side(): void
    {
        Promo::create(['code' => 'HEMAT10', 'type' => 'percent', 'value' => 10, 'active' => true]);
        $booking = $this->book();
        $this->actingAs($this->user)->withSession(['checkout_bookings' => [$booking->id]]);

        $this->get(route('payment.create', ['promo' => 'hemat10']))->assertOk()->assertSee(rupiah((int) round($booking->total * 0.1)));

        $this->post(route('payment.store'), ['method' => 'bca', 'promo_code' => 'HEMAT10']);
        $payment = Payment::firstOrFail();
        $this->assertSame((int) $booking->total, $payment->subtotal);
        $this->assertSame((int) round($booking->total * 0.1), $payment->discount);
        $this->assertSame($payment->subtotal - $payment->discount, $payment->amount);
        $this->assertSame(1, Promo::first()->used);
    }

    public function test_invalid_promo_is_rejected(): void
    {
        Promo::create(['code' => 'LAMA', 'type' => 'fixed', 'value' => 50000, 'active' => true, 'expires_at' => now()->subDay()]);
        Promo::create(['code' => 'BESAR', 'type' => 'fixed', 'value' => 50000, 'active' => true, 'min_amount' => 99000000]);
        $booking = $this->book();
        $this->actingAs($this->user)->withSession(['checkout_bookings' => [$booking->id]]);

        $this->get(route('payment.create', ['promo' => 'LAMA']))->assertSee('sudah kadaluarsa');
        $this->get(route('payment.create', ['promo' => 'BESAR']))->assertSee('Minimal transaksi');
        $this->get(route('payment.create', ['promo' => 'TIDAKADA']))->assertSee('tidak ditemukan');

        $this->post(route('payment.store'), ['method' => 'bca', 'promo_code' => 'LAMA'])->assertSessionHasErrors('promo_code');
        $this->assertSame(0, Payment::count());
    }

    public function test_invoice_access(): void
    {
        $booking = $this->book();
        $this->actingAs($this->user)->withSession(['checkout_bookings' => [$booking->id]]);
        $this->post(route('payment.store'), ['method' => 'qris']);
        $payment = Payment::firstOrFail();

        $this->get(route('payment.invoice', $payment))->assertOk()->assertSee($payment->code)->assertSee('Hotel Uji');
        $this->actingAs(User::factory()->create())->get(route('payment.invoice', $payment))->assertForbidden();
        $this->actingAs(User::factory()->admin()->create())->get(route('payment.invoice', $payment))->assertOk();
    }

    public function test_admin_can_manage_promos(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.promos.store'), [
            'code' => 'baru20', 'type' => 'percent', 'value' => 20, 'active' => '1',
        ])->assertSessionHasNoErrors();
        $promo = Promo::where('code', 'BARU20')->firstOrFail();

        $this->post(route('admin.promos.store'), ['code' => 'X', 'type' => 'percent', 'value' => 150])->assertSessionHasErrors('value');

        $this->put(route('admin.promos.update', $promo), ['code' => 'BARU20', 'type' => 'fixed', 'value' => 25000])->assertSessionHasNoErrors();
        $this->assertFalse($promo->fresh()->active);

        $this->get(route('admin.promos.index'))->assertOk()->assertSee('BARU20');
        $this->delete(route('admin.promos.destroy', $promo));
        $this->assertModelMissing($promo);
    }

    public function test_dashboard_data_includes_revenue(): void
    {
        $this->book('paid');

        $this->actingAs(User::factory()->admin()->create())->getJson(route('admin.dashboard.data'))
            ->assertJsonPath('revenue', (int) Booking::first()->total)
            ->assertJsonCount(6, 'revenue_monthly');
    }
}
