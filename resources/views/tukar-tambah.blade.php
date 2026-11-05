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
        header img, nav img { max-height: 35px !important; height: 30px !important; width: auto !important; }
        header svg, nav svg { max-width: 28px !important; max-height: 28px !important; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Favicon -->
    @if($logo = \App\Models\Setting::get('site_logo'))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $logo) }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('assets/images/hyundai_logo.png') }}">
    @endif

    @php
        $pageTitle = "Tukar Tambah Mobil Hyundai Surabaya 2026 - Trade-In Semua Merk Harga Tertinggi | Dealer Resmi HR Muhammad";
        $pageDesc = "Program resmi tukar tambah (Trade-In) mobil lama semua merk (Toyota, Honda, Mitsubishi, Suzuki, dll) dengan mobil baru Hyundai di Surabaya. Taksiran harga tertinggi, inspeksi gratis ke rumah/kantor, dan langsung memotong DP mobil baru Anda.";
        $pageKeywords = "tukar tambah hyundai surabaya, trade in mobil hyundai surabaya, tukar tambah mobil bekas hyundai, trade in creta surabaya, trade in stargazer surabaya, dealer resmi hyundai hr muhammad nico";
        $currentUrl = url('/tukar-tambah');
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

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $currentUrl }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDesc }}">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="Hyundai Surabaya HR Muhammad">
    <meta property="og:image" content="{{ $shareImage }}">

    <!-- Local SEO Geo Meta Tags -->
    <meta name="geo.region" content="ID-JI">
    <meta name="geo.placename" content="Surabaya">
    <meta name="geo.position" content="{{ $latitude }};{{ $longitude }}">
    <meta name="ICBM" content="{{ $latitude }}, {{ $longitude }}">

    <!-- Schema.org Structured Data -->
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
          "name": "Tukar Tambah Mobil Hyundai Surabaya",
          "item": "{{ $currentUrl }}"
        }
      ]
    }
    </script>
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "AutoDealer",
      "name": "Hyundai Gowa HR Muhammad Surabaya - Layanan Trade-In",
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
      },
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
      "@@type": "FAQPage",
      "mainEntity": [
        {
          "@@type": "Question",
          "name": "Mobil merk apa saja yang bisa ditukar tambah dengan mobil baru Hyundai?",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "Semua merk dan tipe mobil lama Anda kami terima dengan senang hati! Mulai dari Toyota, Honda, Daihatsu, Mitsubishi, Suzuki, Nissan, Mazda, Wuling, hingga merk Eropa."
          }
        },
        {
          "@@type": "Question",
          "name": "Apakah mobil lama yang masih dalam masa kredit (leasing) bisa ditukar tambah?",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "Sangat bisa! Tim kami siap membantu proses over-kredit dan pelunasan sisa hutang leasing lama Anda secara aman dan transparan, sehingga selisih dananya langsung menjadi DP mobil Hyundai baru."
          }
        },
        {
          "@@type": "Question",
          "name": "Apakah ada biaya untuk inspeksi mobil lama ke rumah?",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "100% GRATIS! Tim appraiser resmi kami siap datang ke rumah atau kantor Anda di area Surabaya, Sidoarjo, dan Gresik tanpa dipungut biaya apapun."
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
    @include('partials.tracking-scripts')
</head>

<body class="bg-slate-50 dark:bg-[#070d19] text-gray-900 dark:text-gray-100 antialiased selection:bg-cyan-500 selection:text-white transition-colors duration-300">
    @include('partials.tracking-body')

    <x-navbar />

    <main class="pt-24 lg:pt-28 pb-20">
        <!-- Breadcrumb Header -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
            <nav class="flex text-xs text-gray-500 dark:text-gray-400 space-x-2">
                <a href="{{ url('/') }}" class="hover:text-blue-600 dark:hover:text-cyan-400 transition-colors">Beranda</a>
                <span>/</span>
                <span class="text-gray-900 dark:text-white font-semibold">Tukar Tambah (Trade-In)</span>
            </nav>
        </div>

        <!-- Hero Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#002c5f] via-[#091e3e] to-[#041124] text-white p-8 md:p-14 shadow-2xl border border-blue-900/40">
                <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-amber-500/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative z-10 max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-amber-500/10 border border-amber-400/30 text-amber-300 text-xs font-bold uppercase tracking-wider mb-4">
                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                        Program Resmi Trade-In Hyundai Surabaya
                    </div>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight leading-tight mb-4">
                        Tukar Tambah Mobil Lama <span class="bg-gradient-to-r from-amber-400 to-amber-200 bg-clip-text text-transparent">Harga Taksiran Tertinggi</span>
                    </h1>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-6">
                        Ubah mobil lama Anda (segala merk & kondisi) menjadi DP mobil baru Hyundai impian. Kami tawarkan appraisal transparan dengan harga kompetitif tertinggi di Surabaya, inspeksi gratis ke rumah, serta subsidi cashback ekstra.
                    </p>
                    <div class="flex flex-wrap gap-4 text-xs sm:text-sm font-semibold">
                        <div class="flex items-center gap-2 text-amber-200">
                            <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>Semua Merk Diterima</span>
                        </div>
                        <div class="flex items-center gap-2 text-amber-200">
                            <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>Inspeksi Gratis ke Rumah</span>
                        </div>
                        <div class="flex items-center gap-2 text-amber-200">
                            <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>Bisa untuk Mobil Masih Kredit</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content: Form & Flow -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left: Trade-In Valuation Form (Alpine.js) -->
                <div class="lg:col-span-7 bg-white dark:bg-[#0c1527] rounded-3xl p-6 sm:p-8 shadow-xl border border-gray-100 dark:border-slate-800"
                     x-data="{
                        brand: 'Toyota',
                        model: '',
                        year: '2020',
                        transmission: 'Automatic',
                        targetCar: 'STARGAZER Cartenz',
                        name: '',
                        phone: '',
                        submitWa() {
                            if (!this.model || !this.name || !this.phone) {
                                alert('Mohon lengkapi tipe mobil lama, nama, dan nomor WhatsApp Anda.');
                                return;
                            }
                            let msg = `Halo Mas Nico, saya ingin mengajukan Trade-In (Tukar Tambah) Mobil Lama:\n\n` +
                                      `• Mobil Lama: ${this.brand} ${this.model} (${this.year} - ${this.transmission})\n` +
                                      `• Ingin Tukar ke Mobil Baru: ${this.targetCar}\n` +
                                      `• Nama: ${this.name}\n` +
                                      `• WhatsApp: ${this.phone}\n\n` +
                                      `Mohon estimasi taksiran harga tertinggi dan info jadwal appraisal ke rumah. Terima kasih.`;
                            window.open(`https://wa.me/6281330135013?text=${encodeURIComponent(msg)}`, '_blank');
                        }
                     }">
                    
                    <div class="mb-6 pb-4 border-b border-gray-100 dark:border-slate-800">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="p-1 rounded bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            </span>
                            <h2 class="text-2xl font-black text-gray-900 dark:text-white">Formulir Taksiran Cepat Mobil Lama</h2>
                        </div>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-slate-400">Isi data spesifikasi mobil lama Anda di bawah ini untuk mendapatkan estimasi nilai taksiran awal dalam 15 menit.</p>
                    </div>

                    <div class="space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-300 mb-1.5">Merk Mobil Lama</label>
                                <select x-model="brand" class="w-full bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 rounded-2xl p-3.5 text-sm font-semibold focus:outline-none focus:border-amber-500">
                                    <option value="Toyota">Toyota</option>
                                    <option value="Honda">Honda</option>
                                    <option value="Daihatsu">Daihatsu</option>
                                    <option value="Mitsubishi">Mitsubishi</option>
                                    <option value="Suzuki">Suzuki</option>
                                    <option value="Wuling">Wuling</option>
                                    <option value="Nissan">Nissan</option>
                                    <option value="Mazda">Mazda</option>
                                    <option value="Lainnya">Merk Lainnya</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-300 mb-1.5">Model / Tipe Spesifik</label>
                                <input type="text" x-model="model" placeholder="Contoh: Avanza Veloz 1.5 / Brio E" class="w-full bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 rounded-2xl p-3.5 text-sm font-semibold focus:outline-none focus:border-amber-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-300 mb-1.5">Tahun Pembuatan</label>
                                <select x-model="year" class="w-full bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 rounded-2xl p-3.5 text-sm font-semibold focus:outline-none focus:border-amber-500">
                                    @for($y = date('Y'); $y >= 2010; $y--)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-300 mb-1.5">Transmisi</label>
                                <select x-model="transmission" class="w-full bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 rounded-2xl p-3.5 text-sm font-semibold focus:outline-none focus:border-amber-500">
                                    <option value="Automatic">Automatic / Matic</option>
                                    <option value="Manual">Manual</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-300 mb-1.5">Rencana Mobil Baru Hyundai yang Diminati</label>
                            <select x-model="targetCar" class="w-full bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 rounded-2xl p-3.5 text-sm font-semibold focus:outline-none focus:border-amber-500">
                                @foreach($cars as $car)
                                    <option value="{{ $car->name }}">{{ $car->name }} (Mulai Rp {{ number_format($car->price/1000000, 0, ',', '.') }} Jt)</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-300 mb-1.5">Nama Lengkap</label>
                                <input type="text" x-model="name" placeholder="Nama Anda" class="w-full bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 rounded-2xl p-3.5 text-sm font-semibold focus:outline-none focus:border-amber-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-300 mb-1.5">Nomor WhatsApp Aktif</label>
                                <input type="tel" x-model="phone" placeholder="0812xxxx" class="w-full bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 rounded-2xl p-3.5 text-sm font-semibold focus:outline-none focus:border-amber-500">
                            </div>
                        </div>

                        <button type="button" @click="submitWa()" class="w-full py-4 rounded-2xl font-black text-sm uppercase tracking-wider bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 shadow-xl shadow-amber-500/20 transition-all flex items-center justify-center gap-2 cursor-pointer mt-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            <span>Dapatkan Taksiran Harga Tertinggi Sekarang</span>
                        </button>
                    </div>
                </div>

                <!-- Right: Keunggulan & Step-by-Step -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-white dark:bg-[#0c1527] rounded-3xl p-6 sm:p-7 shadow-xl border border-gray-100 dark:border-slate-800">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">4 Alasan Tukar Tambah di Hyundai Surabaya</h3>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-xl bg-amber-100 dark:bg-amber-950/80 text-amber-700 dark:text-amber-300 flex items-center justify-center font-bold text-sm shrink-0">1</div>
                                <div>
                                    <h4 class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white">Taksiran Transparan & Tertinggi</h4>
                                    <p class="text-[11px] text-gray-500 dark:text-slate-400 mt-0.5">Penilaian berdasarkan kondisi riil pasar tanpa potongan tersembunyi.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-xl bg-amber-100 dark:bg-amber-950/80 text-amber-700 dark:text-amber-300 flex items-center justify-center font-bold text-sm shrink-0">2</div>
                                <div>
                                    <h4 class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white">Inspeksi Gratis ke Rumah Anda</h4>
                                    <p class="text-[11px] text-gray-500 dark:text-slate-400 mt-0.5">Appraiser resmi datang langsung ke lokasi Anda di Surabaya, Sidoarjo, dan Gresik.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-xl bg-amber-100 dark:bg-amber-950/80 text-amber-700 dark:text-amber-300 flex items-center justify-center font-bold text-sm shrink-0">3</div>
                                <div>
                                    <h4 class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white">Langsung Memotong Uang Muka (DP)</h4>
                                    <p class="text-[11px] text-gray-500 dark:text-slate-400 mt-0.5">Mobil lama langsung mengurangi total DP mobil Hyundai baru Anda.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-xl bg-amber-100 dark:bg-amber-950/80 text-amber-700 dark:text-amber-300 flex items-center justify-center font-bold text-sm shrink-0">4</div>
                                <div>
                                    <h4 class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white">Bantu Pelunasan Mobil Masih Kredit</h4>
                                    <p class="text-[11px] text-gray-500 dark:text-slate-400 mt-0.5">Bila mobil lama masih di leasing, kami bantu proses over-kredit dan pelunasannya.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kontak Konsultan Cepat -->
                    <div class="bg-gradient-to-br from-[#002c5f] to-blue-900 text-white rounded-3xl p-6 shadow-xl">
                        <span class="text-xs uppercase font-bold tracking-wider text-cyan-300">Konsultasi Trade-In 24 Jam</span>
                        <h4 class="text-lg font-black mt-1 mb-2">Ingin Hitung Selisih Tukar Tambah?</h4>
                        <p class="text-slate-200 text-xs mb-4">Konsultasikan langsung dengan Sales Consultant resmi kami Nico (0813-3013-5013).</p>
                        <a href="{{ route('track.wa', ['text' => 'Halo Mas Nico, saya mau tanya program tukar tambah mobil lama ke Hyundai baru di Surabaya.']) }}" target="_blank" class="w-full py-3 px-4 rounded-xl bg-cyan-400 hover:bg-cyan-300 text-slate-950 font-bold text-xs uppercase tracking-wider transition flex items-center justify-center gap-2">
                            <span>Chat WhatsApp Langsung</span>
                        </a>
                    </div>
                </div>

            </div>
        </section>

        <!-- Area Coverage Signal for Local SEO -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
            <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-[#0c1527] border border-gray-100 dark:border-slate-800">
                <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
                    <span class="text-blue-600 dark:text-cyan-400">📍</span>
                    Area Layanan Inspeksi & Pengantaran Unit Trade-In
                </h3>
                <p class="text-xs text-gray-500 dark:text-slate-400 mb-4 leading-relaxed">
                    Kami melayani appraisal mobil lama dan serah terima unit Hyundai baru ke seluruh penjuru Kota Surabaya dan sekitarnya:
                </p>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/60 font-semibold text-slate-700 dark:text-slate-300">
                        <strong class="text-blue-600 dark:text-cyan-400 block mb-0.5">Surabaya Barat</strong>
                        HR Muhammad, Citraland, Pakuwon, Wiyung, Sambikerep, Tandes.
                    </div>
                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/60 font-semibold text-slate-700 dark:text-slate-300">
                        <strong class="text-blue-600 dark:text-cyan-400 block mb-0.5">Surabaya Pusat & Selatan</strong>
                        Darmo, Basuki Rahmat, Gubeng, Tegalsari, Wonokromo, Jemursari.
                    </div>
                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/60 font-semibold text-slate-700 dark:text-slate-300">
                        <strong class="text-blue-600 dark:text-cyan-400 block mb-0.5">Surabaya Timur & Utara</strong>
                        MERR, Rungkut, Dharmahusada, Mulyorejo, Kenjeran, Perak.
                    </div>
                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/60 font-semibold text-slate-700 dark:text-slate-300">
                        <strong class="text-blue-600 dark:text-cyan-400 block mb-0.5">Sidoarjo & Gresik</strong>
                        Waru, Gedangan, Sedati, Candi, Kebomas, Manyar, Driyorejo.
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
