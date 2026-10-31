<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramNotificationService
{
    /**
     * Send lead alert to configured Telegram Bot
     *
     * @param string $eventTitle (e.g., 'Booking Test Drive', 'Trade-In Request', 'Lead Promo Form')
     * @param array $details Key-value pairs of customer details
     * @return bool
     */
    public static function sendAlert(string $eventTitle, array $details): bool
    {
        try {
            $enabled = Setting::get('telegram_notifications_enabled', false);
            $botToken = Setting::get('telegram_bot_token');
            $chatId = Setting::get('telegram_chat_id');

            if (!$enabled || empty($botToken) || empty($chatId)) {
                return false;
            }

            $siteName = Setting::get('site_name', 'Hyundai AutoShow');
            $timestamp = now()->timezone('Asia/Jakarta')->format('d M Y - H:i') . ' WIB';

            $message = "🚨 <b>NEW LEAD ALERT - {$siteName}</b>\n";
            $message .= "━━━━━━━━━━━━━━━━━━━━\n";
            $message .= "📌 <b>Kategori:</b> {$eventTitle}\n";
            $message .= "⏰ <b>Waktu:</b> {$timestamp}\n\n";

            foreach ($details as $label => $val) {
                if (!empty($val)) {
                    $escapedVal = htmlspecialchars((string) $val, ENT_QUOTES, 'UTF-8');
                    $message .= "▫️ <b>{$label}:</b> {$escapedVal}\n";
                }
            }

            $message .= "\n━━━━━━━━━━━━━━━━━━━━\n";
            $message .= "⚡ <i>Segera follow-up calon pembeli dalam < 5 menit untuk konversi maksimal!</i>";

            $response = Http::timeout(5)->post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
                'disable_web_page_preview' => true,
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::warning("Telegram Notification Failed: " . $e->getMessage());
            return false;
        }
    }
}
