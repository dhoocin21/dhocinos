@props(['cars' => null])

@php
    $carList = $cars ?? \App\Models\Car::where('is_available', true)->get();

    $officialVrLinks = [
        'ioniq-5' => 'https://www.hyundai.com/id/en/find-a-car/ioniq-5/highlights',
        'creta' => 'https://www.hyundai.com/id/en/find-a-car/new-creta/highlights',
        'creta-n-line' => 'https://www.hyundai.com/id/en/find-a-car/creta-n-line/highlights',
        'stargazer-cartenz' => 'https://www.hyundai.com/id/en/find-a-car/stargazer-cartenz/highlights',
        'stargazer-cartenz-x' => 'https://www.hyundai.com/id/en/find-a-car/stargazer-cartenz-x/highlights',
        'stargazer' => 'https://www.hyundai.com/id/en/find-a-car/stargazer/highlights',
        'staria' => 'https://www.hyundai.com/id/en/find-a-car/the-new-staria/highlights',
        'santa-fe' => 'https://www.hyundai.com/id/en/find-a-car/all-new-santa-fe/highlights',
        'palisade' => 'https://www.hyundai.com/id/en/find-a-car/the-new-palisade/highlights',
        'palisade-hev' => 'https://www.hyundai.com/id/id/find-a-car/all-new-palisade-hybrid/highlights',
        'all-new-palisade-hybrid' => 'https://www.hyundai.com/id/id/find-a-car/all-new-palisade-hybrid/highlights',
        'kona-electric' => 'https://www.hyundai.com/id/en/find-a-car/all-new-kona-electric/highlights',
        'ioniq-9' => 'https://www.hyundai.com/id/en',
    ];

    $dimensionsMap = [
        'santa-fe' => [
            'length' => '4.830 mm',
            'width' => '1.900 mm',
            'height' => '1.720 mm',
            'ground_clearance' => '177 mm',
            'wheelbase' => '2.815 mm',
        ],
        'palisade' => [
            'length' => '4.995 mm',
            'width' => '1.975 mm',
            'height' => '1.750 mm',
            'ground_clearance' => '203 mm',
            'wheelbase' => '2.900 mm',
        ],
        'palisade-hev' => [
            'length' => '5.060 mm',
            'width' => '1.980 mm',
            'height' => '1.805 mm',
            'ground_clearance' => '203 mm',
            'wheelbase' => '2.970 mm',
        ],
        'all-new-palisade-hybrid' => [
            'length' => '5.060 mm',
            'width' => '1.980 mm',
            'height' => '1.805 mm',
            'ground_clearance' => '203 mm',
            'wheelbase' => '2.970 mm',
        ],
        'creta' => [
            'length' => '4.315 mm',
            'width' => '1.790 mm',
            'height' => '1.630 mm',
            'ground_clearance' => '200 mm',
            'wheelbase' => '2.610 mm',
        ],
        'creta-n-line' => [
            'length' => '4.315 mm',
            'width' => '1.790 mm',
            'height' => '1.630 mm',
            'ground_clearance' => '200 mm',
            'wheelbase' => '2.610 mm',
        ],
        'stargazer-cartenz' => [
            'length' => '4.460 mm',
            'width' => '1.780 mm',
            'height' => '1.695 mm',
            'ground_clearance' => '195 mm',
            'wheelbase' => '2.780 mm',
        ],
        'stargazer-cartenz-x' => [
            'length' => '4.495 mm',
            'width' => '1.815 mm',
            'height' => '1.710 mm',
            'ground_clearance' => '200 mm',
            'wheelbase' => '2.780 mm',
        ],
        'stargazer' => [
            'length' => '4.460 mm',
            'width' => '1.780 mm',
            'height' => '1.695 mm',
            'ground_clearance' => '195 mm',
            'wheelbase' => '2.780 mm',
        ],
        'staria' => [
            'length' => '5.253 mm',
            'width' => '1.997 mm',
            'height' => '1.990 mm',
            'ground_clearance' => '186 mm',
            'wheelbase' => '3.273 mm',
        ],
        'ioniq-5' => [
            'length' => '4.635 mm',
            'width' => '1.890 mm',
            'height' => '1.605 mm',
            'ground_clearance' => '160 mm',
            'wheelbase' => '3.000 mm',
        ],
        'kona-electric' => [
            'length' => '4.355 mm',
            'width' => '1.825 mm',
            'height' => '1.575 mm',
            'ground_clearance' => '151 mm',
            'wheelbase' => '2.660 mm',
        ],
        'ioniq-9' => [
            'length' => '5.060 mm',
            'width' => '1.980 mm',
            'height' => '1.790 mm',
            'ground_clearance' => '180 mm',
            'wheelbase' => '3.130 mm',
        ],
    ];

    $consultant = \App\Models\Consultant::first();
    $consultantPhone = $consultant?->formatted_phone ?? '';

    $carsData = $carList->map(function($car) use ($officialVrLinks, $dimensionsMap) {
        $gallery = [];
        if (!empty($car->images) && is_array($car->images)) {
            foreach ($car->images as $img) {
                $gallery[] = asset('storage/' . $img);
            }
        }
        $hero = $car->hero_image ? asset('storage/' . $car->hero_image) : ($car->image ? asset('storage/' . $car->image) : asset('assets/images/placeholder-car.png'));
        $thumb = $car->image ? asset('storage/' . $car->image) : $hero;

        // Angle sequence starting with hero banner followed by gallery photos
        $angles = array_values(array_unique(array_merge([$hero], $gallery)));

        $dims = $dimensionsMap[$car->slug] ?? [
            'length' => '4.500 mm',
            'width' => '1.800 mm',
            'height' => '1.650 mm',
            'ground_clearance' => '185 mm',
            'wheelbase' => '2.750 mm',
        ];

        return [
            'id' => $car->id,
            'name' => $car->name,
            'slug' => $car->slug,
            'category' => $car->category ?? 'Hyundai',
            'price' => 'Rp ' . number_format($car->price, 0, ',', '.'),
            'hero' => $hero,
            'thumb' => $thumb,
            'has3d' => ($car->slug === 'ioniq-5'),
            'angles' => $angles,
            'dimensions' => $dims,
            'detail_url' => route('car.show', $car->slug),
            'official_url' => $officialVrLinks[$car->slug] ?? 'https://www.hyundai.com/id/en',
        ];
    })->values();
