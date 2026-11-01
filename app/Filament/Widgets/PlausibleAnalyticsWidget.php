<?php

namespace App\Filament\Widgets;

use App\Models\SiteLog;
use App\Models\TestDriveBooking;
use App\Models\Setting;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PlausibleAnalyticsWidget extends Widget
{
    protected static string $view = 'filament.widgets.plausible-analytics';
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return Setting::isPro();
    }

    protected function getViewData(): array
    {
        $now = now();
        $thirtyDaysAgo = now()->subDays(30);
        $sixtyDaysAgo = now()->subDays(60);

        // --- CHART DATA (Last 30 Days) ---
        $days = collect(range(29, 0))->map(fn($i) => now()->subDays($i)->format('Y-m-d'));

        $visits = SiteLog::where('log_type', 'visit')
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as aggregate'))
            ->groupBy('date')
            ->pluck('aggregate', 'date');

        $waClicks = SiteLog::where('log_type', 'wa_click')
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as aggregate'))
            ->groupBy('date')
            ->pluck('aggregate', 'date');

        $bookings = TestDriveBooking::where('created_at', '>=', $thirtyDaysAgo)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as aggregate'))
            ->groupBy('date')
            ->pluck('aggregate', 'date');

        $labels = $days->map(fn($date) => Carbon::parse($date)->format('d M'))->toArray();
        $visitData = $days->map(fn($date) => $visits[$date] ?? 0)->toArray();
        $waData = $days->map(fn($date) => $waClicks[$date] ?? 0)->toArray();
        $bookingData = $days->map(fn($date) => $bookings[$date] ?? 0)->toArray();

        // --- STATS (Last 30 Days) ---
        $currentVisits = SiteLog::where('log_type', 'visit')->where('created_at', '>=', $thirtyDaysAgo)->count();
        $currentWa = SiteLog::where('log_type', 'wa_click')->where('created_at', '>=', $thirtyDaysAgo)->count();
        $currentBookings = TestDriveBooking::where('created_at', '>=', $thirtyDaysAgo)->count();
        $currentConv = $currentVisits > 0 ? ($currentBookings / $currentVisits) * 100 : 0;
        $currentBounce = $currentVisits > 0 ? (($currentVisits - $currentWa) / $currentVisits) * 100 : 0;

        // --- DURATION (Time Spent on Page) ---
        $avgDurationSecs = SiteLog::where('log_type', 'visit')
            ->where('duration_seconds', '>', 0)
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->avg('duration_seconds');
        
        $avgSecs = (int) ($avgDurationSecs ?: 165);
        $mins = floor($avgSecs / 60);
        $remSecs = $avgSecs % 60;
        $avgDurationFormatted = "{$mins}m {$remSecs}s";

        // --- STATS (Previous 30 Days) ---
        $prevVisits = SiteLog::where('log_type', 'visit')->whereBetween('created_at', [$sixtyDaysAgo, $thirtyDaysAgo])->count();
        $prevWa = SiteLog::where('log_type', 'wa_click')->whereBetween('created_at', [$sixtyDaysAgo, $thirtyDaysAgo])->count();
        $prevBookings = TestDriveBooking::whereBetween('created_at', [$sixtyDaysAgo, $thirtyDaysAgo])->count();
        $prevConv = $prevVisits > 0 ? ($prevBookings / $prevVisits) * 100 : 0;
        $prevBounce = $prevVisits > 0 ? (($prevVisits - $prevWa) / $prevVisits) * 100 : 0;

        // --- PEAK HOURS CALCULATION ---
        $isSqlite = DB::connection()->getDriverName() === 'sqlite';
        $hourExpr = $isSqlite ? "strftime('%H', created_at)" : "HOUR(created_at)";

        $hourlyDistribution = SiteLog::where('log_type', 'visit')
            ->select(DB::raw("{$hourExpr} as hour_of_day"), DB::raw('count(*) as count'))
            ->groupBy('hour_of_day')
            ->orderBy('count', 'desc')
            ->first();

        $peakHourString = '14:00 - 17:00 WIB';
        if ($hourlyDistribution) {
            $h = (int) $hourlyDistribution->hour_of_day;
            $peakHourString = sprintf('%02d:00 - %02d:00 WIB', $h, ($h + 3) % 24);
        }

        // --- TOP SOURCES ---
        $sourcesQuery = SiteLog::where('log_type', 'visit')
            ->select('source', DB::raw('count(*) as total'))
            ->groupBy('source')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
            
        $totalAllTimeVisits = $sourcesQuery->sum('total');
        $sources = $sourcesQuery->map(function($item) use ($totalAllTimeVisits) {
            $item->percentage = $totalAllTimeVisits > 0 ? ($item->total / $totalAllTimeVisits) * 100 : 0;
            return $item;
        });

        // --- DETAILED DEVICE BRANDS & MODELS ---
        $deviceBrandsQuery = SiteLog::where('log_type', 'visit')
            ->whereNotNull('device_brand')
            ->select('device_brand', DB::raw('count(*) as total'))
            ->groupBy('device_brand')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        if ($deviceBrandsQuery->isEmpty()) {
            // Fallback parsing from user_agent for existing logs
            $parsedBrands = [];
            $allLogs = SiteLog::where('log_type', 'visit')->select('user_agent')->get();
            foreach ($allLogs as $log) {
                $p = SiteLog::parseUserAgent($log->user_agent);
                $bName = $p['brand'];
                $parsedBrands[$bName] = ($parsedBrands[$bName] ?? 0) + 1;
            }
            arsort($parsedBrands);
            $deviceBrands = collect();
            $totalB = array_sum($parsedBrands);
            foreach (array_slice($parsedBrands, 0, 5) as $bKey => $bCount) {
                $deviceBrands->push((object)[
                    'device_brand' => $bKey,
                    'total' => $bCount,
                    'percentage' => $totalB > 0 ? ($bCount / $totalB) * 100 : 0,
                ]);
            }
        } else {
            $totalB = $deviceBrandsQuery->sum('total');
            $deviceBrands = $deviceBrandsQuery->map(function($item) use ($totalB) {
                $item->percentage = $totalB > 0 ? ($item->total / $totalB) * 100 : 0;
                return $item;
            });
        }

        // --- TOP CITIES (Kota Asal Pengunjung) ---
        $citiesQuery = SiteLog::where('log_type', 'visit')
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->where('city', '!=', 'Tidak Diketahui')
            ->select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        if ($citiesQuery->isEmpty()) {
            // Fallback to region query or default Surabaya for historical logs
            $locationsQuery = SiteLog::where('log_type', 'visit')
                ->select('region', DB::raw('count(*) as total'))
                ->groupBy('region')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get();
            $totalL = $locationsQuery->sum('total');
            $cities = $locationsQuery->map(function($item) use ($totalL) {
                $cityName = $item->region;
                if ($cityName === 'Localhost' || empty($cityName)) $cityName = 'Surabaya';
                $item->city = $cityName;
                $item->percentage = $totalL > 0 ? ($item->total / $totalL) * 100 : 0;
                return $item;
            });
        } else {
            $totalC = $citiesQuery->sum('total');
            $cities = $citiesQuery->map(function($item) use ($totalC) {
                $item->percentage = $totalC > 0 ? ($item->total / $totalC) * 100 : 0;
                return $item;
            });
        }

        return [
            'chartData' => json_encode([
                'labels' => $labels,
                'visits' => $visitData,
                'waClicks' => $waData,
                'bookings' => $bookingData
            ]),
            'stats' => [
                'visits' => [
                    'value' => number_format($currentVisits, 0, ',', '.'),
                    'trend' => $this->calculateTrend($currentVisits, $prevVisits)
                ],
                'duration' => [
                    'value' => $avgDurationFormatted,
                    'trend' => ['dir' => 'up', 'pct' => 'Aktif', 'color' => 'text-emerald-500']
                ],
                'wa' => [
                    'value' => number_format($currentWa, 0, ',', '.'),
                    'trend' => $this->calculateTrend($currentWa, $prevWa)
                ],
                'bookings' => [
                    'value' => number_format($currentBookings, 0, ',', '.'),
                    'trend' => $this->calculateTrend($currentBookings, $prevBookings)
                ],
                'conversion' => [
                    'value' => round($currentConv, 1) . '%',
                    'trend' => $this->calculateTrend($currentConv, $prevConv)
                ],
            ],
            'peakHour' => $peakHourString,
            'sources' => $sources,
            'deviceBrands' => $deviceBrands,
            'cities' => $cities,
        ];
    }

    public function populateDummyData(): void
    {
        if (auth()->user()?->role !== 'developer') {
            return;
        }

        // Clean out any previous dummy logs first to prevent overflow
        SiteLog::where('ip_address', '127.0.0.1')->delete();
        TestDriveBooking::where('email', 'like', '%@example.com')->delete();

        $cars = \App\Models\Car::all();
        if ($cars->count() > 0) {
            $sources = ['google', 'instagram', 'facebook', 'direct', 'tiktok'];
            $cities = [
                ['city' => 'Surabaya', 'region' => 'Jawa Timur', 'weight' => 50],
                ['city' => 'Sidoarjo', 'region' => 'Jawa Timur', 'weight' => 20],
                ['city' => 'Gresik', 'region' => 'Jawa Timur', 'weight' => 15],
                ['city' => 'Malang', 'region' => 'Jawa Timur', 'weight' => 10],
                ['city' => 'Jakarta Barat', 'region' => 'DKI Jakarta', 'weight' => 5],
            ];
            
            $devices = [
                ['brand' => 'Apple iPhone', 'os' => 'iOS', 'browser' => 'Apple Safari', 'ua' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.4 Mobile/15E148 Safari/604.1'],
                ['brand' => 'Samsung Galaxy', 'os' => 'Android', 'browser' => 'Chrome Mobile', 'ua' => 'Mozilla/5.0 (Linux; Android 14; SM-S928B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Mobile Safari/537.36'],
                ['brand' => 'Xiaomi', 'os' => 'Android', 'browser' => 'Chrome Mobile', 'ua' => 'Mozilla/5.0 (Linux; Android 13; 23049PCD8G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36'],
                ['brand' => 'Windows PC', 'os' => 'Windows PC', 'browser' => 'Google Chrome', 'ua' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36'],
                ['brand' => 'Apple Mac', 'os' => 'macOS', 'browser' => 'Apple Safari', 'ua' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.2 Safari/605.1.15'],
            ];

            // Weighted city picker
            $pickCity = function() use ($cities) {
                $rand = rand(1, 100);
                $cumulative = 0;
                foreach ($cities as $c) {
                    $cumulative += $c['weight'];
                    if ($rand <= $cumulative) return $c;
                }
                return $cities[0];
            };

            for ($i = 0; $i < 200; $i++) {
                $cityObj = $pickCity();
                $dev = $devices[array_rand($devices)];
                $dur = rand(25, 420); // 25 seconds to 7 minutes

                // Peak hours around 13:00 - 16:00 and 19:00 - 21:00
                $hour = (rand(1, 10) > 4) ? rand(13, 20) : rand(7, 23);

                SiteLog::create([
                    'log_type' => 'visit',
                    'source' => $sources[array_rand($sources)],
                    'region' => $cityObj['region'],
                    'city' => $cityObj['city'],
                    'device_brand' => $dev['brand'],
                    'os_platform' => $dev['os'],
                    'browser_name' => $dev['browser'],
                    'duration_seconds' => $dur,
                    'car_id' => $cars->random()->id,
                    'user_agent' => $dev['ua'],
                    'ip_address' => '127.0.0.1',
                    'created_at' => now()->subDays(rand(0, 30))->setHour($hour)->subMinutes(rand(0, 59)),
                ]);
            }

            for ($i = 0; $i < 60; $i++) {
                $cityObj = $pickCity();
                $dev = $devices[array_rand($devices)];

                SiteLog::create([
                    'log_type' => 'wa_click',
                    'source' => $sources[array_rand($sources)],
                    'region' => $cityObj['region'],
                    'city' => $cityObj['city'],
                    'device_brand' => $dev['brand'],
                    'os_platform' => $dev['os'],
                    'browser_name' => $dev['browser'],
                    'car_id' => $cars->random()->id,
                    'ip_address' => '127.0.0.1',
                    'created_at' => now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59)),
                ]);
            }

            for ($i = 0; $i < 25; $i++) {
                TestDriveBooking::create([
                    'name' => 'Calon Pembeli ' . ($i + 1),
                    'phone' => '0812345678' . $i,
                    'email' => 'prospek' . $i . '@example.com',
                    'car_id' => $cars->random()->id,
                    'booking_date' => now()->addDays(rand(1, 10)),
                    'status' => (rand(0, 1) == 1) ? 'pending' : 'confirmed',
                    'created_at' => now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59)),
                ]);
            }
        }

        \Filament\Notifications\Notification::make()
            ->title('Demo Data Populated: Kota, Jam Ramai, Device & Durasi Aktif!')
            ->success()
            ->send();
    }

    public function resetToRealData(): void
    {
        if (auth()->user()?->role !== 'developer') {
            return;
        }

        SiteLog::where('ip_address', '127.0.0.1')->delete();
        TestDriveBooking::where('email', 'like', '%@example.com')->delete();

        \Filament\Notifications\Notification::make()
            ->title('Data Demo Direset ke Data Real!')
            ->warning()
            ->send();
    }

    private function calculateTrend($current, $prev, $inverse = false): array
    {
        if ($prev == 0) return ['dir' => 'up', 'pct' => '100%', 'color' => 'text-emerald-500'];
        
        $diff = (($current - $prev) / $prev) * 100;
        $dir = $diff >= 0 ? 'up' : 'down';
        
        $isGood = $inverse ? $diff <= 0 : $diff >= 0;
        $color = $isGood ? 'text-emerald-500' : 'text-rose-500';

        return [
            'dir' => $dir,
            'pct' => round(abs($diff), 1) . '%',
            'color' => $color,
        ];
    }
}
