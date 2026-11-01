<nav x-data="{ 
        mobileOpen: false, 
        isDark: document.documentElement.classList.contains('dark'),
        toggleTheme() {
            this.isDark = !this.isDark;
            if (this.isDark) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        }
     }" 
     class="fixed top-0 w-full z-50 bg-white/95 dark:bg-[#070d19]/95 backdrop-blur-xl border-b border-gray-100 dark:border-slate-800/80 py-3.5 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center gap-4 lg:gap-8">
        <!-- Logo -->
        <div class="flex items-center cursor-pointer select-none group shrink-0 mr-3 lg:mr-6" onclick="window.location='{{ url('/') }}'">
            @if($logo = \App\Models\Setting::get('site_logo'))
                <img src="{{ asset('storage/' . $logo) }}" alt="{{ \App\Models\Setting::get('site_name') }}" class="h-6 md:h-7.5 w-auto object-contain transition-transform group-hover:scale-105">
            @else
                <img src="{{ asset('assets/images/hyundai_logo.png') }}" alt="Hyundai" class="h-6 md:h-7.5 w-auto object-contain transition-transform group-hover:scale-105">
            @endif
            <div class="ml-2 md:ml-2.5 flex items-center gap-1.5 min-w-0">
                <span class="font-extrabold text-xs sm:text-sm md:text-sm lg:text-[15px] tracking-wider text-[#002c5f] dark:text-white uppercase truncate max-w-[130px] sm:max-w-[200px] md:max-w-none">
                    {{ \App\Models\Setting::get('site_name', 'Hyundai') }}
                </span>
                <!-- Verified Badge -->
                <span class="inline-flex items-center justify-center shrink-0" title="Dealer Resmi Terverifikasi">
                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4 transition-transform group-hover:scale-110 drop-shadow-sm" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307z" fill="#0072d8"/>
                        <path d="M15.61 9.314a.75.75 0 00-1.22-.872l-3.236 4.53-1.624-1.624a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" fill="#ffffff"/>
                    </svg>
                </span>
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

        <!-- Desktop Navigation Menu -->
        <div class="hidden md:flex items-center gap-6 lg:gap-7 text-xs lg:text-[13px] font-semibold uppercase tracking-wider lg:tracking-widest text-gray-500 dark:text-slate-300">
            <a href="{{ url('/#home') }}" class="hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors">Home</a>
            
            <!-- Dynamic Mega Menu (positioned relative to navbar) -->
            <div class="py-2" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                <button @click="open = !open" class="flex items-center gap-1 hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors focus:outline-none uppercase tracking-widest text-sm font-semibold">
                    <span>Models</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="transition-transform duration-300" :class="open ? 'rotate-180 text-[#002c5f] dark:text-cyan-400' : ''"><path d="m6 9 6 6 6-6"/></svg>
                </button>

                <!-- Mega Menu Content Panel -->
                <div x-show="open" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-350"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-250"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-4"
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

            <a href="{{ url('/#virtual-360') }}" class="hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors flex items-center gap-1">
                <span>360° Studio</span>
            </a>
            <a href="{{ url('/#ev-savings') }}" class="hover:text-cyan-600 dark:hover:text-cyan-300 transition-colors flex items-center gap-1 font-bold text-cyan-600 dark:text-cyan-400">
                <span>⚡</span>
                <span>Hemat EV</span>
            </a>
            <a href="{{ url('/#trade-in') }}" class="hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors">Tukar Tambah</a>
            <a href="{{ url('/#comparator') }}" class="hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors">Komparasi</a>
            <a href="{{ route('pricelist') }}" class="hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors {{ request()->routeIs('pricelist') ? 'text-[#002c5f] dark:text-cyan-400 font-bold' : '' }}">Pricelist</a>
            <a href="{{ url('/#faq') }}" class="hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors">FAQ</a>
            <a href="{{ url('/#consultant') }}" class="hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors">Consultant</a>
        </div>

        <!-- Action Buttons & Dark Mode Toggle -->
        <div class="flex items-center space-x-2.5 sm:space-x-3 md:space-x-3.5">
            <!-- Dark / Light Mode Switcher -->
            <button type="button" 
                @click="toggleTheme()"
                class="p-2 sm:p-2.5 rounded-full border border-gray-200 dark:border-slate-700 bg-gray-50/80 dark:bg-slate-800 text-slate-700 dark:text-amber-400 hover:scale-105 active:scale-95 transition-all focus:outline-none shadow-sm flex items-center justify-center cursor-pointer"
                :title="isDark ? 'Beralih ke Mode Terang' : 'Beralih ke Mode Gelap'">
                <!-- Sun Icon (Active in Dark Mode) -->
                <svg x-show="isDark" x-cloak class="w-4 h-4 text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/>
                </svg>
                <!-- Moon Icon (Active in Light Mode) -->
                <svg x-show="!isDark" class="w-4 h-4 text-slate-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
                </svg>
            </button>

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
                  <a href="{{ url('/#trade-in') }}" @click="mobileOpen = false" class="hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors py-2 border-b border-gray-50 dark:border-slate-800/50">Tukar Tambah</a>
                  <a href="{{ url('/#comparator') }}" @click="mobileOpen = false" class="hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors py-2 border-b border-gray-50 dark:border-slate-800/50">Komparasi Mobil</a>
                  <a href="{{ route('pricelist') }}" @click="mobileOpen = false" class="hover:text-[#002c5f] dark:hover:text-cyan-400 transition-colors py-2 border-b border-gray-50 dark:border-slate-800/50 {{ request()->routeIs('pricelist') ? 'text-[#002c5f] dark:text-cyan-400 font-bold' : '' }}">Pricelist</a>
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
