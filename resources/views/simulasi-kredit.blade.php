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
        $pageTitle = "Simulasi Kredit Mobil Hyundai Surabaya 2026 - Hitung DP & Cicilan Murah | Dealer Resmi";
        $pageDesc = "Kalkulator simulasi kredit mobil baru Hyundai di Surabaya. Hitung DP ringan mulai 10%, bunga 0%, dan angsuran bulanan fleksibel tenor hingga 7 tahun untuk Stargazer, Creta, Palisade, Santa Fe, IONIQ 5. Hubungi Sales Nico.";
        $pageKeywords = "simulasi kredit hyundai surabaya, cicilan mobil hyundai surabaya, paket kredit hyundai dp murah, kredit stargazer surabaya, kredit creta surabaya, leasing hyundai surabaya";
        $currentUrl = url('/simulasi-kredit');
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
          "name": "Simulasi Kredit Hyundai Surabaya",
          "item": "{{ $currentUrl }}"
        }
      ]
    }
    </script>
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "AutoDealer",
      "name": "Hyundai Gowa HR Muhammad Surabaya - Simulasi Kredit",
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
          "name": "Berapa persen minimal DP untuk kredit mobil Hyundai di Surabaya?",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "Paket DP ringan kami mulai dari 10% s/d 15% dari harga OTR kendaraan. Tersedia juga program subsidi DP khusus untuk model Stargazer dan Creta."
          }
        },
        {
          "@@type": "Question",
          "name": "Apakah tersedia promo kredit bunga 0% untuk mobil Hyundai?",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "Ya! Kami menyediakan paket kredit resmi Bunga 0% dengan tenor 1 hingga 2 tahun melalui mitra leasing resmi Hyundai Finance."
          }
        },
        {
          "@@type": "Question",
          "name": "Berapa lama tenor maksimal kredit yang bisa diambil?",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "Tenor kredit mobil Hyundai sangat fleksibel mulai dari 1 tahun (12 bulan) hingga maksimal 7 tahun (84 bulan)."
          }
        },
        {
          "@@type": "Question",
          "name": "Leasing apa saja yang bekerja sama dengan dealer resmi Hyundai Surabaya?",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "Kami bermitra resmi dengan leasing terkemuka seperti BCA Finance, Maybank Finance, Mandiri Utama Finance (MUF), CIMB Niaga Auto Finance, Shinhan Bank, dan Adira Finance."
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
        [x-cloak] { display: none !important; }
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
                <span class="text-gray-900 dark:text-white font-semibold">Simulasi Kredit</span>
            </nav>
        </div>

        <!-- Hero Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#002c5f] via-[#001f44] to-[#041124] text-white p-8 md:p-14 shadow-2xl border border-blue-900/40">
                <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative z-10 max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-cyan-500/10 border border-cyan-400/30 text-cyan-300 text-xs font-bold uppercase tracking-wider mb-4">
                        <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                        Kalkulator Pembiayaan Resmi 2026
                    </div>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight leading-tight mb-4">
                        Kalkulator Simulasi Kredit <span class="bg-gradient-to-r from-cyan-400 to-blue-300 bg-clip-text text-transparent">Hyundai Surabaya</span>
                    </h1>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-6">
                        Rencanakan kepemilikan mobil Hyundai idaman Anda dengan mudah. Hitung estimasi DP, bunga kompetitif, dan angsuran bulanan yang sesuai dengan anggaran keuangan Anda.
                    </p>

                    <div class="flex flex-wrap gap-4 text-xs sm:text-sm font-semibold">
                        <div class="flex items-center gap-2 text-cyan-200">
                            <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>DP Ringan Mulai 10%</span>
                        </div>
                        <div class="flex items-center gap-2 text-cyan-200">
                            <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>Tersedia Paket Bunga 0%</span>
                        </div>
                        <div class="flex items-center gap-2 text-cyan-200">
                            <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>Tenor Fleksibel s/d 7 Tahun</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Interactive Calculator Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16" 
            x-data="{
                cars: {{ json_encode($cars->map(fn($c) => ['id' => $c->id, 'name' => $c->name, 'price' => $c->price, 'image' => $c->image_url ? asset('storage/' . $c->image_url) : ''])) }},
                selectedCarId: {{ $selectedCar ? $selectedCar->id : ($cars->first()?->id ?? 1) }},
                dpPercent: 20,
                tenor: 36,
                insurance: 'all_risk',
                get currentCar() {
                    return this.cars.find(c => c.id == this.selectedCarId) || this.cars[0];
                },
                get dpAmount() {
                    return Math.round((this.dpPercent / 100) * this.currentCar.price);
                },
                get loanPrincipal() {
                    return Math.max(0, this.currentCar.price - this.dpAmount);
                },
                get interestRate() {
                    let t = parseInt(this.tenor);
                    if (t <= 12) return 0.030;
                    if (t <= 24) return 0.040;
                    if (t <= 36) return 0.048;
                    if (t <= 48) return 0.056;
                    if (t <= 60) return 0.065;
                    return 0.075;
                },
                get monthlyInstallment() {
                    let years = parseInt(this.tenor) / 12;
                    let totalLoan = this.loanPrincipal + (this.loanPrincipal * this.interestRate * years);
                    return Math.round(totalLoan / parseInt(this.tenor));
                },
                get totalDownPayment() {
                    // TDP = DP + Angsuran Pertama + Estimasi Biaya Admin/Asuransi
                    let adminFee = 3500000;
                    let insCost = Math.round(this.currentCar.price * 0.025);
                    return this.dpAmount + this.monthlyInstallment + adminFee + insCost;
                },
                formatRupiah(num) {
                    return 'Rp ' + (num || 0).toLocaleString('id-ID');
                },
                get waText() {
                    return `Halo Mas Nico, saya melakukan simulasi kredit di website untuk mobil Hyundai ${this.currentCar.name} (Harga OTR ${this.formatRupiah(this.currentCar.price)}). 
Detail simulasi:
- DP: ${this.dpPercent}% (${this.formatRupiah(this.dpAmount)})
- Tenor: ${this.tenor} Bulan (${this.tenor/12} Tahun)
- Estimasi Cicilan: ${this.formatRupiah(this.monthlyInstallment)} / bulan.
Mohon info promo diskon dan rincian leasing terbaiknya. Terima kasih.`;
                }
            }"
        >
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Calculator Inputs (Left) -->
                <div class="lg:col-span-7 bg-white dark:bg-[#0c1527] rounded-3xl p-6 sm:p-8 shadow-xl border border-gray-100 dark:border-slate-800 space-y-6">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white">Hitung Simulasi Cicilan Anda</h2>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Sesuaikan model mobil, uang muka (DP), dan tenor angsuran di bawah ini.</p>
                    </div>

                    <!-- 1. Pilih Mobil -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-slate-300 mb-2">Pilih Model Kendaraan</label>
                        <select x-model="selectedCarId" class="w-full text-sm font-semibold rounded-2xl border-gray-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-gray-900 dark:text-white py-3.5 px-4 focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                            <template x-for="c in cars" :key="c.id">
                                <option :value="c.id" x-text="`${c.name} - OTR ${formatRupiah(c.price)}`"></option>
                            </template>
                        </select>
                    </div>

                    <!-- 2. Pilihan DP (%) -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-slate-300">Uang Muka (DP): <span class="text-blue-600 dark:text-cyan-400 font-black text-sm" x-text="`${dpPercent}%`"></span></label>
                            <span class="text-xs font-bold text-gray-900 dark:text-white bg-blue-50 dark:bg-blue-950/60 px-2.5 py-1 rounded-lg border border-blue-200/50 dark:border-blue-800/50" x-text="formatRupiah(dpAmount)"></span>
                        </div>
                        <input type="range" min="10" max="50" step="5" x-model="dpPercent" class="w-full h-2 bg-gray-200 dark:bg-slate-700 rounded-lg appearance-none cursor-pointer accent-blue-600">
                        <div class="flex justify-between text-[10px] text-gray-400 mt-1 font-semibold">
                            <span>10% (DP Ringan)</span>
                            <span>20%</span>
                            <span>30%</span>
                            <span>40%</span>
                            <span>50%</span>
                        </div>
                    </div>

                    <!-- 3. Pilihan Tenor (Bulan) -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-slate-300 mb-2.5">Pilihan Tenor Angsuran</label>
                        <div class="grid grid-cols-3 sm:grid-cols-6 gap-2">
                            <template x-for="t in [12, 24, 36, 48, 60, 72]" :key="t">
                                <button 
                                    type="button" 
                                    @click="tenor = t"
                                    :class="tenor == t ? 'bg-[#002c5f] dark:bg-cyan-500 text-white dark:text-slate-950 font-black shadow-md border-transparent' : 'bg-slate-50 dark:bg-slate-800 text-gray-700 dark:text-slate-300 border-gray-200 dark:border-slate-700 hover:border-blue-300'"
                                    class="py-2.5 px-2 rounded-xl text-xs font-bold border transition text-center"
                                >
                                    <div x-text="`${t/12} Thn`"></div>
                                    <div class="text-[9px] opacity-70" x-text="`${t} Bln`"></div>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- 4. Pilihan Asuransi -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-slate-300 mb-2">Jenis Perlindungan Asuransi</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center gap-2 p-3 rounded-xl border border-gray-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 cursor-pointer">
                                <input type="radio" name="ins" value="all_risk" x-model="insurance" class="text-blue-600">
                                <span class="text-xs font-bold text-gray-900 dark:text-white">Full All Risk</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 rounded-xl border border-gray-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 cursor-pointer">
                                <input type="radio" name="ins" value="kombinasi" x-model="insurance" class="text-blue-600">
                                <span class="text-xs font-bold text-gray-900 dark:text-white">Kombinasi (All Risk + TLO)</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Calculation Result (Right) -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-gradient-to-br from-[#002c5f] via-[#041d3d] to-[#020b17] text-white rounded-3xl p-6 sm:p-8 shadow-2xl border border-blue-900/50 relative overflow-hidden">
                        <div class="relative z-10">
                            <span class="text-[11px] font-bold uppercase tracking-widest text-cyan-300">Estimasi Cicilan Bulanan</span>
                            
                            <div class="my-4">
                                <div class="text-3xl sm:text-4xl font-black text-white" x-text="formatRupiah(monthlyInstallment)"></div>
                                <span class="text-xs text-slate-300 font-medium">per bulan (Tenor <span x-text="`${tenor} Bulan`"></span>)</span>
                            </div>

                            <div class="space-y-2.5 pt-4 border-t border-white/10 text-xs">
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Model Kendaraan:</span>
                                    <span class="font-bold text-white" x-text="currentCar.name"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Harga OTR Surabaya:</span>
                                    <span class="font-bold text-white" x-text="formatRupiah(currentCar.price)"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Uang Muka (DP <span x-text="`${dpPercent}%`"></span>):</span>
                                    <span class="font-bold text-white" x-text="formatRupiah(dpAmount)"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Pokok Pinjaman:</span>
                                    <span class="font-bold text-white" x-text="formatRupiah(loanPrincipal)"></span>
                                </div>
                                <div class="flex justify-between pt-2 border-t border-white/10 text-cyan-300">
                                    <span class="font-semibold">Estimasi Total DP (TDP Pertama):</span>
                                    <span class="font-black text-sm" x-text="formatRupiah(totalDownPayment)"></span>
                                </div>
                            </div>

                            <!-- Tombol Ajukan WhatsApp -->
                            <div class="mt-6">
                                <a :href="`{{ route('track.wa') }}?text=${encodeURIComponent(waText)}`" target="_blank" class="w-full py-3.5 px-4 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-bold text-xs uppercase tracking-wider shadow-lg flex items-center justify-center gap-2 transition cursor-pointer">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.072.376-.044c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.1.824z"/></svg>
                                    <span>Konsultasikan Hitungan Ini via WA</span>
                                </a>
                                <p class="text-[10px] text-slate-400 text-center mt-2">*Simulasi bersifat estimasi. Konsultasikan untuk diskon cashback & subsidi DP resmi.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Mitra Leasing Resmi -->
                    <div class="bg-white dark:bg-[#0c1527] rounded-3xl p-6 shadow-xl border border-gray-100 dark:border-slate-800">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-slate-300 mb-3">Mitra Pembiayaan Resmi (Leasing)</h4>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mb-4">Pengajuan kredit aman, terdaftar OJK, dan proses cepat disetujui:</p>
                        <div class="grid grid-cols-3 gap-2 text-center text-xs font-bold text-gray-700 dark:text-gray-300">
                            <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-gray-100 dark:border-slate-700">BCA Finance</div>
                            <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-gray-100 dark:border-slate-700">Maybank</div>
                            <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-gray-100 dark:border-slate-700">Mandiri (MUF)</div>
                            <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-gray-100 dark:border-slate-700">CIMB Niaga</div>
                            <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-gray-100 dark:border-slate-700">Shinhan Bank</div>
                            <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-gray-100 dark:border-slate-700">Adira Finance</div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- Persyaratan Kredit Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <h2 class="text-2xl sm:text-3xl font-black text-gray-900 dark:text-white">Syarat Pengajuan Kredit Mobil Hyundai</h2>
                <p class="text-gray-500 dark:text-gray-400 text-xs sm:text-sm mt-2">Data dibantu sampai ACC (disetujui) oleh tim sales kami.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-[#0c1527] p-6 rounded-3xl border border-gray-100 dark:border-slate-800 shadow-sm">
                    <h3 class="text-base font-bold text-blue-600 dark:text-cyan-400 mb-3">Karyawan / Pegawai</h3>
                    <ul class="space-y-2 text-xs text-gray-600 dark:text-slate-300">
                        <li class="flex items-center gap-2">✓ Foto KTP Suami & Istri</li>
                        <li class="flex items-center gap-2">✓ Kartu Keluarga (KK) & NPWP</li>
                        <li class="flex items-center gap-2">✓ Slip Gaji 3 Bulan Terakhir</li>
                        <li class="flex items-center gap-2">✓ Rekening Koran / Tabungan 3 Bulan</li>
                        <li class="flex items-center gap-2">✓ Bukti Kepemilikan Rumah (PBB / Rek Listrik)</li>
                    </ul>
                </div>

                <div class="bg-white dark:bg-[#0c1527] p-6 rounded-3xl border border-gray-100 dark:border-slate-800 shadow-sm">
                    <h3 class="text-base font-bold text-emerald-600 dark:text-emerald-400 mb-3">Wiraswasta / Pengusaha</h3>
                    <ul class="space-y-2 text-xs text-gray-600 dark:text-slate-300">
                        <li class="flex items-center gap-2">✓ Foto KTP Suami & Istri</li>
                        <li class="flex items-center gap-2">✓ Kartu Keluarga (KK) & NPWP</li>
                        <li class="flex items-center gap-2">✓ Legalitas Usaha (NIB / SIUP / SKU)</li>
                        <li class="flex items-center gap-2">✓ Rekening Koran Usaha 3 Bulan Terakhir</li>
                        <li class="flex items-center gap-2">✓ Bukti Transaksi / Nota Usaha</li>
                    </ul>
                </div>

                <div class="bg-white dark:bg-[#0c1527] p-6 rounded-3xl border border-gray-100 dark:border-slate-800 shadow-sm">
                    <h3 class="text-base font-bold text-purple-600 dark:text-purple-400 mb-3">Perusahaan (PT / CV)</h3>
                    <ul class="space-y-2 text-xs text-gray-600 dark:text-slate-300">
                        <li class="flex items-center gap-2">✓ Akta Pendirian & Perubahan Terakhir</li>
                        <li class="flex items-center gap-2">✓ NIB, TDP, SIUP & NPWP Perusahaan</li>
                        <li class="flex items-center gap-2">✓ KTP Direksi & Komisaris</li>
                        <li class="flex items-center gap-2">✓ Rekening Koran Perusahaan 3 Bulan</li>
                        <li class="flex items-center gap-2">✓ Laporan Keuangan Singkat</li>
                    </ul>
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
