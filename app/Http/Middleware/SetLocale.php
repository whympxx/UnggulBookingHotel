<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public const SUPPORTED = ['id', 'en', 'ja', 'zh'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->get('language')
            ?? $request->user()?->language
            ?? Setting::get('default_language', 'id');

        app()->setLocale(in_array($locale, self::SUPPORTED, true) ? $locale : 'id');

        // Zona waktu dari Website Setting
        $timezone = Setting::get('timezone');
        if ($timezone && in_array($timezone, timezone_identifiers_list(), true)) {
            config(['app.timezone' => $timezone]);
            date_default_timezone_set($timezone);
        }

        return $next($request);
    }
}
