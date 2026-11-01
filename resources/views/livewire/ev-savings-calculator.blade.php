<div class="ev-savings-wrapper relative rounded-3xl p-6 sm:p-10 shadow-2xl overflow-hidden" 
     style="background: radial-gradient(circle at 10% 20%, #041026 0%, #071938 50%, #020a1a 100%); border: 1px solid rgba(56, 189, 248, 0.25); color: #f8fafc;">
    
    <style>
        .ev-savings-wrapper {
            font-family: 'Outfit', sans-serif;
            color: #f8fafc !important;
        }
        .ev-savings-wrapper h3, 
        .ev-savings-wrapper h4 {
            color: #ffffff !important;
        }
        .ev-card-btn {
            background-color: #081730;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
            transition: all 0.25s ease;
        }
        .ev-card-btn:hover {
            background-color: #0e2448;
            border-color: rgba(56, 189, 248, 0.4);
        }
        .ev-card-btn.active {
            background-color: rgba(6, 182, 212, 0.15);
            border-color: #38bdf8;
            box-shadow: 0 0 20px rgba(56, 189, 248, 0.25);
        }
        .ev-input-box {
            background-color: #071733;
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #ffffff;
        }
        .ev-slider {
            -webkit-appearance: none;
            width: 100%;
            height: 8px;
            border-radius: 9999px;
            background: #1e293b;
            outline: none;
        }
        .ev-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #38bdf8;
            cursor: pointer;
            box-shadow: 0 0 12px #38bdf8;
            border: 2px solid #ffffff;
        }
        .ev-slider::-moz-range-thumb {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #38bdf8;
            cursor: pointer;
            box-shadow: 0 0 12px #38bdf8;
            border: 2px solid #ffffff;
        }
    </style>

    <!-- Ambient Glow Background Effects -->
    <div class="absolute -top-32 -left-32 w-80 h-80 bg-cyan-500/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-blue-600/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10">
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 pb-6 border-b border-white/10">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-500/10 border border-cyan-400/40 text-cyan-300 text-xs font-bold uppercase tracking-wider mb-3">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                    <span>Simulasi Cerdas Hemat Listrik vs Bensin</span>
                </div>
                <h3 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-white">
                    Berapa Juta yang Bisa Anda <span class="bg-gradient-to-r from-cyan-400 via-teal-300 to-emerald-400 bg-clip-text text-transparent">Hemat dengan Hyundai EV?</span>
                </h3>
                <p class="text-sm text-slate-300 mt-2 max-w-2xl font-medium">
                    Bandingkan langsung pengeluaran bensin mobil lama Anda dengan biaya pengisian daya listrik resmi PLN untuk armada mobil listrik mutakhir Hyundai.
                </p>
            </div>

            <!-- Savings Badge Counter -->
            <div class="flex items-center gap-3 px-5 py-3 rounded-2xl shrink-0" 
                 style="background: rgba(15, 33, 64, 0.75); border: 1px solid rgba(56, 189, 248, 0.3);">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-600 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-wider text-emerald-400 block">Efisiensi Biaya</span>
                    <span class="text-xl font-black text-white">Hemat s/d {{ $savingsPercentage }}%</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Left Column: Input Form Controls -->
            <div class="lg:col-span-7 space-y-6">
                <!-- 1. Select EV Model -->
                <div>
                    <label class="block text-xs font-extrabold text-cyan-300 uppercase tracking-wider mb-2.5">
                        1. Pilih Mobil Listrik Hyundai Idaman
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        @foreach($evModels as $key => $model)
                            <button type="button" 
                                wire:click="$set('selectedModel', '{{ $key }}')"
                                class="ev-card-btn relative p-4 rounded-2xl text-left {{ $selectedModel === $key ? 'active' : '' }}">
                                @if(isset($model['badge']))
                                    <span class="absolute top-2.5 right-2.5 text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full {{ $selectedModel === $key ? 'bg-cyan-400 text-slate-950 shadow-sm' : 'bg-white/15 text-slate-200' }}">
                                        {{ $model['badge'] }}
                                    </span>
                                @endif
                                <div class="font-black text-sm text-white pr-4 leading-tight">{{ $model['name'] }}</div>
                                <div class="text-[11px] text-cyan-300 font-bold mt-1.5 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                                    {{ $model['range'] }}
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- 2. Daily Distance Slider -->
                <div class="ev-input-box p-5 rounded-2xl">
                    <div class="flex items-center justify-between mb-3.5">
                        <label class="text-xs font-extrabold text-slate-200 uppercase tracking-wider flex items-center gap-2">
                            <svg class="w-4 h-4 text-cyan-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            2. Jarak Tempuh Harian Anda
                        </label>
                        <span class="px-3.5 py-1.5 bg-cyan-500/20 border border-cyan-400/50 rounded-xl text-cyan-300 font-black text-sm shadow-sm">
                            {{ $dailyDistance }} KM / hari <span class="text-[11px] font-normal text-slate-300">({{ number_format($monthlyKm, 0, ',', '.') }} km/bln)</span>
                        </span>
                    </div>
                    <input type="range" min="15" max="200" step="5" wire:model.live="dailyDistance"
                        class="ev-slider">
                    <div class="flex justify-between text-[11px] text-slate-400 font-semibold mt-2.5">
                        <span>15 KM (Dalam Kota)</span>
                        <span>100 KM (Mobilisasi Tinggi)</span>
                        <span>200 KM (Luar Kota)</span>
                    </div>
                </div>

                <!-- 3. Old Car Fuel Type & Efficiency -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="ev-input-box p-4 rounded-2xl">
                        <label class="block text-xs font-extrabold text-slate-200 uppercase tracking-wider mb-2">3. Jenis Bensin Mobil Lama</label>
                        <select wire:model.live="fuelType" 
                                class="w-full bg-[#051124] border border-cyan-500/30 rounded-xl text-white text-xs font-bold p-3 focus:outline-none focus:border-cyan-400 shadow-inner">
                            @foreach($fuelPrices as $fKey => $fVal)
                                <option value="{{ $fKey }}" class="bg-[#051124] text-white py-1">
                                    {{ $fVal['label'] }} (Rp {{ number_format($fVal['price'], 0, ',', '.') }}/L)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="ev-input-box p-4 rounded-2xl">
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-xs font-extrabold text-slate-200 uppercase tracking-wider">Konsumsi BBM Mobil Lama</label>
                            <span class="text-xs font-black text-cyan-300 px-2 py-0.5 rounded bg-cyan-400/10 border border-cyan-400/30">
                                1:{{ $petrolEfficiency }} KM/L
                            </span>
                        </div>
                        <input type="range" min="6" max="18" step="1" wire:model.live="petrolEfficiency"
                            class="ev-slider mt-3">
                        <div class="flex justify-between text-[10px] text-slate-400 font-semibold mt-2">
                            <span>1:6 (Boros/SUV)</span>
                            <span>1:10 (Rata-rata)</span>
                            <span>1:18 (LCGC)</span>
                        </div>
                    </div>
                </div>

                <!-- 4. Charging Rate Option -->
                <div class="ev-input-box p-4 sm:p-5 rounded-2xl">
                    <label class="block text-xs font-extrabold text-slate-200 uppercase tracking-wider mb-2.5">
                        4. Pilihan Skema Pengisian Daya (Charging)
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                        @foreach($chargingRates as $cKey => $cVal)
                            <button type="button" 
                                wire:click="$set('chargingType', '{{ $cKey }}')"
                                class="ev-card-btn p-3 rounded-xl text-left text-xs font-semibold {{ $chargingType === $cKey ? 'active' : '' }}">
                                <span class="block text-white leading-snug">{{ $cVal['label'] }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Column: Live Savings Calculation Results Card -->
            <div class="lg:col-span-5 p-6 sm:p-8 rounded-3xl relative shadow-2xl"
                 style="background: linear-gradient(180deg, #071938 0%, #05142d 100%); border: 1.5px solid rgba(56, 189, 248, 0.35);">
                
                <span class="text-[10px] font-black uppercase tracking-widest text-cyan-300 block mb-1">Hasil Analisa Finansial</span>
                <h4 class="text-xl font-black text-white mb-6">Total Uang yang Berhasil Anda Hemat:</h4>

                <!-- Comparison Cards -->
                <div class="space-y-3 mb-6">
                    <!-- Petrol Cost -->
                    <div class="flex items-center justify-between p-3.5 rounded-xl border"
                         style="background: rgba(239, 68, 68, 0.1); border-color: rgba(239, 68, 68, 0.3);">
                        <div class="flex items-center gap-2.5">
                            <span class="w-9 h-9 rounded-xl bg-red-500/20 flex items-center justify-center text-red-400 text-sm">⛽</span>
                            <div>
                                <div class="text-xs font-bold text-slate-200">Biaya Bensin Mobil Lama</div>
                                <div class="text-[10px] text-slate-400 font-medium">{{ number_format($monthlyKm, 0, ',', '.') }} KM / bulan</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-black text-red-400">Rp {{ number_format($monthlyFuelCost, 0, ',', '.') }}</div>
                            <div class="text-[9px] text-slate-400 font-medium">per bulan</div>
                        </div>
                    </div>

                    <!-- EV Electric Cost -->
                    <div class="flex items-center justify-between p-3.5 rounded-xl border"
                         style="background: rgba(6, 182, 212, 0.1); border-color: rgba(56, 189, 248, 0.4);">
                        <div class="flex items-center gap-2.5">
                            <span class="w-9 h-9 rounded-xl bg-cyan-500/20 flex items-center justify-center text-cyan-300 text-sm">⚡</span>
                            <div>
                                <div class="text-xs font-bold text-white">{{ $evModels[$selectedModel]['name'] }}</div>
                                <div class="text-[10px] text-cyan-300/80 font-medium">Charging Listrik PLN</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-black text-cyan-300">Rp {{ number_format($monthlyEvCost, 0, ',', '.') }}</div>
                            <div class="text-[9px] text-cyan-200/80 font-medium">per bulan</div>
                        </div>
                    </div>
                </div>

                <!-- Big Savings Highlight -->
                <div class="p-5 rounded-2xl text-center mb-6"
                     style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(20, 184, 166, 0.15) 100%); border: 2px solid rgba(52, 211, 153, 0.45); box-shadow: 0 0 25px rgba(16, 185, 129, 0.15);">
                    <span class="text-[11px] font-black text-emerald-300 uppercase tracking-widest block mb-1">
                        Hemat Biaya Operasional per Tahun
                    </span>
                    <div class="text-3xl sm:text-4xl font-black text-emerald-400 drop-shadow-md">
                        Rp {{ number_format($yearlySavings, 0, ',', '.') }}
                    </div>
                    <div class="text-xs text-emerald-200 font-semibold mt-1.5">
                        Atau hemat <span class="font-black text-white underline decoration-emerald-400">Rp {{ number_format($monthlySavings, 0, ',', '.') }}</span> setiap bulan!
                    </div>
                    <div class="text-[11px] text-slate-300 font-medium mt-3 pt-3 border-t border-emerald-400/20">
                        Dalam 5 Tahun Pemakaian: <strong class="text-white font-extrabold">Rp {{ number_format($fiveYearSavings, 0, ',', '.') }}</strong> (Cukup untuk DP mobil baru!)
                    </div>
                </div>

                <!-- Environmental Benefit -->
                <div class="flex items-center gap-3 p-3.5 rounded-xl border mb-6 text-xs text-slate-300"
                     style="background: rgba(255, 255, 255, 0.05); border-color: rgba(255, 255, 255, 0.1);">
                    <span class="text-2xl">🌱</span>
                    <div class="leading-relaxed">
                        Mengurangi emisi hingga <strong class="text-white">{{ number_format($yearlyCo2SavedKg, 0, ',', '.') }} kg CO2/tahun</strong>, setara menanam <strong class="text-emerald-300 font-bold">{{ $equivalentTrees }} pohon</strong> per tahun.
                    </div>
                </div>

                <!-- Action CTA -->
                @php
                    $waMsg = "Halo Mas Nico, saya sudah hitung simulasi di website untuk mobil *{$evModels[$selectedModel]['name']}* dengan jarak tempuh {$dailyDistance} km/hari. Hasilnya bisa hemat Rp " . number_format($monthlySavings, 0, ',', '.') . " per bulan (Rp " . number_format($yearlySavings, 0, ',', '.') . "/tahun). Mohon info promo diskon OTR Surabaya dan jadwal Test Drive mobil listrik ini.";
                @endphp
                <a href="{{ route('track.wa', ['text' => $waMsg]) }}" target="_blank"
                    class="w-full py-4 px-5 text-white font-black text-xs uppercase tracking-wider rounded-xl transition duration-300 flex items-center justify-center gap-2.5 shadow-xl group"
                    style="background: linear-gradient(135deg, #10b981 0%, #0d9488 100%); box-shadow: 0 8px 25px rgba(16, 185, 129, 0.35);">
                    <svg class="w-4 h-4 transition-transform group-hover:scale-125" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
                    <span>Klaim Promo & Jadwalkan Test Drive EV</span>
                </a>
            </div>
        </div>
    </div>
</div>
