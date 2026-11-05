<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Otomatis sinkronisasi berita resmi Hyundai setiap jam
Schedule::command('hyundai:sync-news')->hourly()->withoutOverlapping();

// Auto-Pilot SEO Engine: Sinkronisasi dan terbitkan artikel SEO lokal Surabaya secara berkala setiap jam 07:00 WIB
Schedule::command('hyundai:auto-pilot')->dailyAt('07:00')->withoutOverlapping();


