<nav x-data="{ 
        mobileOpen: false, 
        isDark: document.documentElement.classList.contains('dark'),
        toggleTheme() {
            this.isDark = !this.isDark;
            try {
                if (this.isDark) {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                }
            } catch (e) {
                if (this.isDark) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
        }
     }" 
     class="fixed top-0 w-full z-50 bg-white/95 dark:bg-[#070d19]/95 backdrop-blur-xl border-b border-gray-100 dark:border-slate-800/80 py-3.5 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center gap-4 lg:gap-8">
        <!-- Logo -->
        <div class="flex items-center cursor-pointer select-none group shrink-0 mr-3 lg:mr-6" onclick="window.location='{{ url('/') }}'">
            @if($logo = \App\Models\Setting::get('site_logo'))
                <img src="{{ asset('storage/' . $logo) }}" alt="{{ \App\Models\Setting::get('site_name') }}" width="60" height="30" style="max-height: 30px !important; height: 30px !important; width: auto !important; max-width: 140px !important; object-fit: contain;" class="h-6 md:h-7.5 w-auto object-contain transition-transform group-hover:scale-105">
            @else
                <img src="{{ asset('assets/images/hyundai_logo.png') }}" alt="Hyundai" width="53" height="30" style="max-height: 30px !important; height: 30px !important; width: 53px !important; max-width: 53px !important; object-fit: contain;" class="h-6 md:h-7.5 w-auto object-contain transition-transform group-hover:scale-105">
            @endif
            <div class="ml-2 md:ml-2.5 flex items-center gap-1.5 min-w-0">
                <span class="font-extrabold text-xs sm:text-sm md:text-sm lg:text-[15px] tracking-wider text-[#002c5f] dark:text-white uppercase truncate max-w-[150px] sm:max-w-[240px] md:max-w-none">
                    {{ \App\Models\Setting::get('site_name', 'Hyundai Gowa HR Muhammad') }}
                </span>
                @if(\App\Models\Setting::get('navbar_show_verified_badge', true))
                <!-- Verified Badge -->
                <span class="inline-flex items-center justify-center shrink-0" style="display:inline-flex; width:16px; height:16px; min-width:16px; max-width:16px;" title="Dealer Resmi Terverifikasi">
                    <svg width="16" height="16" style="width:16px !important; height:16px !important; min-width:16px !important; max-width:16px !important;" class="w-3.5 h-3.5 md:w-4 md:h-4 transition-transform group-hover:scale-110 drop-shadow-sm" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307z" fill="#0072d8"/>
                        <path d="M15.61 9.314a.75.75 0 00-1.22-.872l-3.236 4.53-1.624-1.624a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" fill="#ffffff"/>
                    </svg>
                </span>
                @endif
            </div>
        </div>

        @php
            $navCars = \App\Models\Car::where('is_available', true)->get()->groupBy('category');
            $categoryLabels = [
                'MPV' => 'MPV',
                'SUV' => 'SUV',
                'EV' => 'Electric Vehicle',
                'Crossover' => 'Crossover',
                'Luxury MPV' => 'Luxury MPV'
            ];
        @endphp

        <!-- Desktop Navigation Menu (Organized & Luxury Grouping) -->
        <div class="hidden md:flex items-center gap-4 lg:gap-6 text-xs lg:text-[13px] font-bold uppercase tracking-wider text-slate-700 dark:text-slate-200">
            <a href="{{ url('/#home') }}" class="hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors">Home</a>
            
            <!-- 1. Dynamic Models Mega Menu -->
            <div class="py-2" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                <button @click="open = !open" class="flex items-center gap-1 hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors focus:outline-none uppercase tracking-wider font-semibold">
                    <span>Models</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="transition-transform duration-300" :class="open ? 'rotate-180 text-[#002c5f] dark:text-cyan-400' : ''"><path d="m6 9 6 6 6-6"/></svg>
                </button>

                <!-- Mega Menu Content Panel -->
                <div x-show="open" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-3"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-3"
                     class="absolute left-0 right-0 top-full w-full pt-4 z-50">
                     
                     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                         <div class="bg-white dark:bg-[#0c1527] border border-gray-100 dark:border-slate-800 rounded-[2rem] shadow-2xl p-10 grid grid-cols-5 gap-8">
                             @foreach($categoryLabels as $key => $label)
                                @php $categoryCars = $navCars->get($key); @endphp
                                <div class="flex flex-col">
                                    <h4 class="text-[10px] font-black text-blue-600 dark:text-cyan-400 uppercase tracking-[0.2em] mb-4 pb-2 border-b border-gray-100 dark:border-slate-800">{{ $label }}</h4>
                                    <ul class="space-y-2">
                                        @if($categoryCars && $categoryCars->count() > 0)
                                            @foreach($categoryCars as $car)
                                                <li>
                                                    <a href="{{ route('car.show', $car->slug) }}" class="group flex flex-col hover:bg-blue-50/50 dark:hover:bg-slate-800/60 p-2 -mx-2 rounded-xl transition-all">
                                                        <span class="text-xs font-bold text-gray-900 dark:text-white group-hover:text-[#002c5f] dark:group-hover:text-cyan-300 transition-colors">{{ $car->name }}</span>
                                                        <span class="text-[9px] text-gray-400 dark:text-slate-400 font-semibold mt-0.5">Mulai Rp {{ number_format($car->price/1000000, 0, ',', '.') }} Jt</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        @else
                                            <li class="text-[9px] text-gray-400 dark:text-slate-500 italic px-1">Segera Hadir</li>
                                        @endif
                                    </ul>
                                </div>
                             @endforeach
                         </div>
                     </div>
                </div>
            </div>

            <!-- 2. Pricelist -->
            <a href="{{ route('pricelist') }}" class="hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors {{ request()->routeIs('pricelist') ? 'text-[#002c5f] dark:text-cyan-400 font-black' : '' }}">
                Pricelist
            </a>

            <!-- 3. Promo (With Glow Badge) -->
            <a href="{{ route('promo.index') }}" class="hover:text-amber-500 dark:hover:text-amber-400 transition-colors flex items-center gap-1.5 {{ request()->routeIs('promo.index') ? 'text-amber-500 font-black' : '' }}">
                <span>Promo</span>
                <span class="px-1.5 py-0.5 rounded-full text-[9px] font-black bg-amber-500 text-slate-950 shadow-xs">2026</span>
            </a>

            <!-- 4. Layanan Dropdown (Test Drive, Simulasi Kredit, Tukar Tambah) -->
            <div class="relative py-2" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                <button @click="open = !open" class="flex items-center gap-1 hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors focus:outline-none uppercase tracking-wider font-semibold {{ request()->routeIs('testdrive.*') || request()->routeIs('credit.*') ? 'text-[#002c5f] dark:text-cyan-400 font-black' : '' }}">
                    <span>Layanan</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="transition-transform duration-300" :class="open ? 'rotate-180 text-[#002c5f] dark:text-cyan-400' : ''"><path d="m6 9 6 6 6-6"/></svg>
                </button>

                <div x-show="open" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-250"
                     x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                     class="absolute top-full left-1/2 -translate-x-1/2 w-80 bg-white dark:bg-[#0c1527] border border-gray-100 dark:border-slate-800 rounded-2xl shadow-2xl p-2.5 z-50 normal-case tracking-normal">
                    
                    <a href="{{ route('testdrive.index') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/70 transition group">
                        <div class="p-2 rounded-xl bg-cyan-50 dark:bg-cyan-950/60 text-cyan-600 dark:text-cyan-400 group-hover:scale-105 transition-transform shrink-0">
                            <svg width="16" height="16" style="width:16px; height:16px;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div class="min-w-0">
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="text-xs font-bold text-gray-900 dark:text-white group-hover:text-cyan-600 dark:group-hover:text-cyan-400">Test Drive Mobil</span>
                                <span class="text-[9px] px-1.5 py-0.5 rounded bg-emerald-100 dark:bg-emerald-950/80 text-emerald-700 dark:text-emerald-300 font-bold">Gratis</span>
                            </div>
                            <p class="text-[11px] text-gray-500 dark:text-slate-400 mt-0.5 font-normal leading-tight">Diantar ke rumah atau kantor Anda</p>
                        </div>
                    </a>

                    <a href="{{ route('credit.simulation') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/70 transition group">
                        <div class="p-2 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 group-hover:scale-105 transition-transform shrink-0">
                            <svg width="16" height="16" style="width:16px; height:16px;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="min-w-0">
                            <span class="text-xs font-bold text-gray-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400">Simulasi Kredit & DP</span>
                            <p class="text-[11px] text-gray-500 dark:text-slate-400 mt-0.5 font-normal leading-tight">Hitung cicilan bulanan & paket bunga 0%</p>
                        </div>
                    </a>

                    <a href="{{ route('tradein.index') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/70 transition group">
                        <div class="p-2 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 group-hover:scale-105 transition-transform shrink-0">
                            <svg width="16" height="16" style="width:16px; height:16px;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </div>
                        <div class="min-w-0">
                            <span class="text-xs font-bold text-gray-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400">Tukar Tambah (Trade-In)</span>
                            <p class="text-[11px] text-gray-500 dark:text-slate-400 mt-0.5 font-normal leading-tight">Taksiran mobil lama harga tertinggi</p>
                        </div>
                    </a>

                    <a href="{{ route('service.index') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/70 transition group">
                        <div class="p-2 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-cyan-400 group-hover:scale-105 transition-transform shrink-0">
                            <svg width="16" height="16" style="width:16px; height:16px;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <div class="min-w-0">
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="text-xs font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-cyan-400">Bengkel & Service</span>
                                <span class="text-[9px] px-1.5 py-0.5 rounded bg-blue-100 dark:bg-blue-950 text-blue-700 dark:text-cyan-300 font-bold">Resmi</span>
                            </div>
                            <p class="text-[11px] text-gray-500 dark:text-slate-400 mt-0.5 font-normal leading-tight">Perawatan berkala & diagnosa EV</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- 5. Fitur Interaktif Dropdown (360 Studio, Hemat EV, Komparasi) -->
            <div class="relative py-2" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                <button @click="open = !open" class="flex items-center gap-1 hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors focus:outline-none uppercase tracking-wider font-semibold">
                    <span>Fitur</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="transition-transform duration-300" :class="open ? 'rotate-180 text-[#002c5f] dark:text-cyan-400' : ''"><path d="m6 9 6 6 6-6"/></svg>
                </button>

                <div x-show="open" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-250"
                     x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                     class="absolute top-full left-1/2 -translate-x-1/2 w-80 bg-white dark:bg-[#0c1527] border border-gray-100 dark:border-slate-800 rounded-2xl shadow-2xl p-2.5 z-50 normal-case tracking-normal">
                    
                    <a href="{{ url('/#virtual-360') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/70 transition group">
                        <div class="p-2 rounded-xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 group-hover:scale-105 transition-transform shrink-0">
                            <svg width="16" height="16" style="width:16px; height:16px;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"/></svg>
                        </div>
                        <div class="min-w-0">
                            <span class="text-xs font-bold text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400">360° Studio Visual</span>
                            <p class="text-[11px] text-gray-500 dark:text-slate-400 mt-0.5 font-normal leading-tight">Jelajahi interior & eksterior 3D</p>
                        </div>
                    </a>

                    <a href="{{ url('/#ev-savings') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/70 transition group">
                        <div class="p-2 rounded-xl bg-cyan-50 dark:bg-cyan-950/60 text-cyan-600 dark:text-cyan-400 group-hover:scale-105 transition-transform shrink-0">
                            <span class="text-sm">⚡</span>
                        </div>
                        <div class="min-w-0">
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="text-xs font-bold text-gray-900 dark:text-white group-hover:text-cyan-600 dark:group-hover:text-cyan-400">Kalkulator EV</span>
                                <span class="text-[9px] px-1.5 py-0.5 rounded bg-cyan-100 dark:bg-cyan-950/80 text-cyan-700 dark:text-cyan-300 font-bold">Hemat 83%</span>
                            </div>
                            <p class="text-[11px] text-gray-500 dark:text-slate-400 mt-0.5 font-normal leading-tight">Bandingkan biaya bensin vs listrik</p>
                        </div>
                    </a>

                    <a href="{{ url('/#comparator') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/70 transition group">
                        <div class="p-2 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 group-hover:scale-105 transition-transform shrink-0">
                            <svg width="16" height="16" style="width:16px; height:16px;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <div class="min-w-0">
                            <span class="text-xs font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400">Komparasi Mobil</span>
                            <p class="text-[11px] text-gray-500 dark:text-slate-400 mt-0.5 font-normal leading-tight">Adu fitur & spek 2 mobil Hyundai</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- 6. Info & Bantuan Dropdown (FAQ, Consultant, News) -->
            <div class="relative py-2" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                <button @click="open = !open" class="flex items-center gap-1 hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors focus:outline-none uppercase tracking-wider font-semibold">
                    <span>Info</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="transition-transform duration-300" :class="open ? 'rotate-180 text-[#002c5f] dark:text-cyan-400' : ''"><path d="m6 9 6 6 6-6"/></svg>
                </button>

                <div x-show="open" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-250"
                     x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                     class="absolute top-full right-0 w-72 bg-white dark:bg-[#0c1527] border border-gray-100 dark:border-slate-800 rounded-2xl shadow-2xl p-2.5 z-50 normal-case tracking-normal">
                    
                    <a href="{{ url('/#faq') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/70 transition group">
                        <span class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs shrink-0 group-hover:scale-105 transition-transform">❓</span>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-cyan-400">Tanya Jawab (FAQ)</div>
                            <div class="text-[11px] text-gray-500 dark:text-slate-400 font-normal leading-tight">Pertanyaan umum seputar unit & EV</div>
                        </div>
                    </a>

                    <a href="{{ url('/#consultant') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/70 transition group">
                        <span class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs shrink-0 group-hover:scale-105 transition-transform">👤</span>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-cyan-400">Profil Sales Resmi</div>
                            <div class="text-[11px] text-gray-500 dark:text-slate-400 font-normal leading-tight">Konsultan Hyundai HR Muhammad</div>
                        </div>
                    </a>

                    <a href="{{ route('posts.index') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/70 transition group">
                        <span class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs shrink-0 group-hover:scale-105 transition-transform">📰</span>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-cyan-400">Berita & Tips</div>
                            <div class="text-[11px] text-gray-500 dark:text-slate-400 font-normal leading-tight">Artikel otomotif terupdate</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Action Buttons & Dark Mode Toggle -->
        <div class="flex items-center space-x-2.5 sm:space-x-3 md:space-x-3.5">
            <!-- Dual Theme Switcher: Versi Clean vs Dark -->
            <div class="inline-flex items-center p-0.5 sm:p-1 rounded-full bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-inner">
                <button type="button" 
                    @click="if (isDark) toggleTheme()"
                    class="flex items-center gap-1 sm:gap-1.5 px-2 sm:px-2.5 py-1 rounded-full text-[10px] sm:text-xs font-black transition-all cursor-pointer"
                    :class="!isDark ? 'bg-white text-[#002c5f] shadow-sm' : 'text-slate-400 hover:text-slate-200'"
                    title="Beralih ke Versi Clean (Terang)">
                    <svg width="14" height="14" style="width:14px; height:14px;" class="w-3.5 h-3.5 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/>
                    </svg>
                    <span class="hidden sm:inline">Clean</span>
                </button>
                <button type="button" 
                    @click="if (!isDark) toggleTheme()"
                    class="flex items-center gap-1 sm:gap-1.5 px-2 sm:px-2.5 py-1 rounded-full text-[10px] sm:text-xs font-black transition-all cursor-pointer"
                    :class="isDark ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-slate-950 font-black shadow-sm' : 'text-slate-500 hover:text-slate-800'"
                    title="Beralih ke Versi Dark (Gelap)">
                    <svg width="14" height="14" style="width:14px; height:14px;" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
                    </svg>
                    <span class="hidden sm:inline">Dark</span>
                </button>
            </div>

            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/admin') }}" class="hidden md:inline-block text-sm font-medium text-blue-600 dark:text-cyan-400 hover:underline">Admin</a>
                @else
                    <a href="{{ route('login') }}" class="hidden md:inline-block text-sm font-medium text-gray-400 hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors">Login</a>
                @endauth
            @endif
            
            <a href="{{ route('track.wa') }}" class="bg-[#002c5f] dark:bg-cyan-500 dark:text-slate-950 text-white px-3.5 sm:px-5 md:px-6 py-2 md:py-2.5 rounded-full text-[10px] md:text-sm font-bold hover:bg-blue-800 dark:hover:bg-cyan-400 transition-all shadow-lg whitespace-nowrap">
                Hubungi Kami
            </a>

            <!-- Mobile Hamburger Toggle -->
            <button @click="mobileOpen = !mobileOpen" class="md:hidden flex items-center justify-center p-2 text-gray-500 dark:text-slate-300 hover:text-[#002c5f] dark:hover:text-cyan-400 focus:outline-none rounded-xl hover:bg-gray-50 dark:hover:bg-slate-800 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" class="transition-transform duration-300" :class="mobileOpen ? 'rotate-90 text-[#002c5f] dark:text-cyan-400' : ''">
                    <path x-show="!mobileOpen" d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round"/>
                    <path x-show="mobileOpen" d="M18 6 6 18M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" x-cloak/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Drawer Panel (Slide-down with Blur) -->
    <div x-show="mobileOpen" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="md:hidden absolute top-full left-0 w-full bg-white/98 dark:bg-[#070d19]/98 backdrop-blur-2xl border-b border-gray-100 dark:border-slate-800 shadow-2xl p-6 z-40 max-h-[85vh] overflow-y-auto">
         
         <div class="space-y-6">
             <!-- Mobile Theme Switcher Banner -->
             <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700 shadow-sm">
                 <div class="flex items-center gap-2">
                     <span class="text-xs font-black uppercase tracking-wider text-slate-800 dark:text-slate-200">Tema Halaman</span>
                 </div>
                 <div class="inline-flex items-center p-1 rounded-full bg-slate-200/70 dark:bg-slate-900 border border-slate-300/60 dark:border-slate-700">
                     <button type="button" 
                         @click="if (isDark) toggleTheme()"
                         class="flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black transition-all cursor-pointer"
                         :class="!isDark ? 'bg-white text-[#002c5f] shadow-sm' : 'text-slate-400 hover:text-slate-200'">
                         <span>☀️ Clean</span>
                     </button>
                     <button type="button" 
                         @click="if (!isDark) toggleTheme()"
                         class="flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black transition-all cursor-pointer"
                         :class="isDark ? 'bg-gradient-to-r from-cyan-400 to-blue-500 text-slate-950 shadow-sm' : 'text-slate-500 hover:text-slate-800'">
                         <span>🌙 Dark</span>
                     </button>
                 </div>
             </div>

             <div class="flex flex-col space-y-3 text-sm font-bold uppercase tracking-wider text-gray-500 dark:text-slate-300">
                 <a href="{{ url('/#home') }}" @click="mobileOpen = false" class="hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors py-2 border-b border-gray-50 dark:border-slate-800/50">Home</a>
                 
                 <!-- Mobile Accordion for Models -->
                 <div x-data="{ expanded: false }" class="py-2 border-b border-gray-50 dark:border-slate-800/50">
                     <button @click="expanded = !expanded" class="w-full flex justify-between items-center uppercase tracking-wider font-bold text-gray-500 dark:text-slate-300 hover:text-[#002c5f] dark:hover:text-cyan-400 focus:outline-none">
                         <span>Models</span>
                         <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="transition-transform duration-300" :class="expanded ? 'rotate-180 text-[#002c5f] dark:text-cyan-400' : ''"><path d="m6 9 6 6 6-6"/></svg>
                     </button>
                     
                     <div x-show="expanded" x-cloak class="mt-4 pl-3 space-y-4" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                         @foreach($categoryLabels as $key => $label)
                             @php $categoryCars = $navCars->get($key); @endphp
                             <div class="border-l-2 border-gray-100 dark:border-slate-800 pl-3">
                                 <h5 class="text-[9px] font-black text-blue-600 dark:text-cyan-400 uppercase tracking-widest mb-2">{{ $label }}</h5>
                                 <div class="grid grid-cols-2 gap-2">
                                     @if($categoryCars && $categoryCars->count() > 0)
                                         @foreach($categoryCars as $car)
                                             <a href="{{ route('car.show', $car->slug) }}" @click="mobileOpen = false" class="bg-gray-50 dark:bg-slate-800/70 hover:bg-blue-50/50 dark:hover:bg-slate-700/60 p-2.5 rounded-xl flex flex-col">
                                                 <span class="text-[11px] font-bold text-gray-900 dark:text-white">{{ $car->name }}</span>
                                                 <span class="text-[8px] text-gray-400 dark:text-slate-400 font-semibold mt-0.5">Rp {{ number_format($car->price/1000000, 0, ',', '.') }} Jt</span>
                                             </a>
                                         @endforeach
                                     @else
                                         <span class="text-[9px] text-gray-400 italic">Segera Hadir</span>
                                     @endif
                                 </div>
                             </div>
                         @endforeach
                     </div>
                 </div>

                  <a href="{{ url('/#virtual-360') }}" @click="mobileOpen = false" class="hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors py-2 border-b border-gray-50 dark:border-slate-800/50">360° Studio</a>
                  <a href="{{ url('/#ev-savings') }}" @click="mobileOpen = false" class="text-cyan-600 dark:text-cyan-400 font-bold hover:text-cyan-700 transition-colors py-2 border-b border-gray-50 dark:border-slate-800/50 flex items-center justify-between">
                      <span class="flex items-center gap-1.5"><span class="text-cyan-500">⚡</span> Simulasi Hemat EV</span>
                      <span class="text-[9px] bg-cyan-100 dark:bg-cyan-950/60 text-cyan-800 dark:text-cyan-300 border border-cyan-300/30 px-2 py-0.5 rounded-full font-black uppercase">Hemat s/d 83%</span>
                  </a>
                  <a href="{{ route('tradein.index') }}" @click="mobileOpen = false" class="hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors py-2 border-b border-gray-50 dark:border-slate-800/50 flex items-center justify-between {{ request()->routeIs('tradein.index') ? 'text-[#002c5f] dark:text-cyan-400 font-bold' : '' }}">
                      <span>🔄 Tukar Tambah (Trade-In)</span>
                      <span class="text-[9px] bg-amber-100 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300 border border-amber-300/30 px-2 py-0.5 rounded-full font-black uppercase">Harga Terbaik</span>
                  </a>
                  <a href="{{ route('service.index') }}" @click="mobileOpen = false" class="hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors py-2 border-b border-gray-50 dark:border-slate-800/50 flex items-center justify-between {{ request()->routeIs('service.index') ? 'text-[#002c5f] dark:text-cyan-400 font-bold' : '' }}">
                      <span>🔧 Bengkel & Service Resmi</span>
                      <span class="text-[9px] bg-blue-100 dark:bg-blue-950/60 text-blue-800 dark:text-cyan-300 px-2 py-0.5 rounded-full font-black uppercase">Booking</span>
                  </a>
                  <a href="{{ url('/#comparator') }}" @click="mobileOpen = false" class="hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors py-2 border-b border-gray-50 dark:border-slate-800/50">Komparasi Mobil</a>
                  <a href="{{ route('promo.index') }}" @click="mobileOpen = false" class="text-amber-600 dark:text-amber-400 font-bold hover:text-amber-700 transition-colors py-2 border-b border-gray-50 dark:border-slate-800/50 flex items-center justify-between">
                      <span>🏷️ Promo Diskon 2026</span>
                      <span class="text-[9px] bg-amber-100 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300 border border-amber-300/30 px-2 py-0.5 rounded-full font-black uppercase">Spesial</span>
                  </a>
                  <a href="{{ route('testdrive.index') }}" @click="mobileOpen = false" class="hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors py-2 border-b border-gray-50 dark:border-slate-800/50 flex items-center justify-between {{ request()->routeIs('testdrive.index') ? 'text-[#002c5f] dark:text-cyan-400 font-bold' : '' }}">
                      <span>🚗 Test Drive Mobil</span>
                      <span class="text-[9px] bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 px-2 py-0.5 rounded-full font-black uppercase">Gratis</span>
                  </a>
                  <a href="{{ route('credit.simulation') }}" @click="mobileOpen = false" class="hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors py-2 border-b border-gray-50 dark:border-slate-800/50 {{ request()->routeIs('credit.simulation') ? 'text-[#002c5f] dark:text-cyan-400 font-bold' : '' }}">Simulasi Kredit & DP</a>
                  <a href="{{ route('pricelist') }}" @click="mobileOpen = false" class="hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors py-2 border-b border-gray-50 dark:border-slate-800/50 {{ request()->routeIs('pricelist') ? 'text-[#002c5f] dark:text-cyan-400 font-bold' : '' }}">Pricelist OTR</a>
                  <a href="{{ url('/#faq') }}" @click="mobileOpen = false" class="hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors py-2 border-b border-gray-50 dark:border-slate-800/50">FAQ Mobil Listrik</a>
                  <a href="{{ url('/#gallery') }}" @click="mobileOpen = false" class="hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors py-2 border-b border-gray-50 dark:border-slate-800/50">Gallery</a>
                  <a href="{{ route('posts.index') }}" @click="mobileOpen = false" class="hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors py-2 border-b border-gray-50 dark:border-slate-800/50 {{ request()->routeIs('posts.*') ? 'text-[#002c5f] dark:text-cyan-400 font-bold' : '' }}">News</a>
                  <a href="{{ url('/#consultant') }}" @click="mobileOpen = false" class="hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors py-2">Consultant</a>
             </div>
             
             @if (Route::has('login'))
                 <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-slate-800">
                     @auth
                         <a href="{{ url('/admin') }}" @click="mobileOpen = false" class="text-xs font-bold text-blue-600 dark:text-cyan-400 uppercase tracking-wider">Admin Panel</a>
                     @else
                         <a href="{{ route('login') }}" @click="mobileOpen = false" class="text-xs font-bold text-gray-400 dark:text-slate-400 hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors uppercase tracking-wider">Login</a>
                     @endauth
                 </div>
             @endif
         </div>
    </div>
</nav>

<script>
    window.addEventListener('scroll', function() {
        const nav = document.querySelector('nav');
        if (nav) {
            if (window.scrollY > 50) {
                nav.classList.add('shadow-lg', 'py-2');
                nav.classList.remove('py-4');
            } else {
                nav.classList.remove('shadow-lg', 'py-2');
                nav.classList.add('py-4');
            }
        }
    });
</script>