@endphp

<section id="virtual-360" class="py-16 md:py-24 relative overflow-hidden transition-colors bg-white dark:bg-[#070d19] border-t border-b border-gray-100 dark:border-slate-800">
    <style>
        #virtual-360 .no-scrollbar::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }
        #virtual-360 .no-scrollbar {
            -ms-overflow-style: none !important;
            scrollbar-width: none !important;
        }
        model-viewer::part(default-progress-bar),
        #default-progress-bar {
            display: none !important;
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
        }
    </style>

    <!-- Ambient 3D studio light glows -->
    <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[350px] bg-blue-500/5 dark:bg-cyan-500/10 rounded-full blur-[150px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10" 
         x-data="{
             cars: {{ Js::from($carsData) }},
             selectedSlug: 'ioniq-5',
             angleIndex: 0,
             salesPhone: '{{ $consultantPhone }}',
             isDragging: false,
             dragStartX: 0,
             get activeCar() {
                 return this.cars.find(c => c.slug === this.selectedSlug) || this.cars[0];
             },
             selectCar(slug) {
                 this.selectedSlug = slug;
                 this.angleIndex = 0;
                 if (slug === 'ioniq-5') {
                     this.$nextTick(() => {
                         const mv = document.getElementById('ioniqModel');
                         if (mv) mv.cameraOrbit = '45deg 75deg 105%';
                     });
                 }
             },
             nextAngle() {
                 if (this.activeCar && this.activeCar.angles.length > 0) {
                     this.angleIndex = (this.angleIndex + 1) % this.activeCar.angles.length;
                 }
             },
             prevAngle() {
                 if (this.activeCar && this.activeCar.angles.length > 0) {
                     this.angleIndex = (this.angleIndex - 1 + this.activeCar.angles.length) % this.activeCar.angles.length;
                 }
             },
             handlePointerDown(e) {
                 this.isDragging = true;
                 this.dragStartX = e.clientX || (e.touches && e.touches[0].clientX) || 0;
             },
             handlePointerMove(e) {
                 if (!this.isDragging) return;
                 const currentX = e.clientX || (e.touches && e.touches[0].clientX) || 0;
                 const diff = currentX - this.dragStartX;
                 if (diff > 45) {
                     this.prevAngle();
                     this.dragStartX = currentX;
                 } else if (diff < -45) {
                     this.nextAngle();
                     this.dragStartX = currentX;
                 }
             },
             handlePointerUp() {
                 this.isDragging = false;
             },
              scrollPills(direction) {
                  const el = this.$refs.pillContainer;
                  if (!el) return;
                  const amount = direction === 'left' ? -350 : 350;
                  el.scrollBy({ left: amount, behavior: 'smooth' });
              },
              init() {
                  this.initPillDrag();
              },
              initPillDrag() {
                  const slider = this.$refs.pillContainer;
                  if (!slider) return;
                  let isDown = false;
                  let startX = 0;
                  let scrollLeft = 0;
                  let dragged = false;

                  slider.addEventListener('mousedown', (e) => {
                      isDown = true;
                      dragged = false;
                      slider.classList.add('cursor-grabbing');
                      startX = e.pageX - slider.offsetLeft;
                      scrollLeft = slider.scrollLeft;
                  });

                  window.addEventListener('mouseup', () => {
                      if (!isDown) return;
                      isDown = false;
                      slider.classList.remove('cursor-grabbing');
                      setTimeout(() => { dragged = false; }, 60);
                  });

                  slider.addEventListener('mousemove', (e) => {
                      if (!isDown) return;
                      e.preventDefault();
                      const x = e.pageX - slider.offsetLeft;
                      const walk = (x - startX) * 1.5;
                      if (Math.abs(walk) > 15) {
                          dragged = true;
                      }
                      slider.scrollLeft = scrollLeft - walk;
                  });

                  slider.addEventListener('click', (e) => {
                      if (dragged) {
                          e.preventDefault();
                          e.stopPropagation();
                      }
                  }, true);
              }
         }">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-8">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-cyan-500/10 border border-cyan-400/30 text-cyan-700 dark:text-cyan-300 text-[10px] font-black uppercase tracking-[0.25em] mb-3">
                <span class="w-2 h-2 rounded-full bg-cyan-500 dark:bg-cyan-400 animate-ping"></span>
                <span>Virtual Showroom & Dimensions HUD</span>
            </div>
            <h2 class="text-3xl md:text-5xl font-black text-slate-900 dark:text-white tracking-tight uppercase">
                360° Interactive & Studio Viewer
            </h2>
            <div class="h-1 w-20 bg-gradient-to-r from-cyan-400 to-blue-600 mx-auto rounded-full mt-4 mb-4"></div>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300">
                Pilih unit Hyundai favorit Anda dari pricelist untuk mengeksplorasi visual 3D interaktif 360°, spesifikasi dimensi resmi, dan ground clearance.
            </p>
        </div>

        <!-- Unit Selector Carousel / Pill Tabs (Strict No Scrollbar) -->
        <div class="mb-6 max-w-5xl mx-auto">
            <div class="flex items-center justify-between mb-3 text-xs text-slate-500 dark:text-slate-400 px-1">
                <span class="font-bold text-slate-800 dark:text-slate-300 flex items-center gap-2">
                    <svg class="w-4 h-4 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                    Pilih Unit Kendaraan:
                </span>
                <div class="flex items-center gap-2.5">
                    <span class="text-[11px] text-cyan-600 dark:text-cyan-400/90 hidden sm:inline">Geser mouse / klik panah ({{ count($carsData) }} Unit)</span>
                    <div class="flex items-center gap-1.5">
                        <button 
                            type="button" 
                            @click="scrollPills('left')" 
                            class="w-7 h-7 rounded-lg bg-slate-100 dark:bg-slate-900 border border-slate-300 dark:border-white/20 hover:border-cyan-500 text-slate-700 dark:text-slate-300 hover:text-cyan-600 dark:hover:text-cyan-300 flex items-center justify-center transition-all shadow-sm hover:scale-105 active:scale-95 cursor-pointer" 
                            title="Geser Kiri"
                            aria-label="Geser Kiri">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button 
                            type="button" 
                            @click="scrollPills('right')" 
                            class="w-7 h-7 rounded-lg bg-slate-100 dark:bg-slate-900 border border-slate-300 dark:border-white/20 hover:border-cyan-500 text-slate-700 dark:text-slate-300 hover:text-cyan-600 dark:hover:text-cyan-300 flex items-center justify-center transition-all shadow-sm hover:scale-105 active:scale-95 cursor-pointer" 
                            title="Geser Kanan"
                            aria-label="Geser Kanan">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Scrollable & Draggable Pill Bar -->
            <div 
                x-ref="pillContainer"
                class="flex items-center gap-2.5 overflow-x-auto pb-2 pt-1 no-scrollbar select-none cursor-grab active:cursor-grabbing scroll-smooth" 
                style="scrollbar-width: none; -ms-overflow-style: none;">
                <template x-for="car in cars" :key="car.slug">
                    <button 
                        type="button"
                        @click="selectCar(car.slug)"
                        class="flex-shrink-0 flex items-center gap-2.5 px-4 py-2.5 rounded-2xl text-xs font-bold transition-all duration-300 border relative group"
                        :class="selectedSlug === car.slug 
                            ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white dark:text-slate-950 border-cyan-400 shadow-lg shadow-cyan-500/25 scale-105 z-10' 
                            : 'bg-slate-100 dark:bg-slate-900/80 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-white/10 hover:border-cyan-500/50 hover:bg-slate-200/80 dark:hover:bg-slate-800/80 hover:text-slate-900 dark:hover:text-white'">
                        
                        <!-- Thumbnail preview -->
                        <div class="w-7 h-7 rounded-lg overflow-hidden bg-slate-200/80 dark:bg-black/30 flex items-center justify-center flex-shrink-0">
                            <img :src="car.thumb" :alt="car.name" class="w-full h-full object-contain p-0.5">
                        </div>

                        <!-- Car Name -->
                        <span x-text="car.name" class="whitespace-nowrap tracking-tight"></span>

                        <!-- 3D Badge for Ioniq 5 -->
                        <template x-if="car.has3d">
                            <span class="px-1.5 py-0.5 rounded text-[9px] font-black uppercase tracking-wider"
                                  :class="selectedSlug === car.slug ? 'bg-slate-950 text-cyan-300' : 'bg-cyan-100 dark:bg-cyan-500/20 text-cyan-800 dark:text-cyan-300 border border-cyan-300 dark:border-cyan-400/30'">
                                3D VR
                            </span>
                        </template>
                    </button>
                </template>
            </div>
        </div>

        <!-- 3D / Studio Viewer Canvas Container -->
        <div class="relative max-w-5xl mx-auto border border-slate-200 dark:border-white/10 rounded-[2.5rem] p-4 sm:p-7 shadow-xl dark:shadow-2xl bg-white dark:bg-[#0c1527] transition-colors">
            
            <!-- Top Controls & Status Bar -->
            <div class="flex flex-wrap items-center justify-between gap-4 pb-4 mb-4 border-b border-slate-200 dark:border-white/10 text-xs">
                <!-- Unit Name & Mode Badge -->
                <div class="flex items-center gap-3">
                    <span class="flex h-2.5 w-2.5 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75" :class="activeCar.has3d ? 'bg-cyan-400' : 'bg-emerald-400'"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5" :class="activeCar.has3d ? 'bg-cyan-400' : 'bg-emerald-400'"></span>
                    </span>
                    <div>
                        <span class="font-extrabold text-slate-900 dark:text-white text-sm sm:text-base mr-2" x-text="activeCar.name"></span>
                        <span class="text-[10px] bg-slate-100 dark:bg-white/10 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 px-2 py-0.5 rounded font-medium" x-text="activeCar.category"></span>
                    </div>
                    
                    <template x-if="activeCar.has3d">
                        <span class="text-[10px] bg-cyan-100 dark:bg-cyan-500/20 text-cyan-800 dark:text-cyan-300 border border-cyan-300 dark:border-cyan-400/40 px-2.5 py-0.5 rounded-full font-bold flex items-center gap-1">
                            <svg class="w-3 h-3 text-cyan-600 dark:text-cyan-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                            3D Interactive Mesh
                        </span>
                    </template>
                    <template x-if="!activeCar.has3d">
                        <span class="text-[10px] bg-emerald-100 dark:bg-emerald-500/20 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-400/40 px-2.5 py-0.5 rounded-full font-bold flex items-center gap-1">
                            <svg class="w-3 h-3 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            360° Studio Showcase
                        </span>
                    </template>
                </div>

                <!-- Interaction Hint / Status -->
                <div class="text-[11px] text-slate-500 dark:text-slate-400 flex items-center gap-2">
                    <span class="flex items-center gap-1.5 text-cyan-700 dark:text-cyan-300 font-bold">
                        <svg class="w-4 h-4 text-cyan-600 dark:text-cyan-400 animate-pulse" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg>
                        <span x-text="activeCar.has3d ? 'Sentuh & Geser untuk Memutar 360° Bebas' : 'Geser Kiri/Kanan untuk Memutar Sudut Unit'"></span>
                    </span>
                </div>
            </div>

            <!-- INTERACTIVE DIMENSIONS & GROUND CLEARANCE HUD -->
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-2 sm:gap-3 mb-5">
                <div class="bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl p-2.5 sm:p-3 text-center">
                    <span class="text-[10px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider block mb-0.5">Panjang</span>
                    <span class="text-sm sm:text-base font-black text-cyan-600 dark:text-cyan-300" x-text="activeCar.dimensions.length"></span>
                </div>
                <div class="bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl p-2.5 sm:p-3 text-center">
                    <span class="text-[10px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider block mb-0.5">Lebar</span>
                    <span class="text-sm sm:text-base font-black text-cyan-600 dark:text-cyan-300" x-text="activeCar.dimensions.width"></span>
                </div>
                <div class="bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl p-2.5 sm:p-3 text-center">
                    <span class="text-[10px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider block mb-0.5">Tinggi</span>
                    <span class="text-sm sm:text-base font-black text-cyan-600 dark:text-cyan-300" x-text="activeCar.dimensions.height"></span>
                </div>
                <div class="bg-amber-50 dark:bg-amber-500/10 border border-amber-300 dark:border-amber-400/30 rounded-2xl p-2.5 sm:p-3 text-center">
                    <span class="text-[10px] text-amber-700 dark:text-amber-300 font-bold uppercase tracking-wider block mb-0.5">Ground Clearance</span>
                    <span class="text-sm sm:text-base font-black text-amber-600 dark:text-amber-400" x-text="activeCar.dimensions.ground_clearance"></span>
                </div>
                <div class="col-span-2 sm:col-span-1 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl p-2.5 sm:p-3 text-center">
                    <span class="text-[10px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider block mb-0.5">Wheelbase</span>
                    <span class="text-sm sm:text-base font-black text-cyan-600 dark:text-cyan-300" x-text="activeCar.dimensions.wheelbase"></span>
                </div>
            </div>

            <!-- VIEWPORT SCREEN: 3D MODEL (IONIQ 5) OR STUDIO SHOWCASE (OTHER UNITS) -->
            <div class="w-full h-[380px] sm:h-[460px] md:h-[520px] rounded-2xl overflow-hidden relative bg-gradient-to-b from-slate-100 via-slate-50 to-slate-200 dark:from-slate-900/60 dark:to-black/90 flex items-center justify-center select-none border border-slate-200 dark:border-white/10 shadow-inner">
                
                <!-- 1. 3D Model Viewer for IONIQ 5 (Absolute inset-0 so it NEVER collapses) -->
                <div x-show="activeCar.has3d" class="absolute inset-0 w-full h-full" x-cloak>
                    <model-viewer
                        id="ioniqModel"
                        src="{{ asset('3d/ioniq5/scene.gltf') }}"
                        alt="Hyundai Ioniq 5 3D Model"
                        auto-rotate
                        auto-rotate-delay="1500"
                        rotation-per-second="20deg"
                        camera-controls
                        touch-action="none"
                        interaction-prompt="none"
                        shadow-intensity="1.5"
                        shadow-softness="0.8"
                        exposure="1.1"
                        camera-orbit="45deg 75deg 105%"
                        min-camera-orbit="auto auto 70%"
                        max-camera-orbit="auto auto 160%"
                        style="width: 100%; height: 100%; outline: none; cursor: grab;"
                    >
                        <div slot="progress-bar" style="display: none;"></div>
                    </model-viewer>
                </div>

                <!-- 2. Studio Showcase for Other Units (Interactive Turntable Drag) -->
                <div x-show="!activeCar.has3d" 
                     class="absolute inset-0 w-full h-full flex items-center justify-center cursor-ew-resize select-none"
                     @pointerdown="handlePointerDown($event)"
                     @pointermove="handlePointerMove($event)"
                     @pointerup="handlePointerUp()"
                     @pointerleave="handlePointerUp()"
                     x-cloak>

                    <!-- Main Angle Photo -->
                    <template x-if="activeCar.angles && activeCar.angles.length > 0">
                        <img 
                            :src="activeCar.angles[angleIndex] || activeCar.hero" 
                            :alt="activeCar.name" 
                            class="w-full h-full object-cover transition-opacity duration-500 select-none pointer-events-none">
                    </template>

                    <!-- Slide Counter Overlay -->
                    <div class="absolute top-4 right-4 bg-slate-900/70 dark:bg-black/60 backdrop-blur-md text-white text-[10px] font-bold px-3 py-1.5 rounded-full border border-white/20 tracking-widest uppercase pointer-events-none">
                        Sudut <span x-text="angleIndex + 1"></span> / <span x-text="activeCar.angles.length"></span>
                    </div>

                    <!-- Angle Navigation Arrows -->
                    <template x-if="activeCar.angles && activeCar.angles.length > 1">
                        <div>
                            <button 
                                type="button" 
                                @click.stop="prevAngle()" 
                                class="absolute left-4 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-slate-900/60 hover:bg-cyan-500 hover:text-slate-950 text-white backdrop-blur-md flex items-center justify-center transition border border-white/20 shadow-xl group z-10">
                                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                            </button>
                            <button 
                                type="button" 
                                @click.stop="nextAngle()" 
                                class="absolute right-4 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-slate-900/60 hover:bg-cyan-500 hover:text-slate-950 text-white backdrop-blur-md flex items-center justify-center transition border border-white/20 shadow-xl group z-10">
                                <svg class="w-5 h-5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                    </template>
                </div>

            </div>

            <!-- Dedicated Studio Angle Selector (Outside Viewport - Clean & Unobstructed) -->
            <div x-show="!activeCar.has3d && activeCar.angles && activeCar.angles.length > 1" class="mt-4 pt-3 flex items-center justify-center gap-2.5 sm:gap-3 overflow-x-auto pb-1 select-none no-scrollbar" style="scrollbar-width: none; -ms-overflow-style: none;" x-cloak>
                <span class="text-[11px] text-slate-500 dark:text-slate-400 font-bold hidden sm:inline-flex items-center gap-1.5 mr-1">
                    <svg class="w-4 h-4 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Sudut Galeri:
                </span>
                <template x-for="(angleImg, idx) in activeCar.angles" :key="idx">
                    <button 
                        type="button" 
                        @click="angleIndex = idx" 
                        class="h-12 w-16 sm:h-14 sm:w-20 rounded-xl overflow-hidden border-2 transition-all flex-shrink-0 bg-slate-100 dark:bg-slate-900 shadow-md relative group"
                        :class="angleIndex === idx ? 'border-cyan-500 scale-105 shadow-cyan-500/30 ring-2 ring-cyan-500/30' : 'border-slate-200 dark:border-white/10 opacity-70 hover:opacity-100 hover:border-slate-400 dark:hover:border-white/30'">
                        <img :src="angleImg" class="w-full h-full object-cover">
                        <span class="absolute bottom-0 inset-x-0 bg-black/60 text-[9px] text-white font-bold text-center py-0.5" x-text="idx + 1"></span>
                    </button>
                </template>
            </div>

            <!-- Bottom Controls & Action Bar -->
            <div class="mt-6 pt-4 border-t border-slate-200 dark:border-white/10 flex flex-wrap items-center justify-between gap-4 text-xs">
                
                <!-- Quick Angle Buttons (Only for 3D Ioniq 5) -->
                <div x-show="activeCar.has3d" class="flex flex-wrap items-center gap-2">
                    <button 
                        type="button" 
                        onclick="setViewerAngle('0deg 75deg 105%')" 
                        class="px-3.5 py-1.5 rounded-xl bg-slate-100 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/15 border border-slate-300 dark:border-white/10 text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition font-bold text-[11px]"
                    >
                        Tampak Depan
                    </button>
                    <button 
                        type="button" 
                        onclick="setViewerAngle('90deg 75deg 105%')" 
                        class="px-3.5 py-1.5 rounded-xl bg-slate-100 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/15 border border-slate-300 dark:border-white/10 text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition font-bold text-[11px]"
                    >
                        Tampak Samping
                    </button>
                    <button 
                        type="button" 
                        onclick="setViewerAngle('180deg 75deg 105%')" 
                        class="px-3.5 py-1.5 rounded-xl bg-slate-100 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/15 border border-slate-300 dark:border-white/10 text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition font-bold text-[11px]"
                    >
                        Tampak Belakang
                    </button>
                    <button 
                        type="button" 
                        onclick="setViewerAngle('45deg 45deg 120%')" 
                        class="px-3.5 py-1.5 rounded-xl bg-slate-100 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/15 border border-slate-300 dark:border-white/10 text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition font-bold text-[11px]"
                    >
                        Sudut Bird's Eye
                    </button>
                </div>

                <!-- Unit Info for Non-3D Models -->
                <div x-show="!activeCar.has3d" class="flex items-center gap-3">
                    <div class="text-left">
                        <span class="text-[10px] text-slate-500 dark:text-slate-400 block uppercase font-bold tracking-wider">Harga OTR Surabaya</span>
                        <span class="text-sm sm:text-base font-black text-cyan-600 dark:text-cyan-300" x-text="activeCar.price"></span>
                    </div>
                </div>

                <!-- Action CTA Buttons -->
                <div class="flex flex-wrap items-center gap-2.5 ml-auto">
                    <!-- Official Hyundai VR / Highlights External Link -->
                    <a 
                        :href="activeCar.official_url" 
                        target="_blank" 
                        rel="noopener noreferrer"
                        class="px-4 py-2 rounded-xl bg-cyan-50 dark:bg-cyan-500/10 hover:bg-cyan-100 dark:hover:bg-cyan-500/20 border border-cyan-300 dark:border-cyan-400/30 text-cyan-800 dark:text-cyan-300 font-bold transition flex items-center gap-1.5 text-xs shadow-sm">
                        <svg class="w-3.5 h-3.5 text-cyan-600 dark:text-cyan-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                        <span>Official 360° VR Hyundai</span>
                        <svg class="w-3 h-3 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>

                    <!-- Detail Mobil -->
                    <a 
                        :href="activeCar.detail_url" 
                        class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-white/10 hover:bg-slate-200 dark:hover:bg-white/20 text-slate-800 dark:text-white font-bold transition flex items-center gap-1.5 text-xs border border-slate-200 dark:border-white/10 cursor-pointer relative z-20">
                        <span>Detail Spesifikasi</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>

                    <!-- WhatsApp Test Drive -->
                    <a 
                        :href="`https://api.whatsapp.com/send/?phone=${salesPhone}&text=${encodeURIComponent('Halo, saya tertarik konsultasi dimensi dan info test drive ' + activeCar.name)}`" 
                        target="_blank" 
                        class="px-4 py-2 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white dark:text-slate-950 font-black transition flex items-center gap-2 shadow-lg shadow-cyan-500/25 text-xs uppercase tracking-wider">
                        <span>Pesan Test Drive</span>
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Include Google Model-Viewer Web Component Script (Lazy Loaded on Scroll) -->
<script>
    (function() {
        function loadModelViewer() {
            if (window.customElements && window.customElements.get('model-viewer')) return;
            const s = document.createElement('script');
            s.type = 'module';
            s.src = 'https://ajax.googleapis.com/ajax/libs/model-viewer/3.5.0/model-viewer.min.js';
            document.head.appendChild(s);
        }

        if ('IntersectionObserver' in window) {
            document.addEventListener('DOMContentLoaded', function() {
                const target = document.getElementById('virtual-360') || document.getElementById('ioniqModel');
                if (!target) return;
                const obs = new IntersectionObserver(function(entries) {
                    if (entries[0].isIntersecting) {
                        loadModelViewer();
                        obs.disconnect();
                    }
                }, { rootMargin: '300px' });
                obs.observe(target);
            });
        } else {
            window.addEventListener('load', loadModelViewer);
        }
    })();
</script>

<script>
    function setViewerAngle(orbit) {
        const mv = document.getElementById('ioniqModel');
        if (mv) {
            mv.cameraOrbit = orbit;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const mv = document.getElementById('ioniqModel');
        if (mv) {
            // Ensure cursor feedback on drag
            mv.addEventListener('pointerdown', () => { mv.style.cursor = 'grabbing'; });
            window.addEventListener('pointerup', () => { if (mv) mv.style.cursor = 'grab'; });
        }
    });
</script>
