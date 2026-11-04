<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Batasi route hanya untuk role tertentu, contoh: ->middleware('role:admin').
 * Versi lama tidak punya pengecekan ini sehingga halaman admin/agent
 * bisa dibuka siapa saja.
 */
class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Silakan login terlebih dahulu.'], 401);
            }

            $loginRoute = match ($roles[0] ?? 'user') {
                'admin' => 'admin.login',
                'agent' => 'agent.login',
                default => 'login',
            };

            return redirect()->guest(route($loginRoute));
        }

        if (! $user->hasRole(...$roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
