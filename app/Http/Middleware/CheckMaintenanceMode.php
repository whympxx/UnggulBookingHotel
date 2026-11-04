<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/** Mode maintenance dari Website Setting: halaman publik ditutup, admin tetap bisa masuk. */
class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Setting::get('maintenance_mode') === '1'
            && ! $request->user()?->isAdmin()
            && ! $request->is('admin', 'admin/*', 'login*', 'logout')) {
            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}
