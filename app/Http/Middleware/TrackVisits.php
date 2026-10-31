<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SiteLog;

class TrackVisits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only track public page visits (not admin, not ajax/livewire, not assets)
        if (!$request->is('admin*', 'track/*', 'api/*') && !$request->ajax() && !$request->hasHeader('X-Livewire')) {
            
            $referer = $request->header('referer');
            $source = 'direct';
            
            if ($request->has('utm_source')) {
                $source = $request->utm_source;
            } elseif ($referer) {
                if (str_contains($referer, 'google.com')) $source = 'google';
                elseif (str_contains($referer, 'facebook.com')) $source = 'facebook';
                elseif (str_contains($referer, 'instagram.com')) $source = 'instagram';
                elseif (str_contains($referer, 'tiktok.com')) $source = 'tiktok';
            }

            $ip = $request->ip();
            $loc = SiteLog::getLocationFromIp($ip);
            $region = $loc['region'] ?? 'Jawa Timur';
            $city = $loc['city'] ?? 'Surabaya';
            
            // Skip logging for foreign visitors (bots/VPNs outside target ID market)
            if ($region === 'Foreign') {
                return $next($request);
            }

            $ua = $request->userAgent();
            $deviceInfo = SiteLog::parseUserAgent($ua);
            
            $log = SiteLog::create([
                'log_type' => 'visit',
                'source' => $source,
                'ip_address' => $ip,
                'user_agent' => $ua,
                'region' => $region,
                'city' => $city,
                'device_brand' => $deviceInfo['brand'],
                'os_platform' => $deviceInfo['os'],
                'browser_name' => $deviceInfo['browser'],
                'duration_seconds' => 5, // minimum initial duration
                'created_at' => now(),
            ]);

            session(['current_visit_id' => $log->id]);
        }

        return $next($request);
    }
}
