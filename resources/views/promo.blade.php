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
        $pageTitle = "Promo Mobil Hyundai Surabaya 2026 - Diskon, Bunga 0% & DP Ringan | Dealer Resmi";
        $pageDesc = "Daftar promo terbaru mobil Hyundai Surabaya tahun 2026. Diskon cashback besar, bunga 0%, paket DP mulai 10%, garansi baterai EV 8 tahun & bonus aksesoris kaca film original. Hubungi Sales Nico Hyundai HR Muhammad Surabaya.";
        $pageKeywords = "promo hyundai surabaya, diskon hyundai surabaya, promo stargazer surabaya, promo creta surabaya, promo palisade surabaya, promo ioniq surabaya, cashback hyundai surabaya";
        $currentUrl = url('/promo');
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

    <!-- Structured Data (JSON-LD): BreadcrumbList, AutoDealer & FAQPage -->
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
          "name": "Promo Hyundai Surabaya",
          "item": "{{ $currentUrl }}"
        }
      ]
    }
    </script>
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "AutoDealer",
      "name": "Hyundai Gowa HR Muhammad Surabaya - Promo Resmi",
      "url": "{{ $currentUrl }}",
      "telephone": "+6281330135013",
      "address": {
        "@@type": "PostalAddress",
        "streetAddress": "{{ $dealerAddress }}",
        "addressLocality": "Surabaya",
        "addressRegion": "Jawa Timur",
        "postalCode": "60189",
        "addressCountry": "ID"
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
          "name": "Apa saja promo mobil Hyundai terbaru di Surabaya bulan ini?",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "Promo spesial bulan ini meliputi program bunga 0% hingga 2 tahun, paket DP ringan mulai 10%, tambahan cashback subsidi tukar tambah (trade-in), serta gratis biaya servis dan suku cadang hingga 5 tahun / 75.000 KM."
          }
        },
        {
          "@@type": "Question",
          "name": "Apakah pembelian mobil listrik Hyundai mendapatkan promo garansi baterai?",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "Tentu! Setiap pembelian mobil listrik Hyundai (IONIQ 5, IONIQ 6, KONA Electric) mendapatkan garansi baterai resmi selama 8 Tahun atau 160.000 KM serta gratis home charger instalasi."
          }
        },
        {
          "@@type": "Question",
          "name": "Apakah bisa tukar tambah (trade-in) mobil lama segala merk dengan mobil baru Hyundai?",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "Bisa sekali! Kami menerima tukar tambah segala merk mobil lama Anda dengan taksiran harga tertinggi dan tambahan subsidi cashback trade-in khusus."
          }
        }
      ]
    }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Outfit', sans-serif; }
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
                <span class="text-gray-900 dark:text-white font-semibold">Promo Terbaru</span>
            </nav>
        </div>

        <!-- Hero Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#002c5f] via-[#001f44] to-[#041124] text-white p-8 md:p-14 shadow-2xl border border-blue-900/40">
                <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-amber-500/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative z-10 max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-amber-500/10 border border-amber-400/30 text-amber-300 text-xs font-bold uppercase tracking-wider mb-4">
                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                        Program Spesial Dealer Resmi Hyundai Surabaya 2026
                    </div>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight leading-tight mb-4">
                        Promo Diskon & Cashback <span class="bg-gradient-to-r from-amber-300 to-amber-500 bg-clip-text text-transparent">Mobil Baru Hyundai</span>
                    </h1>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-6">
                        Dapatkan penawaran harga terbaik, bunga 0%, DP super ringan, dan bonus aksesoris eksklusif hanya melalui Sales Resmi Dealer Hyundai Gowa HR Muhammad Surabaya.
                    </p>

                    <div class="flex flex-wrap gap-4 text-xs sm:text-sm font-semibold">
                        <div class="flex items-center gap-2 text-amber-200">
                            <svg class="w-5 h-5 text-amber-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>Bunga 0% s/d 2 Tahun</span>
                        </div>
                        <div class="flex items-center gap-2 text-amber-200">
                            <svg class="w-5 h-5 text-amber-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>Free Servis & Sparepart 5 Tahun</span>
                        </div>
                        <div class="flex items-center gap-2 text-amber-200">
                            <svg class="w-5 h-5 text-amber-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>Subsidi Trade-in Mobil Lama</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Grid Promo Mobil -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <h2 class="text-2xl sm:text-3xl font-black text-gray-900 dark:text-white">Daftar Paket Promo Model Hyundai</h2>
                <p class="text-gray-500 dark:text-gray-400 text-xs sm:text-sm mt-2">Pilih unit favorit Anda dan dapatkan rincian diskon terbaik hari ini.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($cars as $car)
                    <div class="bg-white dark:bg-[#0c1527] rounded-3xl overflow-hidden border border-gray-100 dark:border-slate-800 shadow-lg hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <!-- Header Card & Gambar -->
                            <div class="relative p-6 pb-2">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-500 text-slate-950 shadow-xs mb-3">
                                    Special Offer
                                </span>
                                <h3 class="text-xl font-black text-gray-900 dark:text-white">{{ $car->name }}</h3>
                                <p class="text-xs text-blue-600 dark:text-cyan-400 font-bold mt-0.5">Mulai Rp {{ number_format($car->price, 0, ',', '.') }}</p>

                                <div class="py-6 flex items-center justify-center">
                                    @if($car->image_url)
                                        <img src="{{ asset('storage/' . $car->image_url) }}" alt="{{ $car->name }}" class="h-32 object-contain hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="h-32 flex items-center justify-center text-gray-400 text-xs font-semibold">Foto Hyundai {{ $car->name }}</div>
                                    @endif
                                </div>
                            </div>

                            <!-- List Promo Benefit -->
                            <div class="px-6 pb-6 space-y-2.5 border-t border-gray-100 dark:border-slate-800/80 pt-4 text-xs text-gray-600 dark:text-slate-300">
                                <div class="flex items-center gap-2 font-medium">
                                    <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    <span>Paket DP Ringan mulai 10%</span>
                                </div>
                                <div class="flex items-center gap-2 font-medium">
                                    <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    <span>Promo Bunga 0% Tenor 1-2 Thn</span>
                                </div>
                                <div class="flex items-center gap-2 font-medium">
                                    <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    <span>Free Servis & Sparepart Resmi</span>
                                </div>
                                <div class="flex items-center gap-2 font-medium">
                                    <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    <span>Bonus Kaca Film Smith / Solargard Original</span>
                                </div>
                            </div>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="p-6 pt-0 space-y-2">
                            <a href="{{ route('track.wa', ['text' => "Halo Mas Nico, saya mau tanya promo diskon & cashback terbaik untuk mobil Hyundai {$car->name} di Surabaya. Mohon info rinciannya."]) }}" target="_blank" class="w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs uppercase tracking-wider flex items-center justify-center gap-2 transition shadow-md">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.072.376-.044c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.1.824z"/></svg>
                                <span>Ambil Promo Ini</span>
                            </a>
                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ route('credit.simulation', ['car_id' => $car->id]) }}" class="py-2 px-3 text-center rounded-xl bg-slate-100 dark:bg-slate-800 text-gray-700 dark:text-slate-300 font-bold text-[11px] hover:bg-slate-200 dark:hover:bg-slate-700 transition">
                                    Simulasi Kredit
                                </a>
                                <a href="{{ route('testdrive.index', ['car_id' => $car->id]) }}" class="py-2 px-3 text-center rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-cyan-400 font-bold text-[11px] hover:bg-blue-100 dark:hover:bg-blue-900/60 transition">
                                    Test Drive
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Garansi & Layanan Purna Jual Resmi -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
            <div class="bg-gradient-to-br from-[#002c5f] to-[#041d3d] text-white rounded-3xl p-8 md:p-12 shadow-2xl">
                <div class="max-w-3xl mb-8">
                    <span class="text-xs uppercase font-bold tracking-widest text-cyan-400">Peace of Mind</span>
                    <h2 class="text-2xl sm:text-3xl font-black mt-1">Jaminan Garansi & Perlindungan Resmi Hyundai</h2>
                    <p class="text-slate-300 text-xs sm:text-sm mt-2">Beli mobil baru Hyundai dengan rasa tenang melalui garansi terlengkap di kelasnya:</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-xs">
                    <div class="p-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xs">
                        <div class="text-2xl font-black text-cyan-300 mb-1">4 Tahun</div>
                        <div class="font-bold text-sm text-white mb-1">Garansi Mesin Resmi</div>
                        <p class="text-slate-300">Atau 100.000 KM garansi kendaraan menyeluruh dari Hyundai Motor Indonesia.</p>
                    </div>

                    <div class="p-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xs">
                        <div class="text-2xl font-black text-cyan-300 mb-1">5 Tahun</div>
                        <div class="font-bold text-sm text-white mb-1">Free Service & Parts</div>
                        <p class="text-slate-300">Atau 75.000 KM gratis jasa servis berkala & suku cadang original.</p>
                    </div>

                    <div class="p-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xs">
                        <div class="text-2xl font-black text-cyan-300 mb-1">8 Tahun</div>
                        <div class="font-bold text-sm text-white mb-1">Garansi Baterai EV</div>
                        <p class="text-slate-300">Atau 160.000 KM jaminan kesehatan baterai mobil listrik (IONIQ 5, 6 & KONA).</p>
                    </div>

                    <div class="p-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xs">
                        <div class="text-2xl font-black text-cyan-300 mb-1">24 Jam</div>
                        <div class="font-bold text-sm text-white mb-1">Emergency Roadside</div>
                        <p class="text-slate-300">Layanan derek darurat dan bantuan teknisi jalan raya gratis 24 jam.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    {{-- Footer --}}
    <footer class="bg-white dark:bg-[#040812] border-t border-gray-200 dark:border-slate-800 py-10 text-xs text-gray-500 dark:text-gray-400 text-center">
        <div class="max-w-7xl mx-auto px-4">
            <p class="font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-2">Dealer Resmi Hyundai Surabaya - HR Muhammad</p>
            <p class="mb-4">{{ $dealerAddress }}</p>
            <p>&copy; {{ date('Y') }} Hyundai Surabaya. Hak Cipta Dilindungi.</p>
        </div>
    </footer>
</body>
</html>
