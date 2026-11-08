<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Dark Mode Theme & Anti-FOUC Initialization -->
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

        // Purge any lingering Service Workers or stale PWA caches immediately
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.getRegistrations().then(function(regs) {
                for (var r of regs) { r.unregister(); }
            });
        }
        if ('caches' in window) {
            caches.keys().then(function(keys) {
                keys.forEach(function(k) { caches.delete(k); });
            });
        }
    </script>
    
    <!-- Critical Anti-FOUC Inline Styling (Applied immediately before any external CSS loads) -->
    <style>
        [x-cloak] { display: none !important; }
        html { background-color: #070d19; color-scheme: dark; }
        body { background-color: #070d19; color: #f8fafc; font-family: 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin: 0; padding: 0; }
        .hidden { display: none !important; }
        @media (max-width: 767px) {
            .hidden.md\:flex, .hidden.md\:block, .hidden.md\:inline-flex { display: none !important; }
        }
        @media (min-width: 768px) {
            .md\:hidden { display: none !important; }
            .hidden.md\:flex { display: flex !important; }
        }
        img { max-width: 100%; height: auto; }
        nav { position: fixed; top: 0; left: 0; right: 0; z-index: 50; background: rgba(7, 13, 25, 0.95); min-height: 54px; display: flex; align-items: center; border-bottom: 1px solid rgba(30, 41, 59, 0.8); }
        nav a, nav button { color: inherit; text-decoration: none; border: none; background: transparent; }
        header img, nav img, footer img, .site-logo-img, .footer-logo-img { max-height: 32px !important; height: 32px !important; width: auto !important; max-width: 65px !important; object-fit: contain !important; }
        header svg, nav svg, footer svg, .verified-badge-svg { max-width: 18px !important; max-height: 18px !important; width: 18px !important; height: 18px !important; display: inline-block !important; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Favicon -->
    @if($logo = \App\Models\Setting::get('site_logo'))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $logo) }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('assets/images/hyundai_logo.png') }}">
    @endif

    @php
        $seoTitle = \App\Models\Setting::get('meta_title', 'Promo Hyundai Surabaya 2026 - Dealer Resmi Hyundai Gowa HR Muhammad');
        $seoDesc = \App\Models\Setting::get('meta_description', 'Promo diskon mobil baru Hyundai Surabaya, DP mulai 10%, bunga 0%, garansi baterai EV 8 tahun, dan tukar tambah mobil lama dengan harga terbaik. Hubungi Nico 0813-3013-5013.');
        $seoKeywords = \App\Models\Setting::get('meta_keywords', 'hyundai surabaya, promo hyundai gowa surabaya, kredit hyundai stargazer surabaya, harga creta surabaya, palisade surabaya, ioniq 5 surabaya, sales hyundai hr muhammad nico');
        $gtmId = \App\Models\Setting::get('google_tag_manager_id');
        $gAdsId = \App\Models\Setting::get('google_ads_id') ?: config('services.google.ads_id');
        $metaPixelId = \App\Models\Setting::get('meta_pixel_id');
        $siteVerification = \App\Models\Setting::get('google_site_verification');
    @endphp

    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDesc }}">
    <meta name="keywords" content="{{ $seoKeywords }}">
    <link rel="canonical" href="{{ url('/') }}">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

    <!-- PWA Web App Manifest & Mobile App Experience -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#002c5f">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Hyundai Pro">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/hyundai_logo.png') }}">

    @if($siteVerification)
        @php
            $cleanVerification = $siteVerification;
            if (preg_match('/content=[\'"]([^\'"]+)[\'"]/', $siteVerification, $m)) {
                $cleanVerification = $m[1];
            }
        @endphp
        <meta name="google-site-verification" content="{{ $cleanVerification }}">
    @endif

    @php
        $dealerAddress = \App\Models\Setting::get('dealer_address', 'Jl. Mayjen HR. Muhammad No.35C, Sonokwijenan, Kec. Sukomanunggal, Surabaya, Jawa Timur 60189');
        $geoCoordinates = \App\Models\Setting::get('geo_coordinates', '-7.2847, 112.7001');
        $coords = array_map('trim', explode(',', $geoCoordinates));
        $latitude = isset($coords[0]) ? (float)$coords[0] : -7.2847;
        $longitude = isset($coords[1]) ? (float)$coords[1] : 112.7001;
    @endphp

    <!-- Local SEO Geo Meta Tags (Surabaya, Jawa Timur) -->
    <meta name="geo.region" content="ID-JI">
    <meta name="geo.placename" content="Surabaya">
    <meta name="geo.position" content="{{ $latitude }};{{ $longitude }}">
    <meta name="ICBM" content="{{ $latitude }}, {{ $longitude }}">

    @php
        $shareImage = \App\Models\Setting::get('site_logo') 
            ? asset('storage/' . \App\Models\Setting::get('site_logo')) 
            : ($cars->first()?->image_url ? asset('storage/' . $cars->first()->image_url) : asset('assets/images/hyundai_logo.png'));
    @endphp

    <!-- Open Graph / Facebook / WhatsApp Preview -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDesc }}">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="Hyundai Gowa Surabaya HR Muhammad">
    <meta property="og:image" content="{{ $shareImage }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDesc }}">
    <meta name="twitter:image" content="{{ $shareImage }}">

    <!-- Schema.org JSON-LD Structured Data: AutoDealer & FAQPage -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@type": "AutoDealer",
      "name": "Hyundai Gowa HR Muhammad Surabaya - Sales Nico",
      "url": "{{ url('/') }}",
      "telephone": "+6281330135013",
      "priceRange": "Rp 245.800.000 - Rp 1.547.000.000",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "{{ $dealerAddress }}",
        "addressLocality": "Surabaya",
        "addressRegion": "Jawa Timur",
        "postalCode": "60189",
        "addressCountry": "ID"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": {{ $latitude }},
        "longitude": {{ $longitude }}
      },
      "openingHoursSpecification": [
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
          "opens": "08:00",
          "closes": "20:00"
        }
      ],
      "aggregateRating": {
        "@@type": "AggregateRating",
        "ratingValue": "4.9",
        "reviewCount": "184",
        "bestRating": "5",
        "worstRating": "1"
      }
    }
    </script>
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "Berapa minimal DP untuk kredit mobil Hyundai di Surabaya?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Program DP ringan mulai dari 10% - 20% atau angsuran ringan dengan bunga 0% hingga tenor 7 tahun melalui leasing mitra resmi Hyundai Gowa Surabaya."
          }
        },
        {
          "@type": "Question",
          "name": "Apakah melayani pembelian untuk KTP di luar kota Surabaya?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Ya, kami melayani pemesanan dan pengiriman unit ke seluruh wilayah Jawa Timur (Sidoarjo, Gresik, Malang, Pasuruan, Mojokerto, Madura) dan sekitarnya dengan proses cepat dan dibantu sampai unit tiba di rumah."
          }
        },
        {
          "@type": "Question",
          "name": "Berapa garansi baterai mobil listrik Hyundai (EV)?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Seluruh mobil listrik Hyundai (IONIQ 5, KONA Electric, IONIQ 9) mendapatkan garansi baterai tegangan tinggi selama 8 tahun atau 160.000 KM, serta gratis biaya perawatan dan jasa servis berkala."
          }
        },
        {
          "@type": "Question",
          "name": "Bagaimana cara mengajukan tukar tambah (Trade-In)?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Anda dapat menggunakan kalkulator tukar tambah di web kami atau menghubungi Nico 0813-3013-5013 untuk inspeksi gratis di rumah. Mobil lama semua merek dihargai dengan harga terbaik untuk memotong DP mobil baru Hyundai Anda."
          }
        }
      ]
    }
    </script>

    <!-- Third-Party Tracking Scripts (GTM, Google Ads, Meta Pixel) -->
    @include('partials.tracking-scripts')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Outfit', sans-serif; }
        [x-cloak] { display: none !important; }
        .car-card:hover .car-image { transform: scale(1.05); }
        .car-image { transition: transform 0.5s ease; }
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        @keyframes marquee-reverse {
            0% { transform: translateX(-50%); }
            100% { transform: translateX(0); }
        }
        .animate-marquee {
            animation: marquee 40s linear infinite;
        }
        .animate-marquee-reverse {
            animation: marquee-reverse 40s linear infinite;
        }
        .animate-marquee:hover, .animate-marquee-reverse:hover {
            animation-play-state: paused;
        }

        /* Global Dark Mode Rules for Homepage */
        .dark body {
            background-color: #070d19 !important;
            color: #f1f5f9 !important;
        }
        .dark .bg-white {
            background-color: #0c1527 !important;
        }
        .dark .bg-gray-50, .dark .bg-slate-50, .dark .bg-neutral-50 {
            background-color: #080f1d !important;
        }
        .dark .bg-gray-100 {
            background-color: #0f1c34 !important;
        }

        /* High Contrast Typography in Light & Dark Mode */
        h1:not([class*="text-white"]):not([class*="text-blue-"]):not([class*="text-cyan-"]),
        h2:not([class*="text-white"]):not([class*="text-blue-"]):not([class*="text-cyan-"]),
        h3:not([class*="text-white"]):not([class*="text-blue-"]):not([class*="text-cyan-"]),
        h4:not([class*="text-white"]):not([class*="text-blue-"]):not([class*="text-cyan-"]),
        h5:not([class*="text-white"]):not([class*="text-blue-"]):not([class*="text-cyan-"]),
        h6:not([class*="text-white"]):not([class*="text-blue-"]):not([class*="text-cyan-"]) {
            color: #0f172a;
        }
        .dark h1, .dark h2, .dark h3, .dark h4, .dark h5, .dark h6 {
            color: #ffffff !important;
        }
        .dark .text-gray-950, .dark .text-gray-900 {
            color: #ffffff !important;
        }
        .dark .text-gray-800 {
            color: #f1f5f9 !important;
        }
        .dark .text-gray-700, .dark .text-gray-600, .dark .text-gray-500 {
            color: #cbd5e1 !important;
        }
        .dark .border-gray-100, .dark .border-gray-200 {
            border-color: rgba(255, 255, 255, 0.12) !important;
        }
        .dark .shadow-sm, .dark .shadow-md, .dark .shadow-lg, .dark .shadow-xl {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.45) !important;
        }

        /* Testimonials in Dark Mode */
        .dark #testimonials {
            background-color: #070d19 !important;
        }
        .dark #testimonials .testimonial-card {
            background-color: #0f1c34 !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        .dark #testimonials .testimonial-card h4 {
            color: #38bdf8 !important;
        }
        .dark #testimonials .testimonial-card span.testimonial-title {
            color: #94a3b8 !important;
        }
        .dark #testimonials .testimonial-card p {
            color: #cbd5e1 !important;
        }
        .dark #testimonials .testimonial-avatar-box {
            background-color: #0f1c34 !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        /* Universal High-Contrast Form Inputs (Clean & Dark Mode) */
        input:not([type="range"]):not([type="checkbox"]):not([type="radio"]),
        select,
        textarea {
            color: #0f172a !important;
            -webkit-text-fill-color: #0f172a !important;
        }
        input:not([type="range"]):not([type="checkbox"]):not([type="radio"])::placeholder,
        textarea::placeholder {
            color: #64748b !important;
            -webkit-text-fill-color: #64748b !important;
            opacity: 1 !important;
        }
        .dark input:not([type="range"]):not([type="checkbox"]):not([type="radio"]),
        .dark select,
        .dark textarea {
            color: #ffffff !important;
            -webkit-text-fill-color: #ffffff !important;
            background-color: #0f1c34 !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
        }
        .dark input:not([type="range"]):not([type="checkbox"]):not([type="radio"])::placeholder,
        .dark textarea::placeholder {
            color: #94a3b8 !important;
            -webkit-text-fill-color: #94a3b8 !important;
            opacity: 1 !important;
        }
        .dark select option {
            background-color: #0c1527 !important;
            color: #ffffff !important;
        }

        /* AI Chat Lead Form High Contrast (Bulletproof in Light & Dark Mode) */
        .ai-lead-card {
            background: linear-gradient(135deg, #eff6ff 0%, #e0e7ff 100%) !important;
            border: 2px solid #93c5fd !important;
        }
        .ai-lead-card .form-title {
            color: #002c5f !important;
            -webkit-text-fill-color: #002c5f !important;
        }
        .ai-lead-card .form-desc {
            color: #1e293b !important;
            -webkit-text-fill-color: #1e293b !important;
        }
        .ai-lead-card .form-label {
            color: #0f172a !important;
            -webkit-text-fill-color: #0f172a !important;
        }
        .ai-lead-card input {
            background-color: #ffffff !important;
            color: #0f172a !important;
            -webkit-text-fill-color: #0f172a !important;
            border: 1px solid #cbd5e1 !important;
        }
        .ai-lead-card input::placeholder {
            color: #64748b !important;
            -webkit-text-fill-color: #64748b !important;
        }

        .dark .ai-lead-card {
            background: linear-gradient(135deg, #0d1a33 0%, #081224 100%) !important;
            border: 2px solid #1e3a8a !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5) !important;
        }
        .dark .ai-lead-card .form-title {
            color: #38bdf8 !important;
            -webkit-text-fill-color: #38bdf8 !important;
        }
        .dark .ai-lead-card .form-desc {
            color: #e2e8f0 !important;
            -webkit-text-fill-color: #e2e8f0 !important;
        }
        .dark .ai-lead-card .form-label {
            color: #ffffff !important;
            -webkit-text-fill-color: #ffffff !important;
        }
        .dark .ai-lead-card input {
            background-color: #060c18 !important;
            color: #ffffff !important;
            -webkit-text-fill-color: #ffffff !important;
            border: 1px solid #1e3a8a !important;
        }
        .dark .ai-lead-card input::placeholder {
            color: #94a3b8 !important;
            -webkit-text-fill-color: #94a3b8 !important;
        }

        /* Dark Mode Car Models Showcase */
        .dark #models {
            background-color: #070d19 !important;
        }
        .dark #models .group {
            background-color: #0c1527 !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
        }
        .dark #models .group:hover {
            border-color: rgba(0, 170, 210, 0.4) !important;
            box-shadow: 0 15px 35px rgba(0, 44, 95, 0.35) !important;
        }
        .dark #models .group h3 {
            color: #ffffff !important;
        }
        .dark #models .group div > span {
            color: #e2e8f0 !important;
        }
        .dark #models .group a {
            border-color: rgba(255, 255, 255, 0.18) !important;
            color: #e2e8f0 !important;
            background-color: transparent !important;
        }
        .dark #models .group a:hover {
            border-color: #00aad2 !important;
            background-color: #002c5f !important;
            color: #ffffff !important;
        }
    </style>
    @livewireStyles
