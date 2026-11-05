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

    <!-- Favicon -->
    @if($logo = \App\Models\Setting::get('site_logo'))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $logo) }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('assets/images/hyundai_logo.png') }}">
    @endif

    @php
        $pageTitle = "Daftar Harga OTR Hyundai Surabaya Terbaru 2026 - Dealer Resmi HR Muhammad";
        $pageDesc = "Pricelist harga mobil baru Hyundai OTR Surabaya 2026 terlengkap: Stargazer, Creta, Palisade, Santa Fe, IONIQ 5, IONIQ 6, KONA EV. Dapatkan promo diskon & simulasi kredit bersama Sales Nico 0813-3013-5013.";
        $pageKeywords = "daftar harga hyundai surabaya, pricelist hyundai surabaya 2026, harga otr hyundai stargazer surabaya, harga creta surabaya, promo kredit hyundai surabaya nico";
        $currentUrl = route('pricelist');
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

    <!-- Local SEO Geo Meta Tags -->
    <meta name="geo.region" content="ID-JI">
    <meta name="geo.placename" content="Surabaya">
    <meta name="geo.position" content="{{ $latitude }};{{ $longitude }}">
    <meta name="ICBM" content="{{ $latitude }}, {{ $longitude }}">

    <!-- Open Graph / Facebook / WhatsApp Preview -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $currentUrl }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDesc }}">
    <meta property="og:image" content="{{ $shareImage }}">
    <meta property="og:site_name" content="Hyundai Gowa HR Muhammad Surabaya">
    <meta property="og:locale" content="id_ID">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDesc }}">
    <meta name="twitter:image" content="{{ $shareImage }}">

    <!-- Structured Data: BreadcrumbList Schema -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Beranda",
          "item": "{{ url('/') }}"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "Daftar Harga OTR",
          "item": "{{ $currentUrl }}"
        }
      ]
    }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Outfit', sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Dotted Leader Line Spacing */
        .leader-line {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }

        .leader-text-left {
            background-color: white;
            padding-right: 8px;
            z-index: 10;
            position: relative;
            transition: background-color 0.3s ease;
        }

        .leader-text-right {
            background-color: white;
            padding-left: 8px;
            z-index: 10;
            position: relative;
            transition: background-color 0.3s ease;
        }

        .leader-dots {
            flex-grow: 1;
            border-bottom: 2px dotted #e5e7eb;
            height: 1px;
            margin: 0 4px;
            transform: translateY(4px);
        }

        /* Default: Hide Print Header on Screen view */
        .print-header-block {
            display: none;
        }

        /* High-Definition Print Stylesheet overrides */
        @media print {
            @page {
                size: A4 portrait;
                margin: 0 !important;
            }

            body {
                background-color: white !important;
                color: black !important;
                padding: 12mm 15mm 15mm 15mm !important;
                font-size: 11px !important;
            }

            nav, 
            footer, 
            .no-print,
            .floating-cta,
            .consultant-cta-card {
                display: none !important;
            }

            .print-header-block {
                display: block !important;
                border-bottom: 2px solid #002c5f !important;
                padding-bottom: 12px !important;
                margin-bottom: 20px !important;
            }

            .print-grid {
                display: grid !important;
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 12px !important;
            }

            .print-card-avoid {
                break-inside: avoid !important;
                page-break-inside: avoid !important;
                box-shadow: none !important;
                border: 1px solid #e5e7eb !important;
                background-color: white !important;
                border-radius: 0.75rem !important;
                padding: 12px !important;
            }

            .print-card-avoid-grid {
                display: grid !important;
                grid-template-columns: 3.8fr 8.2fr !important;
                gap: 10px !important;
                align-items: center !important;
            }

            .print-card-avoid img {
                max-height: 95px !important;
                width: auto !important;
                margin: 0 auto !important;
            }

            .print-card-avoid h3 {
                font-size: 14px !important;
                margin-top: 3px !important;
                margin-bottom: 6px !important;
                color: #002c5f !important;
            }

            .print-card-avoid .space-y-3 > * + * {
                margin-top: 3px !important;
            }
            .print-card-avoid .leader-text-left,
            .print-card-avoid .leader-text-right {
                font-size: 8px !important;
                white-space: nowrap !important;
                background-color: white !important;
                color: black !important;
            }

            .leader-dots {
                border-bottom: 1.5px dotted #9ca3af !important;
            }
        }

        /* Dark Mode Overrides */
        .dark body {
            background-color: #070d19 !important;
            color: #f1f5f9 !important;
        }
        .dark .print-card-avoid {
            background-color: #0c1527 !important;
            border-color: rgba(56, 189, 248, 0.15) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4) !important;
        }
        .dark .print-card-avoid:hover {
            border-color: rgba(56, 189, 248, 0.45) !important;
            box-shadow: 0 20px 50px rgba(0, 44, 95, 0.35) !important;
        }
        .dark .print-card-avoid h3 {
            color: #ffffff !important;
        }
        .dark .leader-text-left {
            background-color: #0c1527 !important;
            color: #cbd5e1 !important;
        }
        .dark .leader-text-right {
            background-color: #0c1527 !important;
            color: #38bdf8 !important;
        }
        .dark .leader-dots {
            border-bottom-color: rgba(255, 255, 255, 0.15) !important;
        }
        .dark header h1 {
            color: #ffffff !important;
        }
        .dark header p {
            color: #94a3b8 !important;
        }
        .dark .consultant-cta-card {
            background: linear-gradient(135deg, rgba(12, 21, 39, 0.95) 0%, rgba(15, 33, 64, 0.95) 100%) !important;
            border-color: rgba(56, 189, 248, 0.25) !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5) !important;
        }
        .dark .consultant-cta-card h3 {
            color: #ffffff !important;
        }
        .dark .consultant-cta-card p {
            color: #94a3b8 !important;
        }
    </style>
    @if($googleAdsId = config('services.google.ads_id'))
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleAdsId }}"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', '{{ $googleAdsId }}');
        </script>
    @endif
