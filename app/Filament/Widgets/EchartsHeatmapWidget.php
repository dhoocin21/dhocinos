<?php

namespace App\Filament\Widgets;

use App\Models\SiteLog;
use App\Models\Setting;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EchartsHeatmapWidget extends Widget
{
    protected static string $view = 'filament.widgets.echarts-heatmap';
    protected static ?int $sort = 5;
    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return Setting::isPro();
    }

    protected function getViewData(): array
    {
        $driverName = DB::connection()->getDriverName();

        if ($driverName === 'mysql') {
            $dayOfWeekSql = "DAYOFWEEK(DATE_ADD(created_at, INTERVAL 7 HOUR)) - 1";
            $hourOfDaySql = "HOUR(DATE_ADD(created_at, INTERVAL 7 HOUR))";
        } else {
            $dayOfWeekSql = "CAST(strftime('%w', datetime(created_at, '+7 hours')) AS INTEGER)";
            $hourOfDaySql = "CAST(strftime('%H', datetime(created_at, '+7 hours')) AS INTEGER)";
        }

        $logs = SiteLog::select(
                DB::raw("$dayOfWeekSql as day_of_week"),
                DB::raw("$hourOfDaySql as hour_of_day"),
                DB::raw('count(*) as total')
            )
            ->groupBy('day_of_week', 'hour_of_day')
            ->get();

        $data = [];
        // Initialize 7 days * 24 hours with 0
        for ($d = 0; $d < 7; $d++) {
            for ($h = 0; $h < 24; $h++) {
                $data[$d][$h] = 0;
            }
        }

        foreach ($logs as $log) {
            if ($log->day_of_week !== null && $log->hour_of_day !== null) {
                $data[$log->day_of_week][$log->hour_of_day] = $log->total;
            }
        }

        // ECharts Heatmap format: [X(Hour), Y(Day), Value]
        // Days: 0=Sun ... 6=Sat
        $heatmapData = [];
        for ($d = 0; $d < 7; $d++) {
            for ($h = 0; $h < 24; $h++) {
                $heatmapData[] = [$h, $d, $data[$d][$h]];
            }
        }

        $maxValue = empty($heatmapData) ? 10 : max(array_column($heatmapData, 2));
        if ($maxValue == 0) $maxValue = 10; // Fallback

        // 1. Data Kunjungan Hari Ini Berdasarkan Platform (Windows, Android, iPhone)
        $todayDate = Carbon::today()->toDateString();
        $todayLogs = SiteLog::with('car')
            ->whereDate('created_at', $todayDate)
            ->orderBy('created_at', 'asc')
            ->get();

        // Jika hari ini belum banyak data, ambil 24 jam terakhir agar dashboard tetap informatif
        if ($todayLogs->count() < 3) {
            $todayLogs = SiteLog::with('car')
                ->where('created_at', '>=', Carbon::now()->subHours(24))
                ->orderBy('created_at', 'asc')
                ->get();
        }

        $platformHighlights = $this->buildPlatformHighlights($todayLogs);

        // 2. Stamp Detail Kunjungan (Terkini: Jam, IP, Lokasi, Perangkat, Mobil, Durasi)
        $recentStamps = SiteLog::with('car')
            ->orderBy('created_at', 'desc')
            ->take(15)
            ->get()
            ->map(function ($log) {
                $created = Carbon::parse($log->created_at);
                $isToday = $created->isToday();
                
                $duration = $log->duration_seconds ?? 0;
                if ($duration >= 60) {
                    $durationText = floor($duration / 60) . 'm ' . ($duration % 60) . 's';
                } else {
                    $durationText = max(5, $duration) . 's';
                }

                $os = $log->os_platform ?: 'Unknown';
                $brand = $log->device_brand ?: 'Device';
                $browser = $log->browser_name ?: 'Browser';

                // Tentukan kategori perangkat untuk badge & icon
                $platformType = 'other';
                if (stripos($os, 'win') !== false || stripos($brand, 'win') !== false) {
                    $platformType = 'windows';
                } elseif (stripos($os, 'android') !== false || stripos($brand, 'samsung') !== false || stripos($brand, 'xiaomi') !== false) {
                    $platformType = 'android';
                } elseif (stripos($os, 'ios') !== false || stripos($brand, 'iphone') !== false || stripos($brand, 'apple') !== false) {
                    $platformType = 'iphone';
                }

                return [
                    'id' => $log->id,
                    'time' => $created->format('H:i') . ' WIB',
                    'date_label' => $isToday ? 'Hari Ini' : $created->translatedFormat('d M Y'),
                    'is_today' => $isToday,
                    'ip_address' => $log->ip_address ?: '127.0.0.1',
                    'city' => $log->city ?: 'Surabaya',
                    'region' => $log->region ?: 'Jawa Timur',
                    'platform_type' => $platformType,
                    'os_platform' => $os,
                    'device_brand' => $brand,
                    'browser_name' => $browser,
                    'car_name' => $log->car ? $log->car->name : 'Beranda Utama',
                    'car_category' => $log->car ? $log->car->category : null,
                    'source' => ucfirst($log->source ?: 'Direct'),
                    'duration_text' => $durationText,
                ];
            });

        return [
            'chartData' => json_encode($heatmapData),
            'maxValue' => $maxValue,
            'platformHighlights' => $platformHighlights,
            'recentStamps' => $recentStamps,
            'totalTodayVisits' => $todayLogs->count(),
        ];
    }

    /**
     * Susun ringkasan platform:
     * - Windows: hari ini kunjungan ada di jam 9.00, jam 14.00 dst
     * - Android: hari ini kunjungan dari jakarta jam 8.00, jam 17.00 dst
     * - iPhone: hari ini kunjungan dari bandung jam 7.00, jam 15.00 dst
     */
    protected function buildPlatformHighlights($logs): array
    {
        $groups = [
            'windows' => [
                'key' => 'windows',
                'name' => 'Windows',
                'badge' => 'Desktop / PC',
                'theme' => 'blue',
                'items' => [],
            ],
            'android' => [
                'key' => 'android',
                'name' => 'Android',
                'badge' => 'Mobile / Smartphone',
                'theme' => 'emerald',
                'items' => [],
            ],
            'iphone' => [
                'key' => 'iphone',
                'name' => 'iPhone',
                'badge' => 'Apple iOS',
                'theme' => 'purple',
                'items' => [],
            ],
        ];

        foreach ($logs as $log) {
            $os = strtolower($log->os_platform ?? '');
            $brand = strtolower($log->device_brand ?? '');
            $time = Carbon::parse($log->created_at)->format('H.i');
            $city = $log->city ?: 'Surabaya';
            $region = $log->region ?: 'Jawa Timur';

            $targetKey = null;
            if (str_contains($os, 'win') || str_contains($brand, 'win')) {
                $targetKey = 'windows';
            } elseif (str_contains($os, 'android') || str_contains($brand, 'samsung') || str_contains($brand, 'xiaomi') || str_contains($brand, 'oppo') || str_contains($brand, 'vivo')) {
                $targetKey = 'android';
            } elseif (str_contains($os, 'ios') || str_contains($brand, 'iphone') || str_contains($brand, 'apple')) {
                $targetKey = 'iphone';
            }

            if ($targetKey) {
                $groups[$targetKey]['items'][] = [
                    'time' => $time,
                    'city' => $city,
                    'region' => $region,
                    'ip' => $log->ip_address,
                    'car' => $log->car ? $log->car->name : null,
                ];
            }
        }

        // Bangun kalimat ringkasan yang ramah dan alami sesuai format permintaan user
        $result = [];
        foreach ($groups as $key => $data) {
            $items = $data['items'];
            $count = count($items);
            $sentence = '';

            if ($count === 0) {
                $sentence = 'Belum ada kunjungan terdeteksi hari ini.';
            } else {
                // Kelompokkan waktu berdasarkan kota
                $cityTimes = [];
                $allTimes = [];
                foreach ($items as $item) {
                    $cityTimes[$item['city']][] = 'jam ' . $item['time'];
                    $allTimes[] = 'jam ' . $item['time'];
                }

                // Susun kalimat variatif & alami
                if ($key === 'windows') {
                    // Contoh: "Hari ini kunjungan ada di jam 09.00, jam 14.00, jam 18.24"
                    $citiesList = implode(', ', array_keys($cityTimes));
                    $sentence = 'Hari ini kunjungan ada di ' . implode(', ', array_slice($allTimes, 0, 4));
                    if (count($allTimes) > 4) {
                        $sentence .= ' dan seterusnya';
                    }
                    if ($citiesList) {
                        $sentence .= ' (' . $citiesList . ')';
                    }
                } elseif ($key === 'android') {
                    // Contoh: "Hari ini kunjungan dari Jakarta jam 08.00, jam 17.00, Surabaya jam 10.35"
                    $parts = [];
                    foreach ($cityTimes as $cityName => $times) {
                        $parts[] = 'dari ' . $cityName . ' ' . implode(', ', array_slice($times, 0, 3));
                    }
                    $sentence = 'Hari ini kunjungan ' . implode(', ', array_slice($parts, 0, 3));
                    if (count($items) > 5) {
                        $sentence .= ' dan seterusnya';
                    }
                } elseif ($key === 'iphone') {
                    // Contoh: "Hari ini kunjungan dari Bandung jam 07.00, jam 15.00, Surabaya jam 16.08"
                    $parts = [];
                    foreach ($cityTimes as $cityName => $times) {
                        $parts[] = 'dari ' . $cityName . ' ' . implode(', ', array_slice($times, 0, 3));
                    }
                    $sentence = 'Hari ini kunjungan ' . implode(', ', array_slice($parts, 0, 3));
                    if (count($items) > 5) {
                        $sentence .= ' dan seterusnya';
                    }
                }
            }

            $result[$key] = [
                'name' => $data['name'],
                'badge' => $data['badge'],
                'theme' => $data['theme'],
                'count' => $count,
                'sentence' => $sentence,
                'items' => array_slice($items, 0, 6),
            ];
        }

        return $result;
    }
}
