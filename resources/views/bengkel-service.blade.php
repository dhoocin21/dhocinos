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
        $pageTitle = "Bengkel & Service Resmi Hyundai Surabaya - Booking Service Berkala & EV | Gowa HR Muhammad";
        $pageDesc = "Layanan bengkel resmi dan booking service mobil Hyundai di Surabaya (Gowa HR Muhammad). Teknisi bersertifikat global, suku cadang original Mobis, perawatan baterai EV, fasilitas ruang tunggu VIP & layanan Home Service ke rumah Anda.";
        $pageKeywords = "bengkel resmi hyundai surabaya, service hyundai surabaya, booking service hyundai hr muhammad, service berkala hyundai creta stargazer, service mobil listrik hyundai ioniq surabaya, bengkel hyundai gowa";
        $currentUrl = url('/bengkel-service');
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
          "name": "Bengkel & Service Resmi Hyundai Surabaya",
          "item": "{{ $currentUrl }}"
        }
      ]
    }
    </script>
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "AutoRepair",
      "name": "Bengkel Resmi Hyundai Gowa HR Muhammad Surabaya",
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
      "openingHoursSpecification": [
        {
          "@@type": "OpeningHoursSpecification",
          "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
          "opens": "08:00",
          "closes": "16:30"
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
      "@@type": "FAQPage",
      "mainEntity": [
        {
          "@@type": "Question",
          "name": "Berapa lama garansi jasa service dan spare part di bengkel resmi Hyundai Surabaya?",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "Setiap servis dan penggantian suku cadang asli Mobis di bengkel resmi Hyundai Gowa HR Muhammad mendapatkan garansi resmi hingga 20.000 KM atau 1 tahun."
          }
        },
        {
          "@@type": "Question",
          "name": "Apakah bengkel resmi Hyundai melayani service mobil listrik (EV)?",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "Ya! Bengkel kami dilengkapi fasilitas dedicated EV Bay, peralatan diagnosa komputer GDS-M mutakhir, serta teknisi bersertifikasi global untuk perawatan baterai tegangan tinggi IONIQ 5, IONIQ 6, IONIQ 9, dan KONA Electric."
          }
        },
        {
          "@@type": "Question",
          "name": "Apakah bisa booking service untuk teknisi datang ke rumah (Home Service)?",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "Bisa! Kami memiliki armada Hyundai Mobile Service yang siap datang langsung ke rumah atau kantor Anda untuk servis berkala ringan tanpa perlu mengantre di bengkel."
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
                <span class="text-gray-900 dark:text-white font-semibold">Bengkel & Service Resmi</span>
            </nav>
        </div>

        <!-- Hero Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#002c5f] via-[#041d3b] to-[#041124] text-white p-8 md:p-14 shadow-2xl border border-blue-900/40">
                <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative z-10 max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-500/10 border border-blue-400/30 text-blue-300 text-xs font-bold uppercase tracking-wider mb-4">
                        <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                        Bengkel & Pusat Perawatan Resmi Hyundai Surabaya
                    </div>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight leading-tight mb-4">
                        Service Berkala & Perawatan EV <span class="bg-gradient-to-r from-cyan-400 to-blue-300 bg-clip-text text-transparent">Standar Global Hyundai</span>
                    </h1>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-6">
                        Jaga performa maksimal dan masa garansi mobil Hyundai Anda bersama bengkel resmi Hyundai Gowa HR Muhammad Surabaya. Didukung peralatan komputer diagnostik terkini, teknisi tersertifikasi, dan 100% suku cadang asli Mobis.
                    </p>
                    <div class="flex flex-wrap gap-4 text-xs sm:text-sm font-semibold">
                        <div class="flex items-center gap-2 text-cyan-200">
                            <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>100% Suku Cadang Original Mobis</span>
                        </div>
                        <div class="flex items-center gap-2 text-cyan-200">
                            <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>Dedicated EV Bay & Battery Doctor</span>
                        </div>
                        <div class="flex items-center gap-2 text-cyan-200">
                            <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>Tersedia Hyundai Mobile Service</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content: Booking Form & Facilities -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left: Booking Service Form (Alpine.js) -->
                <div class="lg:col-span-7 bg-white dark:bg-[#0c1527] rounded-3xl p-6 sm:p-8 shadow-xl border border-gray-100 dark:border-slate-800"
                     x-data="{
                        serviceType: 'Service Berkala',
                        carModel: 'STARGAZER Cartenz',
                        plateNumber: '',
                        serviceDate: '',
                        serviceLocation: 'Bengkel HR Muhammad',
                        name: '',
                        phone: '',
                        submitService() {
                            if (!this.name || !this.phone || !this.serviceDate) {
                                alert('Mohon lengkapi nama, nomor WhatsApp, dan tanggal rencana service Anda.');
                                return;
                            }
                            let msg = `Halo Service Advisor Hyundai Surabaya, saya ingin Booking Jadwal Service:\n\n` +
                                      `• Jenis Layanan: ${this.serviceType}\n` +
                                      `• Model Kendaraan: ${this.carModel}\n` +
                                      `• Plat Nomor: ${this.plateNumber || '-'}\n` +
                                      `• Lokasi Pilihan: ${this.serviceLocation}\n` +
                                      `• Rencana Tanggal: ${this.serviceDate}\n` +
                                      `• Nama Pemilik: ${this.name}\n` +
                                      `• No. WhatsApp: ${this.phone}\n\n` +
                                      `Mohon konfirmasi ketersediaan slot service resmi. Terima kasih.`;
                            window.open(`https://wa.me/6281330135013?text=${encodeURIComponent(msg)}`, '_blank');
                        }
                     }">
                    
                    <div class="mb-6 pb-4 border-b border-gray-100 dark:border-slate-800">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="p-1.5 rounded-xl bg-blue-50 dark:bg-cyan-950/60 text-[#002c5f] dark:text-cyan-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
                            </span>
                            <h2 class="text-2xl font-black text-gray-900 dark:text-white">Formulir Booking Jadwal Service Resmi</h2>
                        </div>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-slate-400">Pesan slot service Anda terlebih dahulu untuk bebas antre dan jaminan ketersediaan mekanik & suku cadang.</p>
                    </div>

                    <div class="space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-300 mb-1.5">Jenis Perawatan</label>
                                <select x-model="serviceType" class="w-full bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 rounded-2xl p-3.5 text-sm font-semibold focus:outline-none focus:border-cyan-500">
                                    <option value="Service Berkala (Free Jasa/Part)">Service Berkala (Free Jasa / Part)</option>
                                    <option value="Perawatan & Health Check Baterai EV">Perawatan & Health Check Baterai EV</option>
                                    <option value="Ganti Oli Mesin & Filter">Ganti Oli Mesin & Filter</option>
                                    <option value="Pemeriksaan Rem & Kaki-Kaki">Pemeriksaan Rem & Kaki-Kaki</option>
                                    <option value="Perawatan AC & Kelistrikan">Perawatan AC & Kelistrikan</option>
                                    <option value="Perbaikan Umum (General Repair)">Perbaikan Umum (General Repair)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-300 mb-1.5">Model Mobil Hyundai</label>
                                <select x-model="carModel" class="w-full bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 rounded-2xl p-3.5 text-sm font-semibold focus:outline-none focus:border-cyan-500">
                                    @foreach($cars as $car)
                                        <option value="{{ $car->name }}">{{ $car->name }}</option>
                                    @endforeach
                                    <option value="Hyundai Model Lain">Model Hyundai Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-300 mb-1.5">Pilihan Lokasi Service</label>
                                <select x-model="serviceLocation" class="w-full bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 rounded-2xl p-3.5 text-sm font-semibold focus:outline-none focus:border-cyan-500">
                                    <option value="Bengkel HR Muhammad">Datang ke Bengkel HR Muhammad</option>
                                    <option value="Home Service ke Rumah / Kantor">Hyundai Mobile Service ke Rumah/Kantor</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-300 mb-1.5">Rencana Tanggal Service</label>
                                <input type="date" x-model="serviceDate" class="w-full bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 rounded-2xl p-3.5 text-sm font-semibold focus:outline-none focus:border-cyan-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-300 mb-1.5">Plat Nomor (Opsional)</label>
                                <input type="text" x-model="plateNumber" placeholder="Contoh: L 1234 AB" class="w-full bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 rounded-2xl p-3.5 text-sm font-semibold focus:outline-none focus:border-cyan-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-300 mb-1.5">Nama Pemilik</label>
                                <input type="text" x-model="name" placeholder="Nama Anda" class="w-full bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 rounded-2xl p-3.5 text-sm font-semibold focus:outline-none focus:border-cyan-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-300 mb-1.5">Nomor WhatsApp</label>
                                <input type="tel" x-model="phone" placeholder="0812xxxx" class="w-full bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 rounded-2xl p-3.5 text-sm font-semibold focus:outline-none focus:border-cyan-500">
                            </div>
                        </div>

                        <button type="button" @click="submitService()" class="w-full py-4 rounded-2xl font-black text-sm uppercase tracking-wider bg-[#002c5f] hover:bg-blue-900 text-white shadow-xl shadow-blue-900/20 transition-all flex items-center justify-center gap-2 cursor-pointer mt-4">
                            <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Konfirmasi Booking Service Bebas Antre</span>
                        </button>
                    </div>
                </div>

                <!-- Right: Bengkel Specs & VIP Amenities -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-white dark:bg-[#0c1527] rounded-3xl p-6 sm:p-7 shadow-xl border border-gray-100 dark:border-slate-800">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Fasilitas Bengkel Resmi HR Muhammad</h3>
                        <div class="space-y-3.5 text-xs">
                            <div class="flex items-center gap-3 p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60">
                                <span class="p-2 rounded-xl bg-cyan-100 dark:bg-cyan-950 text-cyan-700 dark:text-cyan-300">⚡</span>
                                <div>
                                    <strong class="text-slate-900 dark:text-white block font-bold">Dedicated EV Diagnostic Station</strong>
                                    <span class="text-gray-500 dark:text-slate-400">Peralatan scanner resmi baterai mobil listrik Hyundai</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60">
                                <span class="p-2 rounded-xl bg-blue-100 dark:bg-blue-950 text-blue-700 dark:text-blue-300">🛋️</span>
                                <div>
                                    <strong class="text-slate-900 dark:text-white block font-bold">Ruang Tunggu VIP Eksklusif</strong>
                                    <span class="text-gray-500 dark:text-slate-400">AC dingin, Free Wi-Fi kencang, sofa santai & coffee bar</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60">
                                <span class="p-2 rounded-xl bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300">🛡️</span>
                                <div>
                                    <strong class="text-slate-900 dark:text-white block font-bold">Garansi Suku Cadang Asli</strong>
                                    <span class="text-gray-500 dark:text-slate-400">Jaminan originalitas part Mobis dengan garansi resmi</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60">
                                <span class="p-2 rounded-xl bg-amber-100 dark:bg-amber-950 text-amber-700 dark:text-amber-300">🚐</span>
                                <div>
                                    <strong class="text-slate-900 dark:text-white block font-bold">Hyundai Mobile Service</strong>
                                    <span class="text-gray-500 dark:text-slate-400">Armada servis berkala langsung ke tempat Anda</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jam Operasional & Rute -->
                    <div class="bg-gradient-to-br from-[#0c1527] to-[#041124] border border-blue-900/40 text-white rounded-3xl p-6 shadow-xl">
                        <span class="text-xs uppercase font-bold tracking-wider text-cyan-400">Lokasi & Jam Kerja</span>
                        <h4 class="text-lg font-black mt-1 mb-2">Dealer Hyundai Gowa HR Muhammad</h4>
                        <p class="text-slate-300 text-xs mb-3 leading-relaxed">
                            Jl. Mayjen HR. Muhammad No.35C, Sonokwijenan, Kec. Sukomanunggal, Surabaya, Jawa Timur 60189
                        </p>
                        <div class="text-[11px] text-slate-300 space-y-1 mb-4 border-t border-slate-800 pt-3">
                            <div class="flex justify-between"><span>Senin - Jumat:</span><span class="font-bold text-white">08:00 - 16:30 WIB</span></div>
                            <div class="flex justify-between"><span>Sabtu:</span><span class="font-bold text-white">08:00 - 14:30 WIB</span></div>
                            <div class="flex justify-between"><span>Emergency Call:</span><span class="font-bold text-cyan-400">0813-3013-5013</span></div>
                        </div>
                        <a href="https://maps.app.goo.gl/wJk4zXpG8M8GzK2T6" target="_blank" class="w-full py-3 px-4 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs uppercase tracking-wider transition flex items-center justify-center gap-2">
                            <span>Petunjuk Arah Google Maps</span>
                        </a>
                    </div>
                </div>

            </div>
        </section>

        <!-- Google Maps Embed for Local SEO Dominance -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
            <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-[#0c1527] border border-gray-100 dark:border-slate-800">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span>🗺️</span>
                            Lokasi Bengkel & Showroom Resmi di Google Maps
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">Kunjungi langsung dealer resmi Hyundai HR Muhammad Surabaya untuk servis atau konsultasi unit.</p>
                    </div>
                    <a href="https://maps.app.goo.gl/wJk4zXpG8M8GzK2T6" target="_blank" class="px-4 py-2.5 rounded-xl bg-blue-50 dark:bg-cyan-950 text-blue-700 dark:text-cyan-400 font-bold text-xs hover:underline shrink-0">
                        Buka di Aplikasi Google Maps &rarr;
                    </a>
                </div>
                <div class="rounded-2xl overflow-hidden shadow-inner h-80 border border-slate-200 dark:border-slate-800">
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