</head>

<body class="bg-white dark:bg-[#070d19] text-gray-900 dark:text-slate-100 antialiased overflow-x-hidden pt-24">

    <!-- Sticky Navbar component -->
    <x-navbar />

    <!-- Print Only Header (Visible only when PDF export / Print preview triggered) -->
    <div class="print-header-block max-w-7xl mx-auto px-6 text-center">
        <h1 class="text-2xl font-black text-[#002c5f] tracking-widest uppercase">HYUNDAI PRICELIST</h1>
        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-1">Harga OTR Surabaya & Wilayah Jawa Timur - Periode {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('F Y') }}</p>
    </div>

    <!-- Elegant, Integrated White / Dark Header -->
    <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-6 no-print">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 border-b border-gray-100 dark:border-slate-800 pb-8">
            <div class="max-w-2xl">
                <span class="text-[10px] font-black text-blue-600 dark:text-cyan-400 uppercase tracking-[0.2em] block mb-2">Official Price Sheet</span>
                <h1 class="text-3xl md:text-5xl font-black text-[#002c5f] dark:text-white tracking-tight uppercase leading-tight">
                    Daftar Harga OTR
                </h1>
                <p class="text-gray-500 dark:text-slate-300 text-xs md:text-sm font-semibold mt-3 leading-relaxed">
                    Daftar harga resmi kendaraan Hyundai terlengkap untuk wilayah Surabaya, Sidoarjo, Gresik, dan seluruh Provinsi Jawa Timur. Berlaku per <span class="text-[#002c5f] dark:text-cyan-400 font-bold">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('F Y') }}</span>.
                </p>
            </div>

            <!-- Sleek Minimalist Action triggers -->
            <div class="flex flex-row gap-3">
                <button onclick="window.print()" class="bg-[#002c5f] dark:bg-cyan-500 dark:text-slate-950 text-white hover:bg-blue-900 dark:hover:bg-cyan-400 px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-wider transition-all shadow-sm flex items-center justify-center gap-2 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><path d="M6 9V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v5"/><rect width="12" height="8" x="6" y="14" rx="1" ry="1"/></svg>
                    Cetak / PDF
                </button>
                @if($consultant)
                    <a href="{{ route('track.wa', ['text' => 'Halo Mas ' . $consultant->name . ', saya ingin bertanya simulasi kredit / promo diskon harga pricelist terupdate']) }}" class="border border-green-500 text-green-500 hover:bg-green-50/50 dark:hover:bg-green-950/20 px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-wider transition-all flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
                        Konsultasi WA
                    </a>
                @endif
            </div>
        </div>
    </header>

    <!-- Main dynamic Grid content list -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 print-grid">
            @foreach($cars as $car)
                <div class="print-card-avoid bg-white dark:bg-[#0c1527] rounded-[2.5rem] p-8 md:p-10 border border-gray-100/80 dark:border-slate-800 shadow-[0_8px_30px_rgb(0,0,0,0.02)] dark:shadow-[0_10px_30px_rgba(0,0,0,0.4)] hover:shadow-[0_20px_50px_rgba(0,44,95,0.06)] dark:hover:shadow-[0_20px_50px_rgba(0,44,95,0.35)] hover:border-blue-100/50 dark:hover:border-cyan-500/30 transition-all duration-500 flex flex-col justify-between group">
                    
                    <!-- Title block placed at the top-left, above both photo and variant list -->
                    <div class="mb-6">
                        <span class="text-[9px] font-black text-blue-600 dark:text-cyan-400 bg-blue-50/60 dark:bg-cyan-950/40 border border-transparent dark:border-cyan-500/20 px-2.5 py-1 rounded-md uppercase tracking-wider">
                            {{ $car->category }}
                        </span>
                        <h3 class="text-2xl md:text-3xl font-black text-[#002c5f] dark:text-white uppercase tracking-tight mt-2.5">
                            {{ $car->name }}
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center print-card-avoid-grid">
                        
                        <!-- Left Column: Large, floating transparent car profile image -->
                        <div class="md:col-span-5 flex justify-center items-center relative">
                            <!-- Subtle backdrop radiant glow -->
                            <div class="absolute w-40 h-40 bg-blue-500/5 dark:bg-cyan-500/10 rounded-full blur-2xl transition-transform duration-750 group-hover:scale-150"></div>
                            
                            @if($car->image)
                                <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" class="relative z-10 w-full h-auto max-h-[140px] md:max-h-[170px] object-contain transform hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="relative z-10 text-gray-300 dark:text-slate-600 py-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/></svg>
                                </div>
                            @endif
                        </div>

                        <!-- Right Column: Variant lists -->
                        <div class="md:col-span-7 flex flex-col justify-between h-full">
                            <!-- Variant Price List with Dotted Leaders -->
                            <div class="space-y-3">
                                @if($car->variants && count($car->variants) > 0)
                                    @foreach($car->variants as $variant)
                                        <div class="leader-line">
                                            <span class="leader-text-left text-xs md:text-sm font-bold text-gray-800 dark:text-slate-200 uppercase bg-white dark:bg-[#0c1527]">{{ $variant['name'] }}</span>
                                            <div class="leader-dots"></div>
                                            <span class="leader-text-right text-xs md:text-sm font-black text-[#002c5f] dark:text-cyan-400 whitespace-nowrap bg-white dark:bg-[#0c1527]">Rp {{ number_format($variant['price'], 0, ',', '.') }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="leader-line">
                                        <span class="leader-text-left text-xs md:text-sm font-bold text-gray-800 dark:text-slate-200 uppercase bg-white dark:bg-[#0c1527]">Standard</span>
                                        <div class="leader-dots"></div>
                                        <span class="leader-text-right text-xs md:text-sm font-black text-[#002c5f] dark:text-cyan-400 whitespace-nowrap bg-white dark:bg-[#0c1527]">Rp {{ number_format($car->price, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>

                    <!-- Bottom Row: Surcharges & Spek Link -->
                    <div class="mt-6 pt-6 border-t border-dashed border-gray-100 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="text-[9px] text-gray-400 dark:text-slate-400 font-bold uppercase tracking-wider leading-relaxed max-w-xl">
                            @if(str_contains(strtolower($car->name), 'cartenz x'))
                                <span>• Matte Color: +Rp 3.500.000 &nbsp;|&nbsp; • Captain Seat: +Rp 3.500.000</span>
                            @elseif(str_contains(strtolower($car->name), 'cartenz'))
                                <span>• Captain Seat: +Rp 3.500.000 &nbsp;|&nbsp; • Pilihan warna khusus & BBN tidak mengikat</span>
                            @elseif(str_contains(strtolower($car->name), 'creta n line') || str_contains(strtolower($car->name), 'creta'))
                                <span>• Two Tone: +Rp 3.000.000 &nbsp;|&nbsp; • Pilihan warna khusus & BBN tidak mengikat</span>
                            @elseif(str_contains(strtolower($car->name), 'santa fe'))
                                <span>• Matte Color: +Rp 3.500.000 &nbsp;|&nbsp; • Pilihan warna khusus & BBN tidak mengikat</span>
                            @elseif(str_contains(strtolower($car->name), 'kona'))
                                <span>• Two Tone: +Rp 3.000.000 &nbsp;|&nbsp; • Matte Color: +Rp 3.500.000</span>
                            @elseif(str_contains(strtolower($car->name), 'ioniq 5'))
                                <span>• Matte Color: +Rp 3.500.000 &nbsp;|&nbsp; • Garansi Baterai 8 Tahun</span>
                            @else
                                <span>• Pilihan warna khusus & BBN tidak mengikat</span>
                            @endif
                        </div>
                        
                        <a href="{{ route('car.show', $car->slug) }}" class="no-print border border-[#002c5f]/15 dark:border-cyan-500/30 hover:border-[#002c5f] dark:hover:border-cyan-400 text-[#002c5f] dark:text-cyan-400 hover:bg-[#002c5f] dark:hover:bg-cyan-500 hover:text-white dark:hover:text-slate-950 px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300 flex items-center justify-center gap-2 group w-full sm:w-auto">
                            Lihat Spek
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="transition-transform group-hover:translate-x-1"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    </div>

                </div>
            @endforeach
        </div>

        <!-- Dynamic Sales Lead CTA Banner Card -->
        @if($consultant)
            <div class="consultant-cta-card bg-gradient-to-tr from-[#002c5f]/5 to-indigo-500/5 dark:from-[#0c1527] dark:to-[#071328] border border-blue-100 dark:border-slate-800 rounded-[2.5rem] p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-8 mt-16 no-print">
                <div class="flex flex-col md:flex-row items-center gap-6 text-center md:text-left">
                    <div class="relative w-20 h-20 rounded-full overflow-hidden border-2 border-[#002c5f] dark:border-cyan-400 flex-shrink-0 shadow-lg">
                        @if($consultant->photo)
                            <img src="{{ asset('storage/' . $consultant->photo) }}" alt="{{ $consultant->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-[#002c5f] dark:bg-cyan-500 flex items-center justify-center text-white dark:text-slate-950 font-black text-xl">
                                {{ substr($consultant->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <span class="text-[9px] font-black text-blue-600 dark:text-cyan-400 uppercase tracking-widest block mb-1">Sales Advisor</span>
                        <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $consultant->name }}</h3>
                        <p class="text-xs text-gray-500 dark:text-slate-300 mt-1 font-semibold">{{ $consultant->office_address ?? $consultant->address }}</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto text-center">
                    <a href="{{ route('track.wa', ['text' => 'Halo ' . $consultant->name . ', saya ingin bertanya simulasi kredit/promo unit terupdate dari pricelist']) }}" class="bg-[#002c5f] dark:bg-cyan-500 dark:text-slate-950 text-white px-8 py-3.5 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-800 dark:hover:bg-cyan-400 transition-all shadow-xl flex items-center justify-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
                        Hubungi {{ $consultant->name }}
                    </a>
                </div>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-[#002c5f] dark:bg-[#040914] border-t border-transparent dark:border-slate-800 text-white py-16 no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex justify-center items-center mb-8">
                @if($logo = \App\Models\Setting::get('site_logo'))
                    <img src="{{ asset('storage/' . $logo) }}" alt="Hyundai" class="h-6 w-auto brightness-0 invert">
                @else
                    <img src="{{ asset('assets/images/hyundai_logo.png') }}" alt="Hyundai" class="h-6 w-auto brightness-0 invert">
                @endif
                <span class="ml-3 font-black text-lg tracking-wider uppercase text-white">{{ \App\Models\Setting::get('site_name', 'Hyundai') }}</span>
                <!-- Verified Badge -->
                <span class="inline-flex items-center justify-center shrink-0 ml-2" title="Dealer Resmi Terverifikasi">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307z" fill="#00aad2"/>
                        <path d="M15.61 9.314a.75.75 0 00-1.22-.872l-3.236 4.53-1.624-1.624a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" fill="#ffffff"/>
                    </svg>
                </span>
            </div>
            <p class="text-blue-200 dark:text-slate-400 text-[10px] mb-8 tracking-[0.2em] uppercase font-bold">&copy; {{ date('Y') }} {{ \App\Models\Setting::get('site_name', 'Hyundai Showroom') }}. Semua Hak Dilindungi.</p>
            <div class="flex justify-center gap-8">
                <a href="/" class="text-xs font-bold text-blue-100 dark:text-slate-300 hover:text-white transition-colors">Home</a>
                <a href="/#virtual-360" class="text-xs font-bold text-blue-100 dark:text-slate-300 hover:text-white transition-colors">360° Studio</a>
                <a href="{{ route('pricelist') }}" class="text-xs font-bold text-white transition-colors underline underline-offset-8 decoration-2">Pricelist</a>
                <a href="/#consultant" class="text-xs font-bold text-blue-100 dark:text-slate-300 hover:text-white transition-colors">Consultant</a>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
