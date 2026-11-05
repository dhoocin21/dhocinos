<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Dark Mode Theme Initialization (FOUC Prevention) -->
    <script>
        try {
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        } catch (e) {
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.classList.add('dark');
            }
        }
    </script>

    <!-- Critical Anti-FOUC & Asset Priority -->
    <style>
        [x-cloak] { display: none !important; }
        header img, nav img { max-height: 35px !important; width: auto !important; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Favicon -->
    @if($logo = \App\Models\Setting::get('site_logo'))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $logo) }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('assets/images/hyundai_logo.png') }}">
    @endif

    @php
        $pageTitle = "Test Drive Mobil Hyundai Surabaya - Booking Gratis ke Rumah & Kantor | Dealer Resmi HR Muhammad";
        $pageDesc = "Layanan booking jadwal test drive resmi mobil Hyundai terbaru di Surabaya. 100% Gratis tanpa biaya, unit bersih siap diantar langsung ke rumah atau kantor Anda. Cukup KTP + SIM A aktif. Hubungi Sales Nico Hyundai Surabaya.";
        $pageKeywords = "test drive hyundai surabaya, booking test drive hyundai, test drive stargazer surabaya, test drive creta surabaya, test drive palisade surabaya, test drive ioniq 5 surabaya, dealer resmi hyundai hr muhammad";
        $currentUrl = url('/test-drive');
        $shareImage = \App\Models\Setting::get('site_logo') ? asset('storage/' . \App\Models\Setting::get('site_logo')) : asset('assets/images/hyundai_logo.png');

        $dealerAddress = \App\Models\Setting::get('dealer_address', 'Jl. Mayjen HR. Muhammad No.35C, Sonokwijenan, Kec. Sukomanunggal, Surabaya, Jawa Timur 60189');
        $geoCoordinates = \App\Models\Setting::get('geo_coordinates', '-7.2847, 112.7001');
        $coords = array_map('trim', explode(',', $geoCoordinates));
        $latitude = isset($coords[0]) ? (float)$coords[0] : -7.2847;
        $longitude = isset($coords[1]) ? (float)$coords[1] : 112.7001;
    @endphp

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDesc }}">
    <meta name="keywords" content="{{ $pageKeywords }}">
    <link rel="canonical" href="{{ $currentUrl }}">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

    <!-- Local SEO Geo Meta Tags (Surabaya, Jawa Timur) -->
    <meta name="geo.region" content="ID-JI">
    <meta name="geo.placename" content="Surabaya">
    <meta name="geo.position" content="{{ $latitude }};{{ $longitude }}">
    <meta name="ICBM" content="{{ $latitude }}, {{ $longitude }}">

    <!-- Open Graph / Facebook / WhatsApp Preview -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $currentUrl }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDesc }}">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="Hyundai Gowa Surabaya HR Muhammad">
    <meta property="og:image" content="{{ $shareImage }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDesc }}">
    <meta name="twitter:image" content="{{ $shareImage }}">

    <!-- Structured Data (JSON-LD): BreadcrumbList, AutoDealer, Service & FAQPage -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@@type": "ListItem",
          "position": 1,
          "name": "Beranda",
          "item": "{{ url('/') }}"
        },
        {
          "@@type": "ListItem",
          "position": 2,
          "name": "Test Drive Hyundai Surabaya",
          "item": "{{ $currentUrl }}"
        }
      ]
    }
    </script>
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "AutoDealer",
      "name": "Hyundai Gowa HR Muhammad Surabaya - Layanan Test Drive",
      "url": "{{ $currentUrl }}",
      "telephone": "+6281330135013",
      "address": {
        "@@type": "PostalAddress",
        "streetAddress": "{{ $dealerAddress }}",
        "addressLocality": "Surabaya",
        "addressRegion": "Jawa Timur",
        "postalCode": "60189",
        "addressCountry": "ID"
      },
      "geo": {
        "@@type": "GeoCoordinates",
        "latitude": {{ $latitude }},
        "longitude": {{ $longitude }}
      }
    }
    </script>
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "FAQPage",
      "mainEntity": [
        {
          "@@type": "Question",
          "name": "Apakah layanan test drive mobil Hyundai di Surabaya ini dipungut biaya?",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "Sama sekali GRATIS 100%! Tidak ada biaya apapun untuk melakukan test drive mobil Hyundai bersama kami."
          }
        },
        {
          "@@type": "Question",
          "name": "Apakah mobil test drive bisa diantar ke rumah atau kantor saya?",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "Bisa sekali! Sales Consultant kami siap mengantarkan unit test drive pilihan Anda langsung ke rumah, kantor, atau lokasi janji temu di area Surabaya, Sidoarjo, dan Gresik."
          }
        },
        {
          "@@type": "Question",
          "name": "Apa saja syarat untuk booking jadwal test drive Hyundai?",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "Syaratnya sangat mudah, Anda cukup menyiapkan foto/fisik KTP dan SIM A yang masih berlaku saat jadwal pelaksanaan test drive."
          }
        },
        {
          "@@type": "Question",
          "name": "Unit mobil Hyundai apa saja yang tersedia untuk test drive?",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "Kami menyediakan unit test drive lengkap mulai dari Hyundai Stargazer Cartenz, Stargazer Cartenz X, Creta, Creta N Line, All-New Santa Fe HEV, Palisade Hybrid, hingga mobil listrik IONIQ 5 dan KONA Electric."
          }
        }
      ]
    }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @livewireStyles
    <style>
        body { font-family: 'Outfit', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-slate-50 dark:bg-[#070d19] text-gray-900 dark:text-gray-100 antialiased selection:bg-cyan-500 selection:text-white transition-colors duration-300">

    <x-navbar />

    <main class="pt-24 lg:pt-28 pb-20">
        <!-- Breadcrumb Header -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
            <nav class="flex text-xs text-gray-500 dark:text-gray-400 space-x-2">
                <a href="{{ url('/') }}" class="hover:text-blue-600 dark:hover:text-cyan-400 transition-colors">Beranda</a>
                <span>/</span>
                <span class="text-gray-900 dark:text-white font-semibold">Test Drive</span>
            </nav>
        </div>

        <!-- Hero Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#002c5f] via-[#001f44] to-[#041124] text-white p-8 md:p-14 shadow-2xl border border-blue-900/40">
                <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-cyan-500/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative z-10 max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-cyan-500/10 border border-cyan-400/30 text-cyan-300 text-xs font-bold uppercase tracking-wider mb-4">
                        <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                        Layanan Resmi Dealer Hyundai Surabaya
                    </div>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight leading-tight mb-4">
                        Test Drive Mobil Hyundai <span class="bg-gradient-to-r from-cyan-400 to-blue-300 bg-clip-text text-transparent">Gratis ke Rumah Anda</span>
                    </h1>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-6">
                        Rasakan kemewahan, akselerasi responsif, dan kenyamanan fitur canggih Hyundai SmartSense secara langsung. Kami siap mengantarkan unit test drive pilihan Anda ke rumah atau kantor tanpa dipungut biaya sepeser pun.
                    </p>

                    <div class="flex flex-wrap gap-4 text-xs sm:text-sm font-semibold">
                        <div class="flex items-center gap-2 text-cyan-200">
                            <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>100% Gratis Tanpa Biaya</span>
                        </div>
                        <div class="flex items-center gap-2 text-cyan-200">
                            <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>Bisa Diantar ke Rumah / Kantor</span>
                        </div>
                        <div class="flex items-center gap-2 text-cyan-200">
                            <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>Syarat Cukup KTP + SIM A</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content: Form & Unit Selector -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left: Booking Form -->
                <div class="lg:col-span-7">
                    {{-- Livewire Form Component --}}
                    @livewire('test-drive-form')
                </div>

                <!-- Right: Pilihan Unit & Keunggulan -->
                <div class="lg:col-span-5 space-y-6">
                    <!-- Pilihan Unit Siap Test Drive -->
                    <div class="bg-slate-50/80 dark:bg-[#0c1527] rounded-3xl p-6 sm:p-7 shadow-xl border border-gray-200/80 dark:border-slate-800">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-black text-gray-900 dark:text-white flex items-center gap-2">
                                <span class="p-1.5 rounded-xl bg-blue-100 dark:bg-cyan-950/80 text-[#002c5f] dark:text-cyan-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                </span>
                                Unit Populer Siap Test Drive
                            </h3>
                            <a href="{{ route('pricelist') }}" class="text-[11px] font-bold text-blue-600 dark:text-cyan-400 hover:underline">
                                Lihat Pricelist &rarr;
                            </a>
                        </div>

                        <div class="space-y-3">
                            @foreach($testDriveCars as $car)
                                <div class="flex items-center justify-between p-3.5 rounded-2xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 hover:border-blue-400 dark:hover:border-cyan-400 shadow-sm transition">
                                    <div class="flex items-center gap-3 min-w-0">
                                        @if($car->image_url)
                                            <img src="{{ asset('storage/' . $car->image_url) }}" alt="{{ $car->name }}" class="w-14 h-9 object-contain shrink-0">
                                        @else
                                            <div class="w-14 h-9 bg-slate-200 dark:bg-slate-700 rounded-lg flex items-center justify-center text-[10px] font-bold text-slate-500 dark:text-slate-400 shrink-0">Hyundai</div>
                                        @endif
                                        <div class="min-w-0">
                                            <h4 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white truncate">{{ $car->name }}</h4>
                                            <span class="text-[11px] font-semibold text-slate-600 dark:text-slate-300 block">
                                                {{ $car->category }} • <strong class="text-[#002c5f] dark:text-cyan-400 font-bold">OTR Rp {{ number_format($car->price/1000000, 0, ',', '.') }} Jt</strong>
                                            </span>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 dark:bg-emerald-950/80 dark:text-emerald-300 border border-emerald-300/40 shrink-0">
                                        Ready
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Hubungi Sales Cepat -->
                    @if($consultant)
                        <div class="bg-gradient-to-br from-emerald-600 to-teal-700 text-white rounded-3xl p-6 shadow-xl relative overflow-hidden">
                            <div class="relative z-10">
                                <span class="text-xs uppercase font-bold tracking-wider text-emerald-200">Ingin Janji Temu Hari Ini?</span>
                                <h4 class="text-xl font-black mt-1 mb-2">Hubungi Sales Resmi Langsung</h4>
                                <p class="text-emerald-100 text-xs mb-4">Konsultasi cepat via WhatsApp bersama {{ $consultant->name }}. Kami siap melayani Anda 24/7.</p>
                                
                                <a href="{{ route('track.wa', ['text' => 'Halo Mas Nico, saya mau tanya jadwal dan booking test drive mobil Hyundai di Surabaya. Apakah unitnya bisa diantar ke rumah/kantor saya?']) }}" target="_blank" class="inline-flex items-center justify-center gap-2 w-full py-3 px-4 rounded-xl bg-white text-emerald-800 hover:bg-emerald-50 font-bold text-xs uppercase tracking-wider shadow-lg transition">
                                    <svg class="w-4 h-4 fill-current text-emerald-600" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.072.376-.044c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.1.824z"/></svg>
                                    <span>Chat WhatsApp Sekarang</span>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </section>

        <!-- 4 Keunggulan Layanan Test Drive Kami -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <h2 class="text-2xl sm:text-3xl font-black text-gray-900 dark:text-white">Kenapa Memilih Layanan Test Drive Kami?</h2>
                <p class="text-gray-500 dark:text-gray-400 text-xs sm:text-sm mt-2">Komitmen kami memberikan pengalaman terbaik untuk Anda dan keluarga dalam mencoba mobil impian.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-[#0c1527] p-6 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-cyan-400 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">100% Gratis & Bebas</h3>
                    <p class="text-xs text-gray-500 dark:text-slate-400 leading-relaxed">Tanpa biaya pendaftaran, tanpa pungutan bensin, dan bebas dari paksaan pembelian apapun.</p>
                </div>

                <div class="bg-white dark:bg-[#0c1527] p-6 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-cyan-50 dark:bg-cyan-900/40 text-cyan-600 dark:text-cyan-400 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">Diantar ke Lokasi Anda</h3>
                    <p class="text-xs text-gray-500 dark:text-slate-400 leading-relaxed">Sibuk di kantor atau di rumah? Kami antarkan unit test drive ke lokasi Anda di Surabaya, Sidoarjo & Gresik.</p>
                </div>

                <div class="bg-white dark:bg-[#0c1527] p-6 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">Jadwal Fleksibel</h3>
                    <p class="text-xs text-gray-500 dark:text-slate-400 leading-relaxed">Layanan test drive buka setiap hari (Senin s/d Minggu) mulai jam 08.00 pagi sampai jam 19.00 malam.</p>
                </div>

                <div class="bg-white dark:bg-[#0c1527] p-6 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">Sales Ramah & Berpengalaman</h3>
                    <p class="text-xs text-gray-500 dark:text-slate-400 leading-relaxed">Didampingi konsultan resmi yang siap memandu simulasi fitur keselamatan ADAS Hyundai SmartSense.</p>
                </div>
            </div>
        </section>

        <!-- FAQ Section Khusus Test Drive -->
        <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-black text-gray-900 dark:text-white">Pertanyaan Umum (FAQ) Test Drive</h2>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">Semua yang perlu Anda ketahui sebelum mencoba mobil Hyundai.</p>
            </div>

            <div class="space-y-4" x-data="{ active: null }">
                <div class="bg-white dark:bg-[#0c1527] rounded-2xl border border-gray-100 dark:border-slate-800 p-5 shadow-xs">
                    <button type="button" @click="active = active === 1 ? null : 1" class="flex justify-between items-center w-full text-left font-bold text-sm text-gray-900 dark:text-white">
                        <span>Apakah test drive mobil Hyundai ini benar-benar gratis?</span>
                        <svg class="w-5 h-5 transition-transform" :class="active === 1 ? 'rotate-180 text-blue-600' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="active === 1" x-cloak class="mt-3 text-xs text-gray-600 dark:text-slate-300 leading-relaxed border-t border-gray-100 dark:border-slate-800 pt-3">
                        Ya, 100% GRATIS tanpa biaya sepeser pun. Anda tidak diwajibkan membeli, tujuan test drive adalah agar Anda dapat merasakan sendiri kenyamanan dan teknologi mobil Hyundai sebelum mengambil keputusan.
                    </div>
                </div>

                <div class="bg-white dark:bg-[#0c1527] rounded-2xl border border-gray-100 dark:border-slate-800 p-5 shadow-xs">
                    <button type="button" @click="active = active === 2 ? null : 2" class="flex justify-between items-center w-full text-left font-bold text-sm text-gray-900 dark:text-white">
                        <span>Bagaimana jika saya ingin mencoba di hari libur / akhir pekan?</span>
                        <svg class="w-5 h-5 transition-transform" :class="active === 2 ? 'rotate-180 text-blue-600' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="active === 2" x-cloak class="mt-3 text-xs text-gray-600 dark:text-slate-300 leading-relaxed border-t border-gray-100 dark:border-slate-800 pt-3">
                        Layanan kami tetap buka pada hari Sabtu dan Minggu. Anda bebas memilih jam yang paling nyaman untuk Anda dan keluarga.
                    </div>
                </div>

                <div class="bg-white dark:bg-[#0c1527] rounded-2xl border border-gray-100 dark:border-slate-800 p-5 shadow-xs">
                    <button type="button" @click="active = active === 3 ? null : 3" class="flex justify-between items-center w-full text-left font-bold text-sm text-gray-900 dark:text-white">
                        <span>Apa saja dokumen yang harus disiapkan saat test drive?</span>
                        <svg class="w-5 h-5 transition-transform" :class="active === 3 ? 'rotate-180 text-blue-600' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="active === 3" x-cloak class="mt-3 text-xs text-gray-600 dark:text-slate-300 leading-relaxed border-t border-gray-100 dark:border-slate-800 pt-3">
                        Cukup siapkan KTP asli dan SIM A yang masih berlaku. Sales konsultan kami akan memverifikasi singkat sebelum kendaraan dikemudikan.
                    </div>
                </div>

                <div class="bg-white dark:bg-[#0c1527] rounded-2xl border border-gray-100 dark:border-slate-800 p-5 shadow-xs">
                    <button type="button" @click="active = active === 4 ? null : 4" class="flex justify-between items-center w-full text-left font-bold text-sm text-gray-900 dark:text-white">
                        <span>Apakah boleh mengajak keluarga ikut dalam mobil saat test drive?</span>
                        <svg class="w-5 h-5 transition-transform" :class="active === 4 ? 'rotate-180 text-blue-600' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="active === 4" x-cloak class="mt-3 text-xs text-gray-600 dark:text-slate-300 leading-relaxed border-t border-gray-100 dark:border-slate-800 pt-3">
                        Sangat dianjurkan! Ajak pasangan dan anak-anak Anda untuk merasakan kelegaan kabin, kekedapan suara, dan kenyamanan captain seat mobil Hyundai.
                    </div>
                </div>
            </div>
        </section>
    </main>

    {{-- Footer Sederhana --}}
    <footer class="bg-white dark:bg-[#040812] border-t border-gray-200 dark:border-slate-800 py-10 text-xs text-gray-500 dark:text-gray-400 text-center">
        <div class="max-w-7xl mx-auto px-4">
            <p class="font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-2">Dealer Resmi Hyundai Surabaya - HR Muhammad</p>
            <p class="mb-4">{{ $dealerAddress }}</p>
            <p>&copy; {{ date('Y') }} Hyundai Surabaya. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