</head>
<body class="bg-white dark:bg-[#070d19] text-gray-900 dark:text-slate-100 antialiased overflow-x-hidden transition-colors duration-300">
    @include('partials.tracking-body')
    
    <x-navbar />

    <!-- Live Showroom Event & Promo Countdown Banner -->
    @if(isset($activeEvent) && $activeEvent)
        <div class="bg-gradient-to-r from-[#002c5f] via-[#004080] to-[#001a3a] text-white pt-[64px] pb-3 px-4 sm:px-6 relative z-30 border-b border-cyan-500/30 shadow-lg"
             x-data="{
                 targetDate: new Date('{{ $activeEvent->event_date->toIso8601String() }}').getTime(),
                 days: '00', hours: '00', minutes: '00', seconds: '00',
                 init() {
                     const updateTimer = () => {
                         const now = new Date().getTime();
                         const diff = Math.max(0, this.targetDate - now);
                         this.days = String(Math.floor(diff / (1000 * 60 * 60 * 24))).padStart(2, '0');
                         this.hours = String(Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                         this.minutes = String(Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                         this.seconds = String(Math.floor((diff % (1000 * 60)) / 1000)).padStart(2, '0');
                     };
                     updateTimer();
                     setInterval(updateTimer, 1000);
                 }
             }">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-3">
                    <span class="px-2.5 py-1 rounded-full bg-cyan-400/20 text-cyan-300 border border-cyan-400/30 font-black text-[10px] uppercase tracking-wider animate-pulse flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                        EVENT SHOWROOM
                    </span>
                    <span class="font-extrabold text-white text-sm tracking-tight">{{ $activeEvent->title }}</span>
                    <span class="hidden lg:inline text-slate-300">| {{ $activeEvent->event_date->translatedFormat('l, d F Y') }} ({{ $activeEvent->start_time }} - {{ $activeEvent->end_time }} WIB)</span>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Countdown HUD -->
                    <div class="flex items-center gap-1.5 font-mono text-xs font-bold text-cyan-300 bg-black/40 px-3 py-1 rounded-xl border border-white/10">
                        <span x-text="days">00</span><span class="text-[9px] text-slate-400">h</span> :
                        <span x-text="hours">00</span><span class="text-[9px] text-slate-400">j</span> :
                        <span x-text="minutes">00</span><span class="text-[9px] text-slate-400">m</span> :
                        <span x-text="seconds">00</span><span class="text-[9px] text-slate-400">d</span>
                    </div>

                    <!-- RSVP WhatsApp Button -->
                    <a href="https://api.whatsapp.com/send/?phone=6281330135013&text={{ urlencode('Halo Nico, saya ingin RSVP daftar hadir untuk acara ' . $activeEvent->title . ' di Hyundai HR Muhammad Surabaya.') }}" 
                       target="_blank"
                       class="px-3.5 py-1.5 rounded-xl bg-cyan-400 hover:bg-cyan-300 text-slate-950 font-black transition text-[11px] uppercase tracking-wider flex items-center gap-1.5 shadow-md shadow-cyan-400/30">
                        <span>RSVP Hadir</span>
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Hero Section with Banner Slideshow -->
    <section id="home" class="relative h-screen overflow-hidden"
             x-data="{
                current: 0,
                cars: [
                    @forelse($cars as $index => $car)
                    {
                        name: '{{ $car->name }}',
                        category: '{{ $car->category }}',
                        price: 'Rp {{ number_format($car->price, 0, ',', '.') }}',
                        banner: '{{ $car->hero_image ? (\Illuminate\Support\Str::startsWith($car->hero_image, ['http://', 'https://']) ? $car->hero_image : asset('storage/'.$car->hero_image)) : ($car->image ? (\Illuminate\Support\Str::startsWith($car->image, ['http://', 'https://']) ? $car->image : asset('storage/'.$car->image)) : '') }}',
                        slug: '{{ $car->slug }}'
                    }{{ !$loop->last ? ',' : '' }}
                    @empty
                    {
                        name: '{{ \App\Models\Setting::get('site_name', 'Hyundai Showroom') }}',
                        category: 'WELCOME',
                        price: 'Hubungi Kami',
                        banner: '{{ asset('assets/images/hyundai_logo.png') }}',
                        slug: '#'
                    }
                    @endforelse
                ],
                go(index) {
                    this.current = index;
                },
                init() {
                    setInterval(() => {
                        this.go((this.current + 1) % this.cars.length);
                    }, 6000);
                }
             }">

        <!-- Banner Images -->
        <template x-for="(car, index) in cars" :key="index">
            <div class="absolute inset-0 transition-all duration-[1200ms] ease-in-out"
                 :style="current === index ? 'opacity:1; transform: scale(1);' : 'opacity:0; transform: scale(1.05);'">
                <img :src="car.banner" :alt="car.name" class="w-full h-full object-cover object-center">
            </div>
        </template>

        <!-- Gradient Overlays -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent z-10"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent z-10"></div>

        <!-- Content Layer -->
        <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-center">
            <div class="w-full max-w-3xl text-center md:text-left">
                <!-- Badge -->
                <div class="inline-block bg-white/10 backdrop-blur-md border border-white/20 px-4 py-1.5 rounded-full mb-6">
                    <span class="text-white text-[10px] font-black uppercase tracking-[0.3em]" x-text="cars[current].category"></span>
                </div>

                <!-- Car Title -->
                <h1 class="text-5xl md:text-8xl font-black text-white leading-[1.05] mb-4 drop-shadow-2xl" x-text="cars[current].name"></h1>
                
                <!-- Price Label -->
                <div class="mb-10">
                    <p class="text-sm md:text-lg text-white/50 mb-1 font-light tracking-wide">Harga OTR mulai dari</p>
                    <p class="text-3xl md:text-5xl font-black text-white" x-text="cars[current].price"></p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center md:justify-start gap-4">
                    <button @click="$dispatch('open-lead-modal')" 
                            type="button"
                            class="inline-flex items-center justify-center px-10 py-4 bg-emerald-600 hover:bg-emerald-500 text-white rounded-full font-black text-[13px] uppercase tracking-widest shadow-xl shadow-emerald-600/30 hover:-translate-y-1 transition-all gap-2">
                        <svg class="w-4 h-4 text-amber-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        <span>Klaim Promo & DP Ringan</span>
                    </button>
                    <a :href="'/car/' + cars[current].slug" 
                       class="inline-flex items-center justify-center px-10 py-4 bg-white/10 backdrop-blur-md text-white border border-white/30 rounded-full font-bold text-[13px] uppercase tracking-widest hover:bg-white/20 transition-all">
                        Lihat Detail Unit
                    </a>
                </div>

                <!-- Slide Indicators (Classic Morphing Pills) -->
                <div class="mt-16 flex items-center justify-center md:justify-start gap-3">
                    <template x-for="(car, index) in cars" :key="index">
                        <button @click="go(index)" 
                                class="h-1 rounded-full transition-all duration-500 shadow-lg"
                                :class="current === index ? 'w-12 bg-white' : 'w-3 bg-white/30 hover:bg-white/50'"></button>
                    </template>
                </div>
            </div>
        </div>

    </section>

    <!-- Promo Section (Livewire) -->
    <livewire:promo-section />

    <!-- Car Models - Break the Frame -->
    <section id="models" class="py-12 md:py-16 bg-white dark:bg-[#070d19]" x-data="{ activeTab: 'ALL', searchQuery: '', budgetFilter: 'ALL' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl md:text-5xl font-black text-gray-900 dark:text-white mb-4">{{ \App\Models\Setting::get('site_name', 'Hyundai') }} Models</h2>
                <div class="h-1.5 w-24 bg-[#002c5f] dark:bg-cyan-400 mx-auto rounded-full"></div>
            </div>

            <!-- Search & Budget Filter Controls Bar -->
            <div class="max-w-4xl mx-auto mb-6 bg-gray-50 dark:bg-slate-900/90 border border-gray-200/80 dark:border-slate-800 p-3 sm:p-4 rounded-2xl shadow-sm flex flex-col sm:flex-row items-center gap-3">
                <!-- Search Input -->
                <div class="relative w-full sm:flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 dark:text-gray-500">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    </div>
                    <input 
                        type="text" 
                        x-model="searchQuery" 
                        placeholder="Cari model mobil... (contoh: Stargazer, Creta, Ioniq, Palisade)" 
                        class="w-full pl-10 pr-8 py-2.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm font-semibold text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-[#002c5f] dark:focus:border-cyan-400 focus:ring-1 focus:ring-[#002c5f] transition"
                    >
                    <button 
                        type="button"
                        x-show="searchQuery" 
                        x-cloak
                        @click="searchQuery = ''" 
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Budget Filter Dropdown -->
                <div class="w-full sm:w-auto flex items-center gap-2">
                    <span class="text-[11px] font-bold text-gray-500 dark:text-gray-400 whitespace-nowrap hidden sm:inline">Budget:</span>
                    <select 
                        x-model="budgetFilter" 
                        class="w-full sm:w-52 py-2.5 px-3 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl text-xs font-bold text-gray-900 dark:text-white focus:outline-none focus:border-[#002c5f] dark:focus:border-cyan-400 transition cursor-pointer">
                        <option value="ALL">Semua Rentang Harga</option>
                        <option value="under350">&lt; Rp 350 Juta</option>
                        <option value="350to700">Rp 350 Jt - Rp 700 Jt</option>
                        <option value="above700">&gt; Rp 700 Juta</option>
                    </select>
                </div>
            </div>

            <!-- Visual Category Tabs Selector (Styled senada seperti di hyundai.com) -->
            <div class="flex flex-wrap items-center justify-center gap-2 md:gap-3 mb-14 max-w-5xl mx-auto">
                <button @click="activeTab = 'ALL'" 
                        :class="activeTab === 'ALL' ? 'bg-[#002c5f] dark:bg-cyan-500 dark:text-slate-950 text-white shadow-lg shadow-blue-900/20 scale-105 border-[#002c5f] dark:border-cyan-400' : 'bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 hover:bg-gray-50 dark:hover:bg-slate-700 border-gray-200 dark:border-slate-700'"
                        class="px-4 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider transition-all duration-300 focus:outline-none flex items-center gap-2 border">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg>
                    <span>Semua Model</span>
                </button>

                <button @click="activeTab = 'EV'" 
                        :class="activeTab === 'EV' ? 'bg-[#002c5f] dark:bg-cyan-500 dark:text-slate-950 text-white shadow-lg shadow-blue-900/20 scale-105 border-[#002c5f] dark:border-cyan-400' : 'bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 hover:bg-gray-50 dark:hover:bg-slate-700 border-gray-200 dark:border-slate-700'"
                        class="px-4 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider transition-all duration-300 focus:outline-none flex items-center gap-2 border">
                    <svg class="w-4 h-4 text-cyan-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                    <span>Electric (EV)</span>
                </button>

                <button @click="activeTab = 'HEV'" 
                        :class="activeTab === 'HEV' ? 'bg-[#002c5f] dark:bg-cyan-500 dark:text-slate-950 text-white shadow-lg shadow-blue-900/20 scale-105 border-[#002c5f] dark:border-cyan-400' : 'bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 hover:bg-gray-50 dark:hover:bg-slate-700 border-gray-200 dark:border-slate-700'"
                        class="px-4 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider transition-all duration-300 focus:outline-none flex items-center gap-2 border">
                    <svg class="w-4 h-4 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
                    <span>Hybrid (HEV)</span>
                </button>

                <button @click="activeTab = 'SUV'" 
                        :class="activeTab === 'SUV' ? 'bg-[#002c5f] dark:bg-cyan-500 dark:text-slate-950 text-white shadow-lg shadow-blue-900/20 scale-105 border-[#002c5f] dark:border-cyan-400' : 'bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 hover:bg-gray-50 dark:hover:bg-slate-700 border-gray-200 dark:border-slate-700'"
                        class="px-4 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider transition-all duration-300 focus:outline-none flex items-center gap-2 border">
                    <svg class="w-4 h-4 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/></svg>
                    <span>SUV</span>
                </button>

                <button @click="activeTab = 'MPV'" 
                        :class="activeTab === 'MPV' ? 'bg-[#002c5f] dark:bg-cyan-500 dark:text-slate-950 text-white shadow-lg shadow-blue-900/20 scale-105 border-[#002c5f] dark:border-cyan-400' : 'bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 hover:bg-gray-50 dark:hover:bg-slate-700 border-gray-200 dark:border-slate-700'"
                        class="px-4 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider transition-all duration-300 focus:outline-none flex items-center gap-2 border">
                    <svg class="w-4 h-4 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 16H9m10 0h2a1 1 0 0 0 1-1v-4a2 2 0 0 0-1.2-1.85L17.5 7.5A2 2 0 0 0 16 7H5a2 2 0 0 0-1.8 1.1L1.2 12A2 2 0 0 0 1 13v2a1 1 0 0 0 1 1h2"/><circle cx="6.5" cy="16.5" r="2.5"/><circle cx="16.5" cy="16.5" r="2.5"/></svg>
                    <span>MPV</span>
                </button>

                <button @click="activeTab = 'Luxury MPV'" 
                        :class="activeTab === 'Luxury MPV' ? 'bg-[#002c5f] dark:bg-cyan-500 dark:text-slate-950 text-white shadow-lg shadow-blue-900/20 scale-105 border-[#002c5f] dark:border-cyan-400' : 'bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 hover:bg-gray-50 dark:hover:bg-slate-700 border-gray-200 dark:border-slate-700'"
                        class="px-4 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider transition-all duration-300 focus:outline-none flex items-center gap-2 border">
                    <svg class="w-4 h-4 text-purple-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 3-1.9 5.8a2 2 0 0 1-1.3 1.3L3 12l5.8 1.9a2 2 0 0 1 1.3 1.3L12 21l1.9-5.8a2 2 0 0 1 1.3-1.3L21 12l-5.8-1.9a2 2 0 0 1-1.3-1.3L12 3z"/></svg>
                    <span>Luxury MPV</span>
                </button>
            </div>

            <!-- Hyundai.com Showcase Grid / Slider -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12 items-stretch max-w-7xl mx-auto">
                @foreach($cars as $car)
                    <div x-show="(activeTab === 'ALL' || activeTab === '{{ $car->category }}') && (!searchQuery || '{{ strtolower($car->name) }}'.includes(searchQuery.toLowerCase())) && (budgetFilter === 'ALL' || (budgetFilter === 'under350' && {{ $car->price }} < 350000000) || (budgetFilter === '350to700' && {{ $car->price }} >= 350000000 && {{ $car->price }} <= 700000000) || (budgetFilter === 'above700' && {{ $car->price }} > 700000000))"
                         x-cloak
                         x-transition:enter="transition ease-out duration-400"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="group flex flex-col justify-between bg-white dark:bg-[#0c1527] p-6 sm:p-8 transition-all duration-300 hover:shadow-xl hover:border-gray-100 dark:hover:border-cyan-500/30 border border-transparent dark:border-white/5 rounded-xl">
                        
                        <!-- Top Information: Model Name & Price (Senada seperti hyundai.com) -->
                        <div>
                            <a href="{{ route('car.show', $car->slug) }}" class="group/title block">
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-950 dark:text-white tracking-tight leading-snug group-hover/title:text-[#002c5f] dark:group-hover/title:text-cyan-400 transition-colors">
                                    {{ $car->name }}
                                </h3>
                            </a>
                            <div class="mt-2 text-sm text-gray-500 dark:text-slate-400 font-medium flex items-baseline gap-1.5">
                                <span>From</span>
                                <span class="text-base sm:text-lg font-bold text-gray-950 dark:text-white">
                                    Rp. {{ number_format($car->price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <!-- Center: Clean Profile Vehicle Image with Natural Shadow -->
                        <a href="{{ route('car.show', $car->slug) }}" class="relative w-full h-36 sm:h-44 md:h-48 flex items-center justify-center my-6 overflow-visible cursor-pointer block">
                            @if($car->image)
                                <img src="{{ asset('storage/'.$car->image) }}" 
                                     alt="{{ $car->name }}" 
                                     class="w-full h-full object-contain drop-shadow-[0_16px_14px_rgba(0,0,0,0.14)] transition-transform duration-500 group-hover:scale-105">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <svg class="w-16 h-16" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/></svg>
                                </div>
                            @endif
                        </a>

                        <!-- Bottom: 2 Stacked Rectangular Outline Buttons (Official Hyundai.com Style) -->
                        <div class="space-y-2.5 pt-2 relative z-10">
                            <a href="{{ route('car.show', $car->slug) }}" 
                               class="block w-full py-3 px-4 border border-gray-300 dark:border-slate-700 hover:border-gray-950 hover:bg-gray-950 dark:hover:border-cyan-400 dark:hover:bg-cyan-500/20 text-gray-700 dark:text-slate-200 hover:text-white text-xs font-semibold uppercase tracking-[0.2em] text-center transition duration-200 cursor-pointer">
                                DETAIL
                            </a>
                            <a href="{{ route('quotation', ['car_id' => $car->id]) }}" 
                               target="_blank"
                               class="block w-full py-3 px-4 border border-gray-300 dark:border-slate-700 hover:border-[#002c5f] hover:bg-[#002c5f] dark:hover:border-cyan-400 dark:hover:bg-blue-600 text-gray-700 dark:text-slate-200 hover:text-white text-xs font-semibold uppercase tracking-[0.2em] text-center transition duration-200">
                                GET QUOTE
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Bottom Pagination Dots & Pause Icon (Senada dengan hyundai.com) -->
            <div class="mt-14 flex items-center justify-center gap-2 text-gray-400">
                <span class="w-2.5 h-2.5 rounded-full bg-[#00aad2]"></span>
                <span class="w-2 h-2 rounded-full border border-gray-300"></span>
                <span class="w-2 h-2 rounded-full border border-gray-300"></span>
                <span class="w-2 h-2 rounded-full border border-gray-300"></span>
                <span class="w-2 h-2 rounded-full border border-gray-300"></span>
                <span class="w-2 h-2 rounded-full border border-gray-300"></span>
                <span class="w-2 h-2 rounded-full border border-gray-300"></span>
                <span class="w-2 h-2 rounded-full border border-gray-300"></span>
                <span class="w-2 h-2 rounded-full border border-gray-300"></span>
                <span class="ml-2 text-xs font-mono tracking-tighter text-gray-400">❚❚</span>
            </div>
        </div>
    </section>

    <!-- 360 Virtual Car Exterior Viewer -->
    <x-car-viewer-360 :cars="$cars" />

    <!-- Service Tools Section (Test Drive & Credit) -->
    <section id="services" class="py-12 md:py-16 bg-gray-50 dark:bg-[#080f1d] overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch">
                
                <!-- Left: Test Drive -->
                <div class="flex flex-col w-full">
                    <!-- Header Locked Height -->
                    <div style="min-height: 90px;" class="mb-2">
                        <span class="text-[10px] font-black text-blue-600 dark:text-cyan-400 uppercase tracking-[0.3em] block mb-2">Experience</span>
                        <h2 class="text-3xl font-black text-gray-900 dark:text-white leading-tight">Booking Test Drive</h2>
                        <div class="h-1 w-16 bg-[#002c5f] dark:bg-cyan-400 rounded-full mt-3"></div>
                    </div>
                    <!-- Card Container -->
                    <div class="flex-grow flex flex-col h-full">
                        <livewire:test-drive-form />
                    </div>
                </div>

                <!-- Right: Credit Simulation -->
                <div id="kredit" class="flex flex-col w-full mt-12 md:mt-0 scroll-mt-28">
                    <!-- Header Locked Height -->
                    <div style="min-height: 90px;" class="mb-2">
                        <span class="text-[10px] font-black text-blue-600 dark:text-cyan-400 uppercase tracking-[0.3em] block mb-2">Financing</span>
                        <h2 class="text-3xl font-black text-gray-900 dark:text-white leading-tight">Simulasi Kredit</h2>
                        <div class="h-1 w-16 bg-[#002c5f] dark:bg-cyan-400 rounded-full mt-3"></div>
                    </div>
                    <!-- Card Container -->
                    <div class="flex-grow flex flex-col h-full">
                        <livewire:credit-calculator />
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Trade-In Program Section -->
    <section id="trade-in" class="py-12 md:py-16 bg-white dark:bg-[#070d19] overflow-hidden transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <livewire:trade-in-calculator />
        </div>
    </section>

    <!-- Side-by-Side Car Comparator Section -->
    <section id="comparator" class="py-12 md:py-16 bg-gray-50 dark:bg-[#080f1d] overflow-hidden transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <livewire:car-comparator />
        </div>
    </section>

    <!-- EV Savings Calculator Section -->
    <section id="ev-savings" class="py-12 md:py-20 bg-slate-50 dark:bg-[#080f1d] overflow-hidden relative transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <livewire:ev-savings-calculator />
        </div>
    </section>

    <!-- Consultant Profile -->
    @if($consultant)
    <section id="consultant" class="py-12 md:py-16 bg-white dark:bg-[#070d19] transition-colors">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-[#0c1527] rounded-3xl overflow-hidden shadow-xl flex flex-col md:flex-row border border-gray-100 dark:border-slate-800">
                <div class="md:w-1/2 relative h-80 md:h-auto overflow-hidden bg-slate-900 flex items-center justify-center">
                    @php
                        $consultantPhotoUrl = null;
                        if (!empty($consultant->photo) && file_exists(storage_path('app/public/' . $consultant->photo))) {
                            $consultantPhotoUrl = asset('storage/' . $consultant->photo);
                        } elseif (file_exists(storage_path('app/public/consultants/nico-hardiansyah-official.jpg'))) {
                            $consultantPhotoUrl = asset('storage/consultants/nico-hardiansyah-official.jpg');
                        } elseif (file_exists(storage_path('app/public/consultants/01KRWBT0RARNH4AQSBRWBMGQEB.jpg'))) {
                            $consultantPhotoUrl = asset('storage/consultants/01KRWBT0RARNH4AQSBRWBMGQEB.jpg');
                        }
                    @endphp
                    @if($consultantPhotoUrl)
                        <img src="{{ $consultantPhotoUrl }}" 
                             alt="{{ $consultant->name ?? 'Official Consultant' }}" 
                             class="w-full h-full object-cover">
                    @else
                        <!-- Elegant Official Brand Fallback Card -->
                        <div class="w-full h-full min-h-[340px] bg-gradient-to-tr from-[#001738] via-[#002c5f] to-[#004080] flex flex-col items-center justify-center p-8 text-white text-center">
                            <div class="w-24 h-24 rounded-full bg-white/10 border-2 border-cyan-400/50 flex items-center justify-center text-cyan-300 mb-4 shadow-xl shadow-cyan-500/20">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <span class="text-[11px] font-black uppercase tracking-[0.25em] text-cyan-400 mb-1">Official Sales Consultant</span>
                            <span class="text-2xl font-black text-white">{{ $consultant->name ?? 'OFFICIAL HYUNDAI SURABAYA' }}</span>
                            <span class="text-xs text-blue-200/80 mt-1">Dealer Resmi Hyundai Gowa HR Muhammad</span>
                        </div>
                    @endif
                    @php
                        $cName = $consultant->name ?? 'Official Hyundai Surabaya';
                        $words = explode(' ', trim($cName));
                        $lastWord = count($words) > 1 ? array_pop($words) : $cName;
                        $firstWords = count($words) > 0 ? implode(' ', $words) : '';
                    @endphp
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6 text-white md:hidden">
                        <h3 class="text-2xl font-bold leading-tight">
                            @if($firstWords)
                                <span>{{ $firstWords }} </span>
                            @endif
                            <span class="inline-flex items-center gap-1.5 whitespace-nowrap">
                                <span>{{ $lastWord }}</span>
                                <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-blue-600 text-white shrink-0">
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </span>
                            </span>
                        </h3>
                        <p class="text-blue-400 text-xs tracking-widest uppercase font-bold mt-1">Verified Sales Consultant</p>
                    </div>
                </div>
                <div class="md:w-1/2 p-8 md:p-14 flex flex-col justify-center">
                    <h2 class="text-blue-600 dark:text-cyan-400 font-black tracking-widest uppercase mb-3 text-xs flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-600 dark:bg-cyan-400 animate-pulse"></span>
                        Sales Consultant
                    </h2>
                    <h3 class="text-3xl md:text-4xl font-black mb-6 text-gray-900 dark:text-white leading-tight">
                        @if($firstWords)
                            <span>{{ $firstWords }} </span>
                        @endif
                        <span class="inline-flex items-center gap-2 whitespace-nowrap">
                            <span>{{ $lastWord }}</span>
                            <!-- Verified Blue Checkmark Badge -->
                            <span class="inline-flex items-center justify-center w-6 h-6 md:w-7 md:h-7 rounded-full bg-blue-600 text-white shadow-sm ring-4 ring-blue-100 dark:ring-blue-900/50 shrink-0" title="Akun Resmi Terverifikasi">
                                <svg class="w-3.5 h-3.5 md:w-4 md:h-4 fill-current" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                        </span>
                    </h3>
                    
                    <div class="space-y-5 mb-8">
                        <div class="flex items-start">
                            <div class="bg-blue-50 dark:bg-slate-800/80 p-3 rounded-2xl mr-4 text-blue-600 dark:text-cyan-400 shrink-0 border border-blue-100 dark:border-slate-700">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-300">Lokasi Dealer Resmi</p>
                                <p class="text-gray-700 dark:text-slate-200 text-sm font-semibold mt-0.5">{{ $consultant->address ?? 'Jl. Mayjen HR. Muhammad No.35C, Kec. Sukomanunggal, Surabaya.' }}</p>
                                
                                <!-- Google Review Social Proof Badge -->
                                <div class="mt-2.5">
                                    <a href="https://maps.app.goo.gl/wJk4zXpG8M8GzK2T6" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-amber-50/90 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/50 hover:bg-amber-100 dark:hover:bg-amber-900/50 transition group shadow-xs" title="Lihat Ulasan Resmi Dealer Hyundai di Google Maps">
                                        <!-- Google Multi-color G Icon -->
                                        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24">
                                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                                        </svg>
                                        <div class="flex items-center text-amber-500 text-xs tracking-tighter">
                                            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                                        </div>
                                        <span class="text-xs font-black text-gray-900 dark:text-amber-200">4.9/5</span>
                                        <span class="text-[11px] text-gray-600 dark:text-slate-300 font-medium">(380+ Ulasan Google)</span>
                                        <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-amber-600 dark:group-hover:text-amber-300 group-hover:translate-x-0.5 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-emerald-50 dark:bg-slate-800/80 p-3 rounded-2xl mr-4 text-emerald-600 dark:text-emerald-400 shrink-0 border border-emerald-100 dark:border-slate-700">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-300">WhatsApp</p>
                                <p class="text-gray-700 dark:text-slate-200 text-sm font-semibold mt-0.5">{{ $consultant->phone ?? '0813-3013-5013' }}</p>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('track.wa') }}" class="bg-[#002c5f] dark:bg-cyan-500 dark:text-slate-950 hover:bg-blue-800 dark:hover:bg-cyan-400 text-white text-center py-4 px-6 rounded-2xl font-black text-sm uppercase tracking-wider transition-all shadow-lg shadow-blue-900/20 flex items-center justify-center gap-3">
                        <svg class="w-5 h-5 text-emerald-400 dark:text-slate-950" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"/></svg>
                        Hubungi {{ $consultant->name ?? 'OFFICIAL' }}
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

    @if(isset($testimonials) && $testimonials->count() > 0)
    <!-- Testimonials Section -->
    <section id="testimonials" class="py-16 md:py-24 bg-white dark:bg-[#070d19] overflow-hidden relative border-t border-b border-gray-100 dark:border-white/5 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16 text-center">
            <h2 class="text-3xl md:text-5xl font-black mb-4 text-[#002c5f] dark:text-white uppercase tracking-widest">Testimonials</h2>
            <div class="h-1 w-24 bg-[#002c5f] dark:bg-cyan-500 mx-auto mb-6"></div>
            <p class="text-gray-600 dark:text-slate-400">Apa kata mereka yang telah merasakan pelayanan terbaik kami.</p>
        </div>

        <div class="relative w-full flex flex-col gap-10" style="overflow: hidden; padding-top: 40px; padding-bottom: 20px;">
            <!-- Left Gradient Mask -->
            <div class="absolute inset-y-0 left-0 w-24 sm:w-36 bg-gradient-to-r from-white dark:from-[#070d19] to-transparent z-10 pointer-events-none transition-colors"></div>
            <!-- Right Gradient Mask -->
            <div class="absolute inset-y-0 right-0 w-24 sm:w-36 bg-gradient-to-l from-white dark:from-[#070d19] to-transparent z-10 pointer-events-none transition-colors"></div>

            @php
                // Ensure we have enough items to fill the screen width for a smooth loop
                $baseItems = collect();
                while($baseItems->count() < 8 && $testimonials->count() > 0) {
                    $baseItems = $baseItems->merge($testimonials);
                }
            @endphp

            <!-- Top Row (Right to Left) -->
            <div class="flex w-max animate-marquee hover:cursor-grab active:cursor-grabbing">
                <!-- Set 1 -->
                <div class="flex gap-8 px-4 shrink-0">
                    @foreach($baseItems as $testimonial)
                        <div class="testimonial-card relative flex flex-col justify-between pt-14 pb-8 px-8 bg-slate-100 dark:bg-[#0f1c34] border border-gray-200/80 dark:border-white/10 rounded-2xl shadow-sm hover:shadow-xl dark:hover:border-cyan-500/40 transition-all duration-300 flex-shrink-0" style="width: 350px; white-space: normal;">
                            <!-- Overlapping Image -->
                            <div class="absolute -top-12 left-1/2 transform -translate-x-1/2">
                                <div class="testimonial-avatar-box w-24 h-24 rounded-full p-1.5 bg-white dark:bg-[#0f1c34] border border-gray-100 dark:border-white/10 shadow-md">
                                    @if($testimonial->image)
                                        <img src="{{ asset('storage/' . $testimonial->image) }}" 
                                             alt="{{ $testimonial->name }}" 
                                             class="w-full h-full rounded-full object-cover"
                                             onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($testimonial->name) }}&background=EBF8FF&color=2B6CB0';">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($testimonial->name) }}&background=EBF8FF&color=2B6CB0" 
                                             alt="{{ $testimonial->name }}" 
                                             class="w-full h-full rounded-full object-cover">
                                    @endif
                                </div>
                            </div>
                            
                            <div class="text-center mt-2 flex-grow">
                                <p class="text-gray-700 dark:text-slate-300 text-[15px] leading-relaxed">
                                    <span class="text-[#002c5f] dark:text-cyan-400 text-3xl font-serif font-bold align-bottom leading-none mr-1">“</span>
                                    {{ $testimonial->quote }}
                                    <span class="text-[#002c5f] dark:text-cyan-400 text-3xl font-serif font-bold align-bottom leading-none ml-1">”</span>
                                </p>
                            </div>
                            
                            <div class="text-center mt-6">
                                <h4 class="font-bold text-[#002c5f] dark:text-cyan-300 text-lg inline-block">{{ $testimonial->name }}</h4>
                                @if($testimonial->title)
                                    <span class="testimonial-title text-xs text-gray-500 dark:text-slate-400 font-semibold inline-block ml-1">{{ $testimonial->title }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Set 2 (Duplicate for seamless loop) -->
                <div class="flex gap-8 px-4 shrink-0">
                    @foreach($baseItems as $testimonial)
                        <div class="testimonial-card relative flex flex-col justify-between pt-14 pb-8 px-8 bg-slate-100 dark:bg-[#0f1c34] border border-gray-200/80 dark:border-white/10 rounded-2xl shadow-sm hover:shadow-xl dark:hover:border-cyan-500/40 transition-all duration-300 flex-shrink-0" style="width: 350px; white-space: normal;">
                            <!-- Overlapping Image -->
                            <div class="absolute -top-12 left-1/2 transform -translate-x-1/2">
                                <div class="testimonial-avatar-box w-24 h-24 rounded-full p-1.5 bg-white dark:bg-[#0f1c34] border border-gray-100 dark:border-white/10 shadow-md">
                                    @if($testimonial->image)
                                        <img src="{{ asset('storage/' . $testimonial->image) }}" 
                                             alt="{{ $testimonial->name }}" 
                                             class="w-full h-full rounded-full object-cover"
                                             onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($testimonial->name) }}&background=EBF8FF&color=2B6CB0';">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($testimonial->name) }}&background=EBF8FF&color=2B6CB0" 
                                             alt="{{ $testimonial->name }}" 
                                             class="w-full h-full rounded-full object-cover">
                                    @endif
                                </div>
                            </div>
                            
                            <div class="text-center mt-2 flex-grow">
                                <p class="text-gray-700 dark:text-slate-300 text-[15px] leading-relaxed">
                                    <span class="text-[#002c5f] dark:text-cyan-400 text-3xl font-serif font-bold align-bottom leading-none mr-1">“</span>
                                    {{ $testimonial->quote }}
                                    <span class="text-[#002c5f] dark:text-cyan-400 text-3xl font-serif font-bold align-bottom leading-none ml-1">”</span>
                                </p>
                            </div>
                            
                            <div class="text-center mt-6">
                                <h4 class="font-bold text-[#002c5f] dark:text-cyan-300 text-lg inline-block">{{ $testimonial->name }}</h4>
                                @if($testimonial->title)
                                    <span class="testimonial-title text-xs text-gray-500 dark:text-slate-400 font-semibold inline-block ml-1">{{ $testimonial->title }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Removed Bottom Row as requested -->
        </div>
    </section>
    @endif

    <!-- Handover Gallery -->
    <section id="gallery" class="py-12 md:py-16 bg-gray-50 dark:bg-[#080f1d] transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-black mb-4 text-gray-950 dark:text-white">Galeri Serah Terima</h2>
                <p class="text-slate-700 dark:text-slate-300 uppercase tracking-widest text-sm font-bold">Kebahagiaan Pelanggan Kami</p>
                <div class="h-1.5 w-24 bg-[#002c5f] dark:bg-cyan-400 mx-auto rounded-full mt-4"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-5">
                @forelse($galleries as $gallery)
                    <div class="relative group aspect-[4/3] overflow-hidden rounded-2xl bg-gray-100 dark:bg-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-200/60 dark:border-slate-800">
                        <img src="{{ asset('storage/'.$gallery->image) }}" alt="{{ $gallery->caption }}" loading="lazy" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-108">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/25 to-transparent flex flex-col justify-end p-4 transition-opacity">
                            <span class="inline-block px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider bg-[#002c5f] dark:bg-cyan-500 text-white rounded w-fit mb-1.5 shadow-sm">Serah Terima Resmi</span>
                            <p class="text-white text-xs font-semibold leading-snug drop-shadow line-clamp-2">{{ $gallery->caption }}</p>
                        </div>
                    </div>
                @empty
                    @for($i=1; $i<=4; $i++)
                        <div class="relative group aspect-[4/3] overflow-hidden rounded-2xl bg-gray-200 dark:bg-slate-800 animate-pulse"></div>
                    @endfor
                @endforelse
            </div>
        </div>
    </section>

    <!-- Blog / News Section -->
    <section id="news" class="py-12 md:py-16 bg-white dark:bg-[#070d19] transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16 gap-6">
                <div>
                    <h2 class="text-3xl md:text-5xl font-black mb-4 text-gray-950 dark:text-white">Auto Insight & Exclusive Updates</h2>
                    <p class="text-slate-700 dark:text-slate-300 uppercase tracking-widest text-sm max-w-2xl font-bold">Jelajahi dunia otomotif melalui kacamata Hyundai. Dapatkan tips eksklusif, berita teknologi terbaru, dan penawaran yang dipersonalisasi khusus untuk Anda.</p>
                    <div class="h-1.5 w-24 bg-[#002c5f] dark:bg-cyan-400 rounded-full mt-4"></div>
                </div>
                <a href="{{ route('posts.index') }}" class="flex items-center text-[#002c5f] dark:text-cyan-400 font-extrabold hover:underline gap-2 group/all">
                    Explore All Insights
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover/all:translate-x-1"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($posts->take(8) as $post)
                    <article class="group bg-white dark:bg-[#0c1527] rounded-2xl overflow-hidden border border-gray-200 dark:border-slate-800 hover:border-blue-200 dark:hover:border-cyan-500/40 hover:shadow-xl transition-all duration-500">
                        <a href="{{ route('posts.show', $post->slug) }}" class="block overflow-hidden aspect-video bg-gray-100 dark:bg-slate-800">
                            @if($post->image)
                                <img src="{{ \Illuminate\Support\Str::startsWith($post->image, ['http://', 'https://']) ? $post->image : asset('storage/' . $post->image) }}" 
                                     alt="{{ $post->title }}" 
                                     loading="lazy"
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 dark:from-slate-800 dark:to-slate-900 text-gray-400 dark:text-slate-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="mb-2"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                    <span class="text-[10px] uppercase tracking-widest font-bold">Image Preview</span>
                                </div>
                            @endif
                        </a>
                        <div class="p-5 flex flex-col justify-between h-[calc(100%-aspect-video)]">
                            <div>
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="bg-blue-50 dark:bg-slate-800 text-[#002c5f] dark:text-cyan-300 text-[10px] font-black px-2.5 py-1 rounded-lg uppercase tracking-wider border border-blue-100 dark:border-slate-700">
                                        {{ $post->category }}
                                    </span>
                                    <span class="text-slate-600 dark:text-slate-400 text-[10px] uppercase tracking-widest font-bold">
                                        {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}
                                    </span>
                                </div>
                                <h3 class="text-base font-extrabold mb-2 line-clamp-2 text-gray-950 dark:text-white group-hover:text-[#002c5f] dark:group-hover:text-cyan-400 transition-colors leading-snug">
                                    <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                                </h3>
                                @php
                                    $cleanContent = preg_replace('/<div class="p-4 rounded-2xl bg-blue-50.*?<\/div>/is', '', $post->content);
                                    $cleanExcerpt = trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($cleanContent))));
                                @endphp
                                <p class="text-slate-700 dark:text-slate-300 text-xs line-clamp-2 mb-4 font-normal leading-relaxed">
                                    {{ Str::limit($cleanExcerpt, 85) }}
                                </p>
                            </div>
                            <a href="{{ route('posts.show', $post->slug) }}" class="inline-flex items-center text-xs font-black text-gray-950 dark:text-cyan-400 group-hover:text-[#002c5f] dark:group-hover:text-cyan-300 gap-1.5 uppercase tracking-wider mt-auto">
                                Read More
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover:translate-x-1"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </a>
                        </div>
                    </article>
                @empty
                    @for($i=1; $i<=4; $i++)
                        <div class="bg-gray-100 rounded-2xl aspect-video animate-pulse"></div>
                    @endfor
                @endforelse
            </div>
            
            <div class="mt-12 text-center md:hidden">
                <a href="{{ route('posts.index') }}" class="inline-flex items-center bg-gray-50 px-8 py-4 rounded-full text-[#002c5f] font-bold gap-2">
                    Lihat Semua Berita
                </a>
            </div>
        </div>
    </section>

    <!-- Video & Map -->
    <section class="py-12 md:py-16 bg-gray-50 dark:bg-[#080f1d] transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 gap-12">
            <div class="rounded-3xl overflow-hidden shadow-lg aspect-video bg-black">
                @php
                    $videoId = 'gAXz8h9nmug';
                    if ($video && $video->url) {
                        if (preg_match('/(?:\?v=|&v=|be\/|embed\/|v\/|.*v=)([^"&?\/\s]{11})/', $video->url, $matches)) {
                            $videoId = $matches[1];
                        }
                    }
                @endphp
                <iframe class="w-full h-full" 
                        loading="lazy"
                        src="https://www.youtube.com/embed/{{ $videoId }}" 
                        title="{{ $video->title ?? 'Hyundai Video' }}" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        allowfullscreen>
                </iframe>
            </div>
            <div class="rounded-3xl overflow-hidden shadow-lg h-full min-h-[400px]">
                @if($consultant && $consultant->maps_embed)
                    {!! $consultant->maps_embed !!}
                @else
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.6919013583567!2d112.6967817748402!3d-7.275883692731089!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fc6778f8447d%3A0x6794680879612f0f!2sHyundai%20Gowa%20Surabaya!5e0!3m2!1sid!2sid!4v1714876800000!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                @endif
            </div>
        </div>
    </section>

    <!-- FAQ Khusus Mobil Listrik & Garansi Resmi Hyundai -->
    <section id="faq" class="py-16 md:py-24 bg-white dark:bg-[#070d19] border-t border-gray-100 dark:border-slate-800 transition-colors" x-data="{ activeFaq: 1 }">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-black text-blue-600 dark:text-cyan-400 uppercase tracking-[0.25em] block mb-2">Panduan Calon Pembeli</span>
                <h2 class="text-3xl md:text-5xl font-black text-gray-900 dark:text-white tracking-tight leading-tight">
                    Pertanyaan Seputar <span class="text-[#002c5f] dark:text-cyan-400">Mobil Listrik & Garansi Hyundai</span>
                </h2>
                <div class="h-1.5 w-20 bg-[#002c5f] dark:bg-cyan-400 rounded-full mx-auto mt-4"></div>
                <p class="text-slate-700 dark:text-slate-300 font-medium text-sm mt-4">
                    Semua yang perlu Anda ketahui tentang kemudahan memiliki mobil listrik (EV), garansi baterai 8 tahun, dan pengisian daya di rumah.
                </p>
            </div>

            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div class="border border-gray-200 dark:border-slate-800 rounded-2xl overflow-hidden transition-all duration-200" :class="activeFaq === 1 ? 'border-blue-500 shadow-md bg-blue-50/50 dark:bg-slate-900/90' : 'bg-white dark:bg-[#0c1527] hover:border-gray-300 dark:hover:border-slate-700'">
                    <button @click="activeFaq = (activeFaq === 1 ? null : 1)" class="w-full p-5 sm:p-6 text-left flex items-center justify-between gap-4 focus:outline-none">
                        <span class="font-extrabold text-base sm:text-lg text-gray-900 dark:text-white">Berapa lama garansi baterai mobil listrik (EV) Hyundai?</span>
                        <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-slate-800 text-[#002c5f] dark:text-cyan-400 flex items-center justify-center shrink-0 transition-transform duration-300" :class="activeFaq === 1 ? 'rotate-180 bg-[#002c5f] text-white dark:bg-cyan-500 dark:text-slate-950' : ''">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </button>
                    <div x-show="activeFaq === 1" x-collapse x-cloak class="px-5 sm:px-6 pb-6 text-sm text-slate-800 dark:text-slate-200 leading-relaxed border-t border-gray-200 dark:border-slate-800 pt-4 font-normal">
                        Baterai tegangan tinggi (<em>High Voltage Battery</em>) pada semua lini mobil listrik Hyundai (seperti <strong>IONIQ 5, IONIQ 6, dan All New KONA Electric</strong>) dilindungi garansi resmi selama <strong>8 Tahun atau 160.000 KM</strong> (mana yang tercapai lebih dulu). Selain itu, kendaraan juga dilindungi garansi dasar manufaktur hingga 3-4 tahun dan gratis servis suku cadang.
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="border border-gray-200 dark:border-slate-800 rounded-2xl overflow-hidden transition-all duration-200" :class="activeFaq === 2 ? 'border-blue-500 shadow-md bg-blue-50/50 dark:bg-slate-900/90' : 'bg-white dark:bg-[#0c1527] hover:border-gray-300 dark:hover:border-slate-700'">
                    <button @click="activeFaq = (activeFaq === 2 ? null : 2)" class="w-full p-5 sm:p-6 text-left flex items-center justify-between gap-4 focus:outline-none">
                        <span class="font-extrabold text-base sm:text-lg text-gray-900 dark:text-white">Bagaimana cara mengisi daya (charging) di rumah? Apakah sulit?</span>
                        <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-slate-800 text-[#002c5f] dark:text-cyan-400 flex items-center justify-center shrink-0 transition-transform duration-300" :class="activeFaq === 2 ? 'rotate-180 bg-[#002c5f] text-white dark:bg-cyan-500 dark:text-slate-950' : ''">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </button>
                    <div x-show="activeFaq === 2" x-collapse x-cloak class="px-5 sm:px-6 pb-6 text-sm text-slate-800 dark:text-slate-200 leading-relaxed border-t border-gray-200 dark:border-slate-800 pt-4 font-normal">
                        Sangat mudah dan praktis! Setiap pembelian mobil listrik Hyundai, Anda mendapatkan fasilitas <strong>Gratis AC Home Wallbox Charger 7.4 kW / 11 kW</strong> lengkap dengan survei dan pemasangan teknisi berlisensi langsung di rumah Anda. Anda juga mendapatkan kabel <em>Portable Emergency Charger</em> yang dapat langsung dicolok ke stopkontak rumah biasa (schuko).
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="border border-gray-200 dark:border-slate-800 rounded-2xl overflow-hidden transition-all duration-200" :class="activeFaq === 3 ? 'border-blue-500 shadow-md bg-blue-50/50 dark:bg-slate-900/90' : 'bg-white dark:bg-[#0c1527] hover:border-gray-300 dark:hover:border-slate-700'">
                    <button @click="activeFaq = (activeFaq === 3 ? null : 3)" class="w-full p-5 sm:p-6 text-left flex items-center justify-between gap-4 focus:outline-none">
                        <span class="font-extrabold text-base sm:text-lg text-gray-900 dark:text-white">Apakah ada diskon tarif listrik khusus dari PLN untuk pemilik EV?</span>
                        <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-slate-800 text-[#002c5f] dark:text-cyan-400 flex items-center justify-center shrink-0 transition-transform duration-300" :class="activeFaq === 3 ? 'rotate-180 bg-[#002c5f] text-white dark:bg-cyan-500 dark:text-slate-950' : ''">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </button>
                    <div x-show="activeFaq === 3" x-collapse x-cloak class="px-5 sm:px-6 pb-6 text-sm text-slate-800 dark:text-slate-200 leading-relaxed border-t border-gray-200 dark:border-slate-800 pt-4 font-normal">
                        <strong>Ya, benar!</strong> PLN memiliki program insentif resmi diskon tarif listrik sebesar <strong>30% setiap hari pada pukul 22.00 s/d 05.00 WIB</strong> khusus untuk pengisian daya kendaraan listrik di rumah melalui Home Charging Wallbox. Biaya pengisian menjadi sangat murah, hanya sekitar Rp 1.187 per kWh!
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="border border-gray-200 dark:border-slate-800 rounded-2xl overflow-hidden transition-all duration-200" :class="activeFaq === 4 ? 'border-blue-500 shadow-md bg-blue-50/50 dark:bg-slate-900/90' : 'bg-white dark:bg-[#0c1527] hover:border-gray-300 dark:hover:border-slate-700'">
                    <button @click="activeFaq = (activeFaq === 4 ? null : 4)" class="w-full p-5 sm:p-6 text-left flex items-center justify-between gap-4 focus:outline-none">
                        <span class="font-extrabold text-base sm:text-lg text-gray-900 dark:text-white">Berapa lama waktu pengisian daya di SPKLU Fast Charging luar kota?</span>
                        <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-slate-800 text-[#002c5f] dark:text-cyan-400 flex items-center justify-center shrink-0 transition-transform duration-300" :class="activeFaq === 4 ? 'rotate-180 bg-[#002c5f] text-white dark:bg-cyan-500 dark:text-slate-950' : ''">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </button>
                    <div x-show="activeFaq === 4" x-collapse x-cloak class="px-5 sm:px-6 pb-6 text-sm text-slate-800 dark:text-slate-200 leading-relaxed border-t border-gray-200 dark:border-slate-800 pt-4 font-normal">
                        Didukung arsitektur <em>E-GMP 800V Ultra-Fast Charging</em>, pengisian dari kapasitas 10% hingga 80% pada IONIQ 5 & IONIQ 6 hanya membutuhkan waktu <strong>kurang lebih 18 menit</strong> di SPKLU Ultra Fast DC 350 kW, atau sekitar 45-55 menit di SPKLU Fast DC 50 kW yang telah tersedia di mall, rest area tol Trans Jawa, dan dealer resmi Hyundai Surabaya.
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="border border-gray-200 dark:border-slate-800 rounded-2xl overflow-hidden transition-all duration-200" :class="activeFaq === 5 ? 'border-blue-500 shadow-md bg-blue-50/50 dark:bg-slate-900/90' : 'bg-white dark:bg-[#0c1527] hover:border-gray-300 dark:hover:border-slate-700'">
                    <button @click="activeFaq = (activeFaq === 5 ? null : 5)" class="w-full p-5 sm:p-6 text-left flex items-center justify-between gap-4 focus:outline-none">
                        <span class="font-extrabold text-base sm:text-lg text-gray-900 dark:text-white">Berapa biaya servis & perawatan berkala mobil listrik?</span>
                        <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-slate-800 text-[#002c5f] dark:text-cyan-400 flex items-center justify-center shrink-0 transition-transform duration-300" :class="activeFaq === 5 ? 'rotate-180 bg-[#002c5f] text-white dark:bg-cyan-500 dark:text-slate-950' : ''">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </button>
                    <div x-show="activeFaq === 5" x-collapse x-cloak class="px-5 sm:px-6 pb-6 text-sm text-slate-800 dark:text-slate-200 leading-relaxed border-t border-gray-200 dark:border-slate-800 pt-4 font-normal">
                        <strong>Bebas Biaya Jasa Servis & Suku Cadang hingga 5 Tahun atau 75.000 KM!</strong> Mobil listrik memiliki komponen mekanis bergerak yang jauh lebih sedikit dibanding mesin konvensional (tidak perlu ganti oli mesin, busi, timing belt, atau filter bahan bakar), sehingga biaya perawatan rutin tahunan praktis mendekati nol rupiah.
                    </div>
                </div>

                <!-- FAQ Item 6 -->
                <div class="border border-gray-200 dark:border-slate-800 rounded-2xl overflow-hidden transition-all duration-200" :class="activeFaq === 6 ? 'border-blue-500 shadow-md bg-blue-50/50 dark:bg-slate-900/90' : 'bg-white dark:bg-[#0c1527] hover:border-gray-300 dark:hover:border-slate-700'">
                    <button @click="activeFaq = (activeFaq === 6 ? null : 6)" class="w-full p-5 sm:p-6 text-left flex items-center justify-between gap-4 focus:outline-none">
                        <span class="font-extrabold text-base sm:text-lg text-gray-900 dark:text-white">Apakah saya bisa tukar tambah (Trade-In) mobil bensin lama saya?</span>
                        <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-slate-800 text-[#002c5f] dark:text-cyan-400 flex items-center justify-center shrink-0 transition-transform duration-300" :class="activeFaq === 6 ? 'rotate-180 bg-[#002c5f] text-white dark:bg-cyan-500 dark:text-slate-950' : ''">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </button>
                    <div x-show="activeFaq === 6" x-collapse x-cloak class="px-5 sm:px-6 pb-6 text-sm text-slate-800 dark:text-slate-200 leading-relaxed border-t border-gray-200 dark:border-slate-800 pt-4 font-normal">
                        <strong>Tentu saja bisa!</strong> Melalui layanan resmi Tukar Tambah Hyundai, kami menerima semua merek mobil lama (Toyota, Honda, Mitsubishi, Suzuki, dll) dengan penilaian harga pasar yang transparan dan kompetitif. Nilai tukar tambah mobil lama Anda dapat langsung dialokasikan sebagai Uang Muka (DP) unit Hyundai baru Anda.
                    </div>
                </div>
            </div>

            <!-- Still Have Questions CTA -->
            <div class="mt-12 text-center p-8 bg-blue-50/90 dark:bg-[#0c1527] rounded-3xl border border-blue-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-6 shadow-md transition-colors">
                <div class="text-center sm:text-left">
                    <h4 class="text-lg font-black text-[#002c5f] dark:text-white">Masih punya pertanyaan seputar promo atau mobil listrik?</h4>
                    <p class="text-xs text-slate-700 dark:text-slate-300 font-semibold mt-1">Konsultasikan kebutuhan mobilitas Anda langsung dengan Sales Consultant resmi kami.</p>
                </div>
                <a href="{{ route('track.wa', ['text' => 'Halo Mas Nico, saya ingin konsultasi mengenai mobil listrik Hyundai dan promo terbarunya.']) }}" target="_blank"
                    class="px-6 py-3.5 bg-[#002c5f] hover:bg-blue-800 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition shadow-lg shadow-blue-900/20 whitespace-nowrap flex items-center gap-2">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
                    <span>Tanya Sales via WhatsApp</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Local SEO Dominance: Google Maps & Area Coverage Surabaya -->
    <section class="py-12 bg-white dark:bg-[#070d19] border-t border-slate-100 dark:border-slate-800 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl p-6 sm:p-10 bg-slate-50 dark:bg-[#0c1527] border border-gray-100 dark:border-slate-800 shadow-xl">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    <div class="lg:col-span-5">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100 dark:bg-cyan-950/80 text-[#002c5f] dark:text-cyan-300 text-xs font-bold uppercase tracking-wider mb-3">
                            <span>📍 Showroom & Bengkel Resmi Surabaya</span>
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-black text-gray-900 dark:text-white leading-tight mb-3">
                            Dealer Resmi Hyundai Gowa <span class="text-blue-600 dark:text-cyan-400">HR Muhammad</span>
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-600 dark:text-slate-300 leading-relaxed mb-4">
                            Jl. Mayjen HR. Muhammad No.35C, Sonokwijenan, Kec. Sukomanunggal, Surabaya, Jawa Timur 60189.
                        </p>
                        <div class="p-3.5 rounded-2xl bg-white dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700/80 mb-4 text-xs space-y-1.5">
                            <div class="flex items-center justify-between font-bold text-gray-900 dark:text-white">
                                <span>Rating Konsumen Google:</span>
                                <span class="text-amber-500 font-black flex items-center gap-1">
                                    ★★★★★ <span class="text-slate-800 dark:text-white">4.9 / 5.0</span>
                                </span>
                            </div>
                            <div class="text-[11px] text-gray-500 dark:text-slate-400">
                                Berdasarkan 180+ ulasan terverifikasi pembeli mobil Hyundai di Surabaya.
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2.5">
                            <a href="https://maps.app.goo.gl/wJk4zXpG8M8GzK2T6" target="_blank" class="px-4 py-2.5 rounded-xl bg-[#002c5f] hover:bg-blue-800 text-white font-bold text-xs uppercase tracking-wider transition shadow-md">
                                Buka di Google Maps
                            </a>
                            <a href="{{ route('testdrive.index') }}" class="px-4 py-2.5 rounded-xl bg-cyan-50 dark:bg-cyan-950 text-cyan-700 dark:text-cyan-300 font-bold text-xs uppercase tracking-wider border border-cyan-300/40 hover:bg-cyan-100 transition">
                                Booking Test Drive
                            </a>
                        </div>
                    </div>

                    <div class="lg:col-span-7">
                        <div class="rounded-2xl overflow-hidden shadow-inner h-72 border border-slate-200 dark:border-slate-700">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.732386705593!2d112.6975251!3d-7.2847!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fc2791722883%3A0xa1ea16410292da26!2sJl.%20Mayjen%20HR.%20Muhammad%20No.35C%2C%20Sonokwijenan%2C%20Kec.%20Sukomanunggal%2C%20Surabaya%2C%20Jawa%20Timur%2060189!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" 
                                width="100%" 
                                height="100%" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200/80 dark:border-slate-800">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-slate-400 mb-3">
                        Wilayah Layanan & Pengantaran Unit Se-Gerbangkertosusila:
                    </h4>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 text-[11px] text-gray-600 dark:text-slate-300">
                        <div class="p-2.5 rounded-xl bg-white dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700/50">
                            <strong class="text-blue-600 dark:text-cyan-400 block mb-0.5">Surabaya Barat</strong>
                            HR Muhammad, Citraland, Pakuwon, Wiyung, Sambikerep, Sukomanunggal.
                        </div>
                        <div class="p-2.5 rounded-xl bg-white dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700/50">
                            <strong class="text-blue-600 dark:text-cyan-400 block mb-0.5">Surabaya Pusat & Selatan</strong>
                            Darmo, Basuki Rahmat, Gubeng, Wonokromo, Jemursari, Ahmad Yani.
                        </div>
                        <div class="p-2.5 rounded-xl bg-white dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700/50">
                            <strong class="text-blue-600 dark:text-cyan-400 block mb-0.5">Surabaya Timur & Utara</strong>
                            MERR, Rungkut, Dharmahusada, Mulyorejo, Kenjeran, Perak.
                        </div>
                        <div class="p-2.5 rounded-xl bg-white dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700/50">
                            <strong class="text-blue-600 dark:text-cyan-400 block mb-0.5">Sidoarjo & Gresik</strong>
                            Waru, Sedati, Candi, Gedangan, Kebomas, Manyar, Driyorejo.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#002c5f] dark:bg-[#050a14] border-t border-transparent dark:border-slate-800/80 text-white py-16 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center flex-wrap gap-2.5 mb-6">
                    @if($logo = \App\Models\Setting::get('site_logo'))
                        <img src="{{ asset('storage/' . $logo) }}" alt="{{ \App\Models\Setting::get('site_name') }}" class="footer-logo-img h-7 sm:h-8 max-h-8 w-auto object-contain brightness-0 invert shrink-0" style="max-height: 32px; height: 32px; width: auto; max-width: 60px; object-fit: contain;">
                    @else
                        <img src="{{ asset('assets/images/hyundai_logo.png') }}" alt="Hyundai" class="footer-logo-img h-7 sm:h-8 max-h-8 w-auto object-contain brightness-0 invert shrink-0" style="max-height: 32px; height: 32px; width: auto; max-width: 60px; object-fit: contain;">
                    @endif
                    <div class="inline-flex items-center gap-2">
                        <span class="font-black text-base sm:text-lg tracking-wider uppercase leading-tight">{{ \App\Models\Setting::get('site_name', 'Hyundai') }}</span>
                        <!-- Verified Badge -->
                        <span class="inline-flex items-center justify-center shrink-0" title="Dealer Resmi Terverifikasi">
                            <svg class="w-4 h-4 verified-badge-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307z" fill="#00aad2"/>
                                <path d="M15.61 9.314a.75.75 0 00-1.22-.872l-3.236 4.53-1.624-1.624a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" fill="#ffffff"/>
                            </svg>
                        </span>
                    </div>
                </div>
                <p class="text-blue-200 max-w-md mb-8">
                    Dealer Resmi Hyundai melayani penjualan unit baru, layanan purna jual, dan suku cadang asli dengan standar pelayanan profesional.
                </p>
                <div class="flex space-x-4">
                    @if(optional($consultant)->instagram)
                        <a href="https://instagram.com/{{ $consultant->instagram }}" target="_blank" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-pink-600 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                        </a>
                    @endif
                    @if(optional($consultant)->facebook)
                        <a href="https://facebook.com/{{ $consultant->facebook }}" target="_blank" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-blue-600 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                        </a>
                    @endif
                    @if(optional($consultant)->tiktok)
                        <a href="https://tiktok.com/{{ '@' . $consultant->tiktok }}" target="_blank" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-black transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"/></svg>
                        </a>
                    @endif
                </div>
            </div>
            <div>
                <h4 class="font-bold text-lg mb-6 uppercase tracking-widest text-blue-100">Layanan</h4>
                <ul class="space-y-4 text-blue-200 text-sm font-medium">
                    <li><a href="{{ route('promo.index') }}" class="hover:text-amber-300 font-bold transition-colors">🏷️ Promo Diskon Hyundai 2026</a></li>
                    <li><a href="{{ route('testdrive.index') }}" class="hover:text-white transition-colors">🚗 Booking Test Drive Gratis</a></li>
                    <li><a href="{{ route('credit.simulation') }}" class="hover:text-white transition-colors">💳 Simulasi Kredit & DP Murah</a></li>
                    <li><a href="{{ route('pricelist') }}" class="hover:text-white transition-colors">📋 Daftar Harga OTR Surabaya</a></li>
                    <li><a href="{{ url('/#trade-in') }}" class="hover:text-white transition-colors">🔄 Tukar Tambah (Trade-in)</a></li>
                    <li><a href="{{ route('track.wa', ['text' => 'Halo, saya ingin tanya info Bengkel']) }}" class="hover:text-white transition-colors">🛠️ Bengkel & Suku Cadang</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-lg mb-6 uppercase tracking-widest text-blue-100">Kontak</h4>
                <p class="text-xs text-blue-300 uppercase tracking-widest mb-2">Jam Operasional:</p>
                <p class="text-sm font-bold mb-6">Senin - Minggu<br>08.00 - 20.00 WIB</p>
                <p class="text-xs text-blue-300 uppercase tracking-widest mb-2">Support Email:</p>
                <p class="text-sm font-bold text-white hover:text-blue-200 transition-colors">
                    <a href="mailto:{{ optional($consultant)->email ?? 'sales@hyundai.id' }}">{{ optional($consultant)->email ?? 'sales@hyundai.id' }}</a>
                </p>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16 pt-8 border-t border-white/10 text-center">
            <div class="text-xs text-blue-300 font-semibold mb-2">
                PT Gowa Modern Motor &bull; Dealer Resmi Hyundai HR Muhammad Surabaya
            </div>
            <p class="text-[11px] text-blue-200/80 max-w-2xl mx-auto mb-4">
                Jl. Mayjen HR. Muhammad No.35C, Sonokwijenan, Kec. Sukomanunggal, Surabaya, Jawa Timur 60189. Telp / WhatsApp Resmi: <a href="tel:081330135013" class="underline font-bold text-white">0813-3013-5013 (Nico)</a>.
            </p>
            <div class="flex flex-wrap justify-center items-center gap-6 text-xs text-blue-200 mb-6">
                <a href="{{ route('privacy.policy') }}" class="hover:text-white underline">Kebijakan Privasi (Privacy Policy)</a>
                <span>&bull;</span>
                <a href="{{ route('terms') }}" class="hover:text-white underline">Syarat & Ketentuan Layanan</a>
                <span>&bull;</span>
                <a href="{{ route('pricelist') }}" class="hover:text-white underline">Daftar Harga OTR</a>
                <span>&bull;</span>
                <a href="{{ route('testdrive.index') }}" class="hover:text-white underline">Test Drive Hyundai Surabaya</a>
                <span>&bull;</span>
                <a href="{{ route('credit.simulation') }}" class="hover:text-white underline">Simulasi Kredit</a>
                <span>&bull;</span>
                <a href="{{ route('promo.index') }}" class="hover:text-white underline">Promo Diskon 2026</a>
                <span>&bull;</span>
                <a href="{{ route('sitemap') }}" class="hover:text-white underline">Sitemap XML</a>
            </div>
            <div class="text-[10px] uppercase tracking-[0.2em] text-blue-400">
                &copy; {{ date('Y') }} {{ \App\Models\Setting::get('site_name', 'Hyundai Gowa Surabaya') }}. All Rights Reserved.
            </div>
        </div>
    </footer>

    <!-- Sticky Mobile Bottom Quick Action Bar (Over 85% traffic is mobile) -->
    <div x-data="{}" 
         style="padding-bottom: max(10px, env(safe-area-inset-bottom)); z-index: 55;" 
         class="md:hidden fixed bottom-0 left-0 right-0 bg-white/95 dark:bg-[#070d19]/95 backdrop-blur-md border-t border-gray-200 dark:border-slate-800 shadow-[0_-4px_25px_rgba(0,0,0,0.15)] px-3 pt-2 flex items-center justify-around pointer-events-auto">
        <a href="{{ route('track.wa', ['text' => 'Halo Nico (Sales Hyundai Surabaya), saya ingin info promo diskon dan simulasi cicilan terbarunya.']) }}" 
           class="flex flex-col items-center gap-0.5 text-emerald-600 font-bold text-[9px] uppercase tracking-wider py-1 px-1.5 hover:opacity-80 transition cursor-pointer">
            <span class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center shadow-md shadow-emerald-500/30 animate-pulse">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
            </span>
            <span>WhatsApp</span>
        </a>

        <a href="tel:081330135013" 
           class="flex flex-col items-center gap-0.5 text-gray-700 dark:text-gray-300 font-bold text-[9px] uppercase tracking-wider py-1 px-1.5 hover:opacity-80 transition cursor-pointer">
            <span class="w-8 h-8 rounded-full bg-slate-800 dark:bg-slate-700 text-white flex items-center justify-center shadow-md">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            </span>
            <span>Telepon</span>
        </a>

        <button @click="window.dispatchEvent(new CustomEvent('open-lead-modal'))" 
                onclick="window.dispatchEvent(new CustomEvent('open-lead-modal'))"
                type="button" 
                class="flex flex-col items-center gap-0.5 text-blue-600 dark:text-cyan-400 font-bold text-[9px] uppercase tracking-wider py-1 px-1.5 hover:opacity-80 transition cursor-pointer">
            <span class="w-8 h-8 rounded-full bg-blue-600 dark:bg-cyan-500 text-white flex items-center justify-center shadow-md shadow-blue-600/30">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 12V8H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h12v4"/><path d="M4 6v12a2 2 0 0 0 2 2h14v-4"/><path d="M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4z"/></svg>
            </span>
            <span>Klaim Promo</span>
        </button>

        <a href="#kredit" 
           onclick="document.getElementById('kredit')?.scrollIntoView({behavior: 'smooth'});"
           class="flex flex-col items-center gap-0.5 text-gray-700 dark:text-gray-300 font-bold text-[9px] uppercase tracking-wider py-1 px-1.5 hover:opacity-80 transition cursor-pointer">
            <span class="w-8 h-8 rounded-full bg-cyan-600 text-white flex items-center justify-center shadow-md">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect width="16" height="20" x="4" y="2" rx="2"/><line x1="8" x2="16" y1="6" y2="6"/><line x1="16" x2="16" y1="14" y2="18"/><path d="M16 10h.01"/><path d="M12 10h.01"/><path d="M8 10h.01"/><path d="M12 14h.01"/><path d="M8 14h.01"/><path d="M12 18h.01"/><path d="M8 18h.01"/></svg>
            </span>
            <span>Simulasi DP</span>
        </a>
    </div>

    <!-- High-Converting Lead Magnet Modal ("Klaim Promo Spesial Bulan Ini") -->
    <div x-data="{
            isOpen: false,
            name: '',
            whatsapp: '',
            carId: '{{ $cars->first()?->id }}',
            purchaseType: 'credit',
            isSubmitting: false,
            init() {
                window.addEventListener('open-lead-modal', () => { this.isOpen = true; });
                @if((bool) \App\Models\Setting::get('lead_modal_enabled', true))
                    // Auto-open after 25s if not closed
                    setTimeout(() => {
                        if (!sessionStorage.getItem('lead_modal_seen')) {
                            this.isOpen = true;
                            sessionStorage.setItem('lead_modal_seen', '1');
                        }
                    }, 25000);
                @endif
            },
            async submitLead() {
                if (!this.name || !this.whatsapp) {
                    alert('Mohon isi nama dan nomor WhatsApp Anda.');
                    return;
                }
                this.isSubmitting = true;
                try {
                    const res = await fetch('{{ route('lead.capture') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            name: this.name,
                            whatsapp: this.whatsapp,
                            car_id: this.carId,
                            purchase_type: this.purchaseType,
                            lead_type: 'promo_modal'
                        })
                    });
                    const data = await res.json();
                    if (data.wa_url) {
                        window.location.href = data.wa_url;
                    }
                } catch (e) {
                    // Fallback to direct WA
                    window.location.href = '{{ route('track.wa') }}';
                }
            }
         }"
         @open-lead-modal.window="isOpen = true"
         x-show="isOpen"
         x-cloak
         class="fixed inset-0 z-[120] flex items-center justify-center p-4 sm:p-6"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <!-- Overlay Backdrop -->
        <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" @click="isOpen = false"></div>

        <!-- Modal Dialog -->
        <div class="relative bg-white rounded-3xl overflow-hidden shadow-2xl w-full max-w-lg border border-gray-100 z-10"
             x-transition:enter="transition ease-out duration-400"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0">

            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-[#002c5f] to-blue-900 p-6 sm:p-8 text-white relative">
                <button @click="isOpen = false" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
                <span class="inline-block px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-400 text-slate-900 mb-2">
                    Promo Spesial Bulan Ini
                </span>
                <h3 class="text-xl sm:text-2xl font-black tracking-tight">Klaim Promo & Simulasi Cicilan</h3>
                <p class="text-xs text-blue-200 mt-1">Dapatkan diskon khusus, DP mulai 10%, bunga 0%, dan free aksesoris langsung dari Sales Consultant Nico.</p>
            </div>

            <!-- Modal Form Body -->
            <form @submit.prevent="submitLead" class="p-6 sm:p-8 space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" x-model="name" required placeholder="Contoh: Bpk. Budi Santoso"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:outline-none text-xs">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Nomor WhatsApp Aktif</label>
                    <input type="tel" x-model="whatsapp" required placeholder="Contoh: 081234567890"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:outline-none text-xs">
                    <span class="text-[10px] text-gray-400 mt-0.5 block">Simulasi cicilan & e-brosur akan dikirim via WhatsApp</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Model Pilihan</label>
                        <select x-model="carId" class="w-full px-3 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:outline-none text-xs bg-white">
                            @foreach($cars as $c)
                                <option value="{{ $c->id }}">{{ $c->name }} (Mulai Rp {{ number_format($c->price / 1000000, 0) }} Jt)</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Rencana Pembelian</label>
                        <select x-model="purchaseType" class="w-full px-3 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:outline-none text-xs bg-white">
                            <option value="credit">Kredit (DP Ringan / Bunga 0%)</option>
                            <option value="cash">Cash / Tunai</option>
                            <option value="trade_in">Tukar Tambah (Trade-In)</option>
                        </select>
                    </div>
                </div>

                <div class="pt-3">
                    <button type="submit" :disabled="isSubmitting"
                            class="w-full py-3.5 px-6 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-black uppercase tracking-wider text-xs flex items-center justify-center gap-2 shadow-lg shadow-emerald-600/30 transition disabled:opacity-50">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
                        <span x-text="isSubmitting ? 'Memproses Penawaran...' : 'Klaim Diskon & Chat Nico via WhatsApp'"></span>
                    </button>
                    <p class="text-[10px] text-center text-gray-400 mt-2">
                        Privasi data Anda aman. Konsultasi & test drive 100% gratis tanpa komitmen.
                    </p>
                </div>
            </form>
        </div>
    </div>

    <!-- Floating WhatsApp (Desktop) -->
    <a href="{{ route('track.wa') }}" class="hidden md:flex fixed bottom-8 right-8 z-50 bg-green-500 text-white p-4 rounded-full shadow-2xl hover:bg-green-600 transition-all transform hover:scale-110 items-center justify-center animate-bounce" title="Chat WhatsApp Sales">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
    </a>

    <!-- Video Popup Promotion -->
    @if($popupVideo && ($popupVideo->video_path || $popupVideo->external_video_url))
    @php
        $popupUrl = $popupVideo->video_path ? asset('storage/' . $popupVideo->video_path) : $popupVideo->external_video_url;
        $isYouTube = preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $popupUrl, $matches);
        $youtubeId = $isYouTube ? $matches[1] : null;
    @endphp
    <div x-data="{ 
            showPopup: false, 
            isMuted: false,
            isYoutube: {{ $isYouTube ? 'true' : 'false' }},
            init() {
                window.addEventListener('open-promo-video', () => {
                    this.showPopup = true;
                });
                if (!sessionStorage.getItem('dismissed_video_popup')) {
                    setTimeout(() => {
                        this.showPopup = true;
                    }, 4000);
                }
            },
            closePopup() {
                this.showPopup = false;
                sessionStorage.setItem('dismissed_video_popup', '1');
                if (!this.isYoutube && this.$refs.promoVideo) {
                    this.$refs.promoVideo.pause();
                }
            },
            toggleMute() {
                this.isMuted = !this.isMuted;
                if (this.$refs.promoVideo) {
                    this.$refs.promoVideo.muted = this.isMuted;
                }
            }
         }" 
         x-show="showPopup"
         x-cloak
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" @click="closePopup()"></div>

        <!-- Popup Content -->
        <div class="relative bg-white rounded-3xl overflow-hidden shadow-2xl w-full max-w-3xl transform transition-all"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 scale-90 translate-y-10"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0">
            
            <!-- Close Button -->
            <button @click="closePopup()" class="absolute top-4 right-4 z-20 bg-black/50 text-white p-2 rounded-full hover:bg-black transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>

            <!-- Video Container -->
            <div class="relative bg-black aspect-video">
                <template x-if="showPopup">
                    <div class="w-full h-full">
                        @if($isYouTube)
                            <iframe 
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/{{ $youtubeId }}?autoplay=1&mute=1&loop=1&playlist={{ $youtubeId }}&controls=1&rel=0&enablejsapi=1" 
                                title="{{ $popupVideo->title }}" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen>
                            </iframe>
                        @else
                            <video x-ref="promoVideo" 
                                   src="{{ $popupUrl }}" 
                                   class="w-full h-full object-contain"
                                   autoplay 
                                   loop 
                                   playsinline
                                   x-init="$nextTick(() => { 
                                       $el.play().catch(() => {
                                           $el.muted = true;
                                           $el.play();
                                           isMuted = true;
                                       });
                                   })"></video>
                            
                            <!-- Unmute Button (for non-youtube) -->
                            <button @click="toggleMute()" 
                                    class="absolute bottom-6 right-6 z-20 bg-white/20 backdrop-blur-md border border-white/30 text-white px-4 py-2 rounded-full flex items-center gap-2 hover:bg-white/40 transition-all text-[10px] font-bold uppercase tracking-widest">
                                <template x-if="isMuted">
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5L6 9H2v6h4l5 4V5z"/><line x1="23" y1="9" x2="17" y2="15"/><line x1="17" y1="9" x2="23" y2="15"/></svg>
                                        <span>Unmute</span>
                                    </div>
                                </template>
                                <template x-if="!isMuted">
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5L6 9H2v6h4l5 4V5z"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/></svg>
                                        <span>Mute</span>
                                    </div>
                                </template>
                            </button>
                        @endif
                    </div>
                </template>
            </div>

            <!-- Info Section -->
            <div class="p-6 bg-white flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="text-center sm:text-left">
                    <h4 class="text-xl font-black text-[#002c5f] uppercase tracking-tight">{{ $popupVideo->title ?? 'Promo Eksklusif' }}</h4>
                    <p class="text-gray-400 text-[10px] uppercase tracking-widest font-bold mt-1">Special Announcement</p>
                </div>
                <a href="{{ route('track.wa') }}" class="bg-[#002c5f] text-white px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-800 transition-all shadow-lg shadow-blue-900/20">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Floating AI Car Consultant Chatbot -->
    <livewire:ai-chat-widget />

    <!-- PWA Service Worker & Install App Prompt -->
    <div id="pwa-install-banner" class="fixed bottom-6 left-6 z-40 bg-white/95 backdrop-blur-md border border-gray-200 shadow-2xl rounded-2xl p-4 hidden flex-row items-center gap-4 max-w-sm transition-all duration-300">
        <div class="w-10 h-10 rounded-xl bg-[#002c5f] text-white flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
        </div>
        <div class="flex-grow min-w-0">
            <div class="text-xs font-black text-gray-900 truncate">Pasang Aplikasi Showroom</div>
            <div class="text-[10px] text-gray-500">Akses cepat & simulasi langsung di ponsel</div>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <button id="pwa-install-btn" class="px-3 py-1.5 bg-[#002c5f] hover:bg-blue-800 text-white rounded-lg text-[10px] font-black uppercase tracking-wider transition cursor-pointer">Install</button>
            <button id="pwa-close-btn" class="text-gray-400 hover:text-gray-600 text-sm p-1 cursor-pointer">&times;</button>
        </div>
    </div>

    <script>
        // Completely unregister any existing service workers and clear caches
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.getRegistrations().then(function(registrations) {
                for (var r of registrations) {
                    r.unregister();
                }
            });
        }
        if ('caches' in window) {
            caches.keys().then(function(keys) {
                keys.forEach(function(k) { caches.delete(k); });
            });
        }

        let deferredPrompt;
        const pwaBanner = document.getElementById('pwa-install-banner');
        const pwaBtn = document.getElementById('pwa-install-btn');
        const pwaClose = document.getElementById('pwa-close-btn');

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            if (pwaBanner) {
                pwaBanner.classList.remove('hidden');
                pwaBanner.classList.add('flex');
            }
        });

        if (pwaBtn) {
            pwaBtn.addEventListener('click', async () => {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    const { outcome } = await deferredPrompt.userChoice;
                    deferredPrompt = null;
                    if (pwaBanner) pwaBanner.classList.add('hidden');
                }
            });
        }

        if (pwaClose) {
            pwaClose.addEventListener('click', () => {
                if (pwaBanner) pwaBanner.classList.add('hidden');
            });
        }
    </script>

    <!-- Real-time Visitor Session Duration Tracker -->
    <script>
        (function() {
            const startTime = Date.now();
            const visitId = {{ session('current_visit_id') ?? 'null' }};

            function sendDuration() {
                if (!visitId) return;
                const durationSeconds = Math.max(5, Math.round((Date.now() - startTime) / 1000));

                const payload = JSON.stringify({
                    visit_id: visitId,
                    duration: durationSeconds
                });

                if (navigator.sendBeacon) {
                    const blob = new Blob([payload], { type: 'application/json' });
                    navigator.sendBeacon('{{ route('track.duration') }}', blob);
                } else {
                    fetch('{{ route('track.duration') }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: payload,
                        keepalive: true
                    }).catch(() => {});
                }
            }

            // Ping every 15 seconds while active
            setInterval(sendDuration, 15000);

            // Record duration on visibility change or page hide
            document.addEventListener('visibilitychange', function() {
                if (document.visibilityState === 'hidden') {
                    sendDuration();
                }
            });
            window.addEventListener('pagehide', sendDuration);
            window.addEventListener('beforeunload', sendDuration);
        })();
    </script>

    @livewireScripts
</body>
</html>
