<?php

namespace App\Http\Middleware;

use App\Models\Pengaturan;
use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AutoLockscreen
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Filament::auth()->check()) {
            session()->forget(['is_locked', 'last_activity_time']);

            return $next($request);
        }

        $routeName = $request->route()?->getName();

        // Rute yang dikecualikan dari penguncian
        $exemptRouteNames = [
            'filament.admin.pages.lockscreen',
            'filament.admin.auth.login',
            'filament.admin.auth.logout',
        ];

        if (in_array($routeName, $exemptRouteNames, true) || $request->is('admin/lockscreen*') || $request->is('admin/login*') || $request->is('admin/logout*')) {
            return $next($request);
        }

        // Izinkan Livewire update untuk komponen Lockscreen saat layar terkunci
        if ($request->header('X-Livewire') && session('is_locked')) {
            $payload = json_encode($request->all());
            if (stripos($payload, 'lockscreen') !== false) {
                return $next($request);
            }
        }

        // Jika sesi sudah dalam status terkunci
        if (session('is_locked') === true) {
            if ($request->expectsJson() || $request->header('X-Livewire')) {
                return response()->json(['redirect' => route('filament.admin.pages.lockscreen')], 423);
            }

            return redirect()->route('filament.admin.pages.lockscreen');
        }

        // Cek batas waktu inaktivitas (default 5 menit)
        $timeoutMinutes = Pengaturan::getLockTimeoutMinutes();
        $timeoutSeconds = ($timeoutMinutes > 0 ? $timeoutMinutes : 5) * 60;

        $lastActivity = session('last_activity_time');

        if ($lastActivity && (time() - $lastActivity > $timeoutSeconds)) {
            session(['is_locked' => true]);

            if ($request->expectsJson() || $request->header('X-Livewire')) {
                return response()->json(['redirect' => route('filament.admin.pages.lockscreen')], 423);
            }

            return redirect()->route('filament.admin.pages.lockscreen');
        }

        // Perbarui waktu aktivitas terakhir
        session(['last_activity_time' => time()]);

        return $next($request);
    }
}
