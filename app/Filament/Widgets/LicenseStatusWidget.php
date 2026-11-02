<?php

namespace App\Filament\Widgets;

use App\Models\Setting;
use Filament\Widgets\Widget;
use Illuminate\Support\Carbon;

class LicenseStatusWidget extends Widget
{
    protected static string $view = 'filament.widgets.license-status-widget';
    
    protected static ?array $extraAttributes = [
        'class' => 'license-status-card',
    ];
    
    protected static ?int $sort = -1; // Show at the very top, before stats

    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return true;
    }

    public function getLicenseInfo(): array
    {
        $user = auth()->user();
        if ($user && $user->role === 'developer') {
            return [
                'plan' => 'developer',
                'is_developer' => true,
                'is_pro' => true,
                'expired_at' => 'LIFETIME ACCESS',
                'is_expired' => false,
                'is_near_expiry' => false,
                'days_left' => null,
                'status_label' => 'ACTIVE',
                'status_color' => 'success',
            ];
        }

        $data = Setting::getLicenseData();
        $expiry = Carbon::parse($data['expired_at'] ?? now());
        $now = now();
        
        $realPlan = $data['plan'] ?? 'regular';
        $isExpired = $expiry->isPast();
        $daysLeft = (int) $now->diffInDays($expiry, false);
        $isNearExpiry = !$isExpired && $daysLeft <= 7;

        return [
            'plan' => $realPlan,
            'is_developer' => false,
            'is_pro' => $realPlan === 'pro',
            'expired_at' => $expiry->format('d M Y'),
            'is_expired' => $isExpired,
            'is_near_expiry' => $isNearExpiry,
            'days_left' => $daysLeft,
            'status_label' => $isExpired ? 'EXPIRED' : ($isNearExpiry ? 'NEAR EXPIRY' : 'ACTIVE'),
            'status_color' => $isExpired ? 'danger' : ($isNearExpiry ? 'warning' : 'success'),
        ];
    }
}
