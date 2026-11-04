<?php

namespace Tests\Feature;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_pages_load(): void
    {
        foreach (['/', '/layanan', '/properties', '/agents', '/contact-admin', '/masuk', '/login', '/agent/login', '/admin/login', '/register', '/agent/register', '/forgot-password', '/settings/language'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_home_shows_hotels_from_database(): void
    {
        $this->get('/')->assertSee('Hotel Santika Prime')->assertSee('The Ritz-Carlton');
    }

    public function test_search_filters_by_name_and_location(): void
    {
        $this->getJson('/hotels/search?search=kempinski')
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonPath('0.name', 'Hotel Kempinski');

        $bali = $this->getJson('/hotels/search?location=Bali')->assertOk()->json();
        $this->assertNotEmpty($bali);
        foreach ($bali as $hotel) {
            $this->assertStringContainsString('Bali', $hotel['location']);
        }
    }

    public function test_inactive_hotels_are_hidden(): void
    {
        Hotel::where('name', 'Hotel Kempinski')->update(['status' => 'inactive']);

        $this->getJson('/hotels/search?search=kempinski')->assertJsonCount(0);
        $this->get('/layanan')->assertDontSee('Hotel Kempinski');
    }

    public function test_language_can_be_switched(): void
    {
        $this->get('/settings/language?lang=en')->assertRedirect('/settings/language');
        $this->get('/settings/language')->assertSee('Language Settings');
        $this->get('/settings/language?lang=xx')->assertNotFound();
    }

    public function test_maintenance_mode_blocks_public_pages_but_not_admin(): void
    {
        \App\Models\Setting::putMany(['maintenance_mode' => '1']);

        $this->get('/')->assertStatus(503);
        $this->actingAs(User::where('role', 'admin')->first())->get('/admin')->assertOk();
    }
}
