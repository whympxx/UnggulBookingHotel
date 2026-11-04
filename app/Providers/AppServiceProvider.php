<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Pengaturan website tersedia di semua view sebagai $site
        View::composer('*', function ($view) {
            $view->with('site', $this->siteSettings());
        });

        // Jumlah item keranjang & wishlist untuk badge di navbar
        View::composer('partials.navbar', function ($view) {
            $user = auth()->user();
            $isCustomer = $user?->role === 'user';
            $view->with('navCounts', [
                'cart' => $isCustomer ? count(session('cart', [])) : 0,
                'wishlist' => $isCustomer ? $user->wishlist()->count() : 0,
            ]);
        });
    }

    private function siteSettings(): array
    {
        try {
            return Setting::allValues();
        } catch (Throwable) {
            return Setting::DEFAULTS;
        }
    }
}
