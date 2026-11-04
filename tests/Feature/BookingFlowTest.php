<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingFlowTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Hotel $hotel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->hotel = Hotel::factory()->withRooms()->create(['price' => 500000]);
    }

    private function bookingData(array $overrides = []): array
    {
        return array_merge([
            'customer_name' => 'Budi',
            'customer_email' => 'budi@example.com',
            'customer_phone' => '081234567890',
            'check_in' => now()->addDays(2)->toDateString(),
            'check_out' => now()->addDays(4)->toDateString(),
            'guests' => 2,
            'room_type_id' => $this->hotel->roomTypes()->where('name', 'Deluxe Room')->value('id'),
        ], $overrides);
    }

    public function test_guest_must_login_to_book(): void
    {
        $this->get(route('bookings.create', $this->hotel))->assertRedirect(route('login'));
    }

    public function test_agent_cannot_use_customer_booking(): void
    {
        $this->actingAs(User::factory()->agent()->create())
            ->get(route('bookings.create', $this->hotel))
            ->assertForbidden();
    }

    public function test_price_is_calculated_on_server(): void
    {
        $this->actingAs($this->user)
            ->post(route('bookings.store', $this->hotel), $this->bookingData(['total' => 1, 'price' => 1]))
            ->assertRedirect(route('payment.create'));

        $booking = Booking::firstOrFail();
        // Deluxe 1.5 x 500.000 = 750.000 x 2 malam = 1.500.000 + pajak 10% + layanan 1%
        $this->assertSame(2, $booking->nights);
        $this->assertSame(750000, (int) $booking->price_per_night);
        $this->assertSame(1500000, (int) $booking->subtotal);
        $this->assertSame(150000, (int) $booking->tax);
        $this->assertSame(15000, (int) $booking->service_fee);
        $this->assertSame(1665000, (int) $booking->total);
        $this->assertSame('pending', $booking->status);
    }

    public function test_invalid_dates_are_rejected(): void
    {
        $this->actingAs($this->user)
            ->post(route('bookings.store', $this->hotel), $this->bookingData(['check_in' => now()->subDay()->toDateString()]))
            ->assertSessionHasErrors('check_in');

        $this->actingAs($this->user)
            ->post(route('bookings.store', $this->hotel), $this->bookingData([
                'check_in' => now()->addDays(5)->toDateString(),
                'check_out' => now()->addDays(5)->toDateString(),
            ]))
            ->assertSessionHasErrors('check_out');
    }

    public function test_room_type_must_belong_to_hotel(): void
    {
        $other = Hotel::factory()->withRooms()->create();

        $this->actingAs($this->user)
            ->post(route('bookings.store', $this->hotel), $this->bookingData(['room_type_id' => $other->roomTypes()->value('id')]))
            ->assertSessionHasErrors('room_type_id');
    }

    public function test_fully_booked_room_is_rejected(): void
    {
        $suite = $this->hotel->roomTypes()->where('name', 'Suite Room')->first(); // 2 kamar
        $data = $this->bookingData(['room_type_id' => $suite->id]);

        $this->actingAs($this->user)->post(route('bookings.store', $this->hotel), $data)->assertSessionHasNoErrors();
        $this->actingAs($this->user)->post(route('bookings.store', $this->hotel), $data)->assertSessionHasNoErrors();
        $this->actingAs($this->user)->post(route('bookings.store', $this->hotel), $data)->assertSessionHasErrors('room_type_id');

        $this->assertSame(2, Booking::count());
    }

    public function test_full_payment_flow_with_virtual_account(): void
    {
        $this->actingAs($this->user)->post(route('bookings.store', $this->hotel), $this->bookingData());
        $this->get(route('payment.create'))->assertOk()->assertSee(rupiah(1665000));

        $this->post(route('payment.store'), ['method' => 'bca']);
        $payment = Payment::firstOrFail();
        $this->assertSame(1665000, $payment->amount);
        $this->assertSame(16, strlen($payment->reference));

        $this->get(route('payment.show', $payment))->assertOk()->assertSee($payment->reference);

        $this->post(route('payment.confirm', $payment))->assertRedirect(route('bookings.index'));
        $this->assertSame('paid', $payment->fresh()->status);
        $this->assertSame('paid', Booking::first()->status);
    }

    public function test_cod_payment_confirms_booking(): void
    {
        $this->actingAs($this->user)->post(route('bookings.store', $this->hotel), $this->bookingData());
        $this->post(route('payment.store'), ['method' => 'cod']);
        $payment = Payment::firstOrFail();

        $this->post(route('payment.confirm', $payment));
        $this->assertSame('confirmed', Booking::first()->status);
    }

    public function test_user_cannot_view_other_users_payment(): void
    {
        $this->actingAs($this->user)->post(route('bookings.store', $this->hotel), $this->bookingData());
        $this->post(route('payment.store'), ['method' => 'qris']);
        $payment = Payment::firstOrFail();

        $this->actingAs(User::factory()->create())->get(route('payment.show', $payment))->assertForbidden();
    }

    public function test_expired_payment_cancels_booking(): void
    {
        $this->actingAs($this->user)->post(route('bookings.store', $this->hotel), $this->bookingData());
        $this->post(route('payment.store'), ['method' => 'qris']);
        $payment = Payment::firstOrFail();

        $this->travel(20)->minutes();
        $this->get(route('payment.show', $payment))->assertOk();

        $this->assertSame('expired', $payment->fresh()->status);
        $this->assertSame('cancelled', Booking::first()->status);
    }

    public function test_user_can_cancel_pending_booking(): void
    {
        $this->actingAs($this->user)->post(route('bookings.store', $this->hotel), $this->bookingData());
        $booking = Booking::first();

        $this->post(route('bookings.cancel', $booking))->assertSessionHas('success');
        $this->assertSame('cancelled', $booking->fresh()->status);
    }

    public function test_cart_checkout_creates_booking_for_each_hotel(): void
    {
        $second = Hotel::factory()->withRooms()->create(['price' => 300000]);

        $this->actingAs($this->user)->post(route('cart.add', $this->hotel));
        $this->postJson(route('cart.add', $second))->assertOk()->assertJson(['count' => 2]);
        $this->get(route('cart.index'))->assertSee($this->hotel->name)->assertSee($second->name);

        $data = $this->bookingData();
        unset($data['room_type_id']);
        $data['rooms'] = [
            $this->hotel->id => $this->hotel->roomTypes()->value('id'),
            $second->id => $second->roomTypes()->value('id'),
        ];

        $this->post(route('cart.checkout.store'), $data)->assertRedirect(route('payment.create'));
        $this->assertSame(2, Booking::count());
        $this->assertEmpty(session('cart'));

        $this->post(route('payment.store'), ['method' => 'bca']);
        $this->assertSame((int) Booking::sum('total'), Payment::first()->amount);
    }

    public function test_cart_remove(): void
    {
        $this->actingAs($this->user)->post(route('cart.add', $this->hotel));
        $this->delete(route('cart.remove', $this->hotel));

        $this->get(route('cart.index'))->assertSee('Keranjang Anda Kosong');
    }
}
