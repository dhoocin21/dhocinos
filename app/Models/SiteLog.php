<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteLog extends Model
{
    protected $fillable = [
        'log_type',
        'source',
        'car_id',
        'ip_address',
        'user_agent',
        'region',
        'city',
        'device_brand',
        'os_platform',
        'browser_name',
        'duration_seconds',
        'created_at',
    ];

    public $timestamps = false;

    /**
     * Get City and Region from IP
     */
    public static function getLocationFromIp($ip): array
    {
        if (!$ip) {
            return ['city' => 'Surabaya', 'region' => 'Jawa Timur'];
        }

        // Check Cloudflare headers if present
        $cfCity = request()->header('CF-IPCity') ?: (isset($_SERVER['HTTP_CF_IPCITY']) ? $_SERVER['HTTP_CF_IPCITY'] : null);
        $cfRegion = request()->header('CF-IPCountry') ?: (isset($_SERVER['HTTP_CF_REGION']) ? $_SERVER['HTTP_CF_REGION'] : null);
        if ($cfCity) {
            return [
                'city' => $cfCity,
                'region' => $cfRegion ?: 'Indonesia',
            ];
        }

        return cache()->remember("ip-location-v2-{$ip}", 86400 * 7, function () use ($ip) {
            if ($ip === '127.0.0.1' || $ip === '::1' || filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
                return ['city' => 'Surabaya (Lokal)', 'region' => 'Jawa Timur'];
            }

            try {
                $response = \Illuminate\Support\Facades\Http::timeout(3)->get("http://ip-api.com/json/{$ip}?fields=status,message,countryCode,regionName,city");
                if ($response->successful()) {
                    $data = $response->json();
                    if (($data['status'] ?? '') === 'success') {
                        if (($data['countryCode'] ?? '') !== 'ID') {
                            return ['city' => 'Luar Negeri', 'region' => 'Foreign'];
                        }
                        return [
                            'city' => $data['city'] ?: ($data['regionName'] ?? 'Surabaya'),
                            'region' => $data['regionName'] ?: 'Jawa Timur',
                        ];
                    }
                }
            } catch (\Exception $e) {
                // Silently fallback
            }

            return ['city' => 'Surabaya', 'region' => 'Jawa Timur'];
        });
    }

    /**
     * Backward compatibility helper
     */
    public static function getRegionFromIp($ip)
    {
        $loc = self::getLocationFromIp($ip);
        return $loc['region'] ?? 'Unknown';
    }

    /**
     * Parse User Agent into OS, Brand, and Browser
     */
    public static function parseUserAgent(?string $userAgent): array
    {
        if (empty($userAgent)) {
            return [
                'os' => 'Unknown',
                'brand' => 'Unknown Device',
                'browser' => 'Unknown',
                'device_type' => 'Desktop',
            ];
        }

        $ua = $userAgent;
        $uaLower = strtolower($ua);

        // 1. Detect OS & Brand
        $os = 'Unknown OS';
        $brand = 'Lainnya';
        $deviceType = 'Desktop';

        if (str_contains($uaLower, 'iphone')) {
            $os = 'iOS';
            $brand = 'Apple iPhone';
            $deviceType = 'Mobile';
        } elseif (str_contains($uaLower, 'ipad')) {
            $os = 'iPadOS';
            $brand = 'Apple iPad';
            $deviceType = 'Tablet';
        } elseif (str_contains($uaLower, 'macintosh') || str_contains($uaLower, 'mac os x')) {
            $os = 'macOS';
            $brand = 'Apple Mac';
            $deviceType = 'Desktop';
        } elseif (str_contains($uaLower, 'android')) {
            $os = 'Android';
            $deviceType = 'Mobile';

            // Detect Android Manufacturer
            if (str_contains($uaLower, 'samsung') || str_contains($uaLower, 'sm-')) {
                $brand = 'Samsung Galaxy';
            } elseif (str_contains($uaLower, 'xiaomi') || str_contains($uaLower, 'redmi') || str_contains($uaLower, 'poco')) {
                $brand = 'Xiaomi';
            } elseif (str_contains($uaLower, 'oppo') || str_contains($uaLower, 'cph')) {
                $brand = 'Oppo';
            } elseif (str_contains($uaLower, 'vivo') || str_contains($uaLower, 'v2')) {
                $brand = 'Vivo';
            } elseif (str_contains($uaLower, 'realme') || str_contains($uaLower, 'rmx')) {
                $brand = 'Realme';
            } elseif (str_contains($uaLower, 'infinix')) {
                $brand = 'Infinix';
            } elseif (str_contains($uaLower, 'pixel')) {
                $brand = 'Google Pixel';
            } else {
                $brand = 'Android Phone';
            }
        } elseif (str_contains($uaLower, 'windows')) {
            $os = 'Windows PC';
            $brand = 'Windows PC';
            $deviceType = 'Desktop';
        } elseif (str_contains($uaLower, 'linux')) {
            $os = 'Linux';
            $brand = 'Linux PC';
            $deviceType = 'Desktop';
        }

        // 2. Detect Browser
        $browser = 'Chrome';
        if (str_contains($uaLower, 'samsungbrowser')) {
            $browser = 'Samsung Internet';
        } elseif (str_contains($uaLower, 'edg') || str_contains($uaLower, 'edge')) {
            $browser = 'Microsoft Edge';
        } elseif (str_contains($uaLower, 'opr') || str_contains($uaLower, 'opera')) {
            $browser = 'Opera';
        } elseif (str_contains($uaLower, 'ucbrowser')) {
            $browser = 'UC Browser';
        } elseif (str_contains($uaLower, 'firefox')) {
            $browser = 'Mozilla Firefox';
        } elseif (str_contains($uaLower, 'safari') && !str_contains($uaLower, 'chrome')) {
            $browser = 'Apple Safari';
        } elseif (str_contains($uaLower, 'chrome')) {
            $browser = 'Google Chrome';
        }

        return [
            'os' => $os,
            'brand' => $brand,
            'browser' => $browser,
            'device_type' => $deviceType,
        ];
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
