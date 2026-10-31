<div class="relative bg-gradient-to-br from-[#001738] via-[#002c5f] to-[#041c38] rounded-3xl p-6 sm:p-10 text-white shadow-2xl border border-blue-400/20 overflow-hidden">
    <!-- Ambient Glow Background Effects -->
    <div class="absolute -top-32 -left-32 w-80 h-80 bg-cyan-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-[radial-gradient(ellipse_at_center,rgba(56,189,248,0.06),transparent_70%)] pointer-events-none"></div>

    <div class="relative z-10">
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 pb-6 border-b border-white/10">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-500/10 border border-cyan-400/30 text-cyan-300 text-xs font-bold uppercase tracking-wider mb-3">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                    <span>Simulasi Cerdas Hemat Listrik vs Bensin</span>
                </div>
                <h3 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-white">
                    Berapa Juta yang Bisa Anda <span class="bg-gradient-to-r from-cyan-400 to-emerald-400 bg-clip-text text-transparent">Hemat dengan Hyundai EV?</span>
                </h3>
                <p class="text-sm text-blue-200/80 mt-2 max-w-2xl">
                    Bandingkan langsung pengeluaran bensin mobil lama Anda dengan biaya pengisian daya listrik resmi PLN untuk armada mobil listrik mutakhir Hyundai.
                </p>
            </div>

            <!-- Savings Badge Counter -->
            <div class="flex items-center gap-3 bg-white/5 backdrop-blur-md px-4 py-3 rounded-2xl border border-white/10 shrink-0">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-600 flex items-center justify-center text-white shadow-lg shadow-emerald-500/20">
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
                    <label class="block text-xs font-bold text-blue-200 uppercase tracking-wider mb-2">1. Pilih Mobil Listrik Hyundai Idaman</label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                        @foreach($evModels as $key => $model)
                            <button type="button" 
                                wire:click="$set('selectedModel', '{{ $key }}')"
                                class="relative p-3.5 rounded-2xl text-left transition-all duration-200 border {{ $selectedModel === $key ? 'bg-cyan-500/20 border-cyan-400 shadow-lg shadow-cyan-500/10' : 'bg-white/5 hover:bg-white/10 border-white/10' }}">
                                @if(isset($model['badge']))
                                    <span class="absolute top-2 right-2 text-[9px] font-black uppercase tracking-wider px-1.5 py-0.5 rounded-full {{ $selectedModel === $key ? 'bg-cyan-400 text-slate-900' : 'bg-white/20 text-white' }}">
                                        {{ $model['badge'] }}
                                    </span>
                                @endif
                                <div class="font-black text-sm text-white pr-8">{{ $model['name'] }}</div>
                                <div class="text-[11px] text-cyan-300 font-bold mt-1">{{ $model['range'] }}</div>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- 2. Daily Distance Slider -->
                <div class="bg-white/5 backdrop-blur-md p-4 sm:p-5 rounded-2xl border border-white/10">
                    <div class="flex items-center justify-between mb-3">
                        <label class="text-xs font-bold text-blue-200 uppercase tracking-wider flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-cyan-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            2. Jarak Tempuh Harian Anda
                        </label>
                        <span class="px-3 py-1 bg-cyan-400/20 border border-cyan-400/40 rounded-xl text-cyan-300 font-black text-sm">
                            {{ $dailyDistance }} KM / hari <span class="text-[11px] font-normal text-blue-200">({{ number_format($monthlyKm, 0, ',', '.') }} km/bln)</span>
                        </span>
                    </div>
                    <input type="range" min="15" max="200" step="5" wire:model.live="dailyDistance"
                        class="w-full h-2.5 bg-slate-700/80 rounded-lg appearance-none cursor-pointer accent-cyan-400">
                    <div class="flex justify-between text-[10px] text-blue-300/60 font-semibold mt-2">
                        <span>15 KM (Komuter Dalam Kota)</span>
                        <span>100 KM (Mobilisasi Tinggi)</span>
                        <span>200 KM (Antar Kota)</span>
                    </div>
                </div>

                <!-- 3. Old Car Fuel Type & Efficiency -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-white/5 backdrop-blur-md p-4 rounded-2xl border border-white/10">
                        <label class="block text-xs font-bold text-blue-200 uppercase tracking-wider mb-2">3. Jenis Bensin Mobil Lama</label>
                        <select wire:model.live="fuelType" class="w-full bg-[#001738] border border-white/20 rounded-xl text-white text-xs font-bold p-3 focus:outline-none focus:border-cyan-400">
                            @foreach($fuelPrices as $fKey => $fVal)
                                <option value="{{ $fKey }}">{{ $fVal['label'] }} (Rp {{ number_format($fVal['price'], 0, ',', '.') }}/L)</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="bg-white/5 backdrop-blur-md p-4 rounded-2xl border border-white/10">
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-xs font-bold text-blue-200 uppercase tracking-wider">Konsumsi BBM Mobil Lama</label>
                            <span class="text-xs font-black text-cyan-300">1:{{ $petrolEfficiency }} KM/L</span>
                        </div>
                        <input type="range" min="6" max="18" step="1" wire:model.live="petrolEfficiency"
                            class="w-full h-2 bg-slate-700/80 rounded-lg appearance-none cursor-pointer accent-cyan-400 mt-2">
                        <div class="flex justify-between text-[10px] text-blue-300/60 font-semibold mt-1">
                            <span>1:6 (Boros/SUV Tua)</span>
                            <span>1:10 (Rata-rata)</span>
                            <span>1:18 (LCGC)</span>
                        </div>
                    </div>
                </div>

                <!-- 4. Charging Rate Option -->
                <div class="bg-white/5 backdrop-blur-md p-4 rounded-2xl border border-white/10">
                    <label class="block text-xs font-bold text-blue-200 uppercase tracking-wider mb-2">4. Pilihan Skema Pengisian Daya (Charging)</label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                        @foreach($chargingRates as $cKey => $cVal)
                            <button type="button" 
                                wire:click="$set('chargingType', '{{ $cKey }}')"
                                class="p-2.5 rounded-xl text-left border text-xs transition {{ $chargingType === $cKey ? 'bg-cyan-500/20 border-cyan-400 text-white font-bold' : 'bg-white/5 border-white/10 text-blue-200 hover:bg-white/10' }}">
                                <span class="block truncate">{{ $cVal['label'] }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Column: Live Savings Calculation Results Card -->
            <div class="lg:col-span-5 bg-gradient-to-b from-white/10 via-white/5 to-cyan-500/10 backdrop-blur-xl p-6 sm:p-8 rounded-3xl border border-cyan-400/30 shadow-2xl relative">
                <span class="text-[10px] font-black uppercase tracking-widest text-cyan-300 block mb-1">Hasil Analisa Finansial</span>
                <h4 class="text-xl font-black text-white mb-6">Total Uang yang Berhasil Anda Hemat:</h4>

                <!-- Comparison Cards -->
                <div class="space-y-3 mb-6">
                    <!-- Petrol Cost -->
                    <div class="flex items-center justify-between p-3.5 rounded-xl bg-red-500/10 border border-red-500/20">
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-lg bg-red-500/20 flex items-center justify-center text-red-400 text-xs">⛽</span>
                            <div>
                                <div class="text-xs font-bold text-gray-200">Biaya Bensin Mobil Lama</div>
                                <div class="text-[10px] text-gray-400">{{ number_format($monthlyKm, 0, ',', '.') }} KM / bulan</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-black text-red-400">Rp {{ number_format($monthlyFuelCost, 0, ',', '.') }}</div>
                            <div class="text-[9px] text-gray-400">per bulan</div>
                        </div>
                    </div>

                    <!-- EV Electric Cost -->
                    <div class="flex items-center justify-between p-3.5 rounded-xl bg-cyan-500/10 border border-cyan-400/30">
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-lg bg-cyan-500/20 flex items-center justify-center text-cyan-300 text-xs">⚡</span>
                            <div>
                                <div class="text-xs font-bold text-white">{{ $evModels[$selectedModel]['name'] }}</div>
                                <div class="text-[10px] text-cyan-200/70">Charging Listrik PLN</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-black text-cyan-300">Rp {{ number_format($monthlyEvCost, 0, ',', '.') }}</div>
                            <div class="text-[9px] text-cyan-200/70">per bulan</div>
                        </div>
                    </div>
                </div>

                <!-- Big Savings Highlight -->
                <div class="bg-gradient-to-r from-emerald-500/20 to-teal-500/20 border-2 border-emerald-400/40 p-5 rounded-2xl text-center mb-6">
                    <span class="text-[11px] font-bold text-emerald-300 uppercase tracking-widest block mb-1">Hemat Biaya Operasional per Tahun</span>
                    <div class="text-3xl sm:text-4xl font-black text-emerald-400 drop-shadow-md">
                        Rp {{ number_format($yearlySavings, 0, ',', '.') }}
                    </div>
                    <div class="text-xs text-emerald-200 font-semibold mt-1">
                        Atau hemat <span class="font-black text-white">Rp {{ number_format($monthlySavings, 0, ',', '.') }}</span> setiap bulan!
                    </div>
                    <div class="text-[11px] text-gray-300 font-medium mt-2 pt-2 border-t border-emerald-400/20">
                        Dalam 5 Tahun Pemakaian: <strong class="text-white">Rp {{ number_format($fiveYearSavings, 0, ',', '.') }}</strong> (Cukup untuk DP mobil baru!)
                    </div>
                </div>

                <!-- Environmental Benefit -->
                <div class="flex items-center gap-3 p-3 bg-white/5 rounded-xl border border-white/10 mb-6 text-xs text-blue-200">
                    <span class="text-xl">🌱</span>
                    <div>
                        Mengurangi emisi hingga <strong class="text-white">{{ number_format($yearlyCo2SavedKg, 0, ',', '.') }} kg CO2/tahun</strong>, setara menanam <strong class="text-emerald-300">{{ $equivalentTrees }} pohon</strong> per tahun.
                    </div>
                </div>

                <!-- Action CTA -->
                @php
                    $waMsg = "Halo Mas Nico, saya sudah hitung simulasi di website untuk mobil *{$evModels[$selectedModel]['name']}* dengan jarak tempuh {$dailyDistance} km/hari. Hasilnya bisa hemat Rp " . number_format($monthlySavings, 0, ',', '.') . " per bulan (Rp " . number_format($yearlySavings, 0, ',', '.') . "/tahun). Mohon info promo diskon OTR Surabaya dan jadwal Test Drive mobil listrik ini.";
                @endphp
                <a href="{{ route('track.wa', ['text' => $waMsg]) }}" target="_blank"
                    class="w-full py-3.5 px-5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white font-black text-xs uppercase tracking-wider rounded-xl transition duration-200 flex items-center justify-center gap-2 shadow-lg shadow-emerald-600/30 group">
                    <svg class="w-4 h-4 transition-transform group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
                    <span>Klaim Promo & Jadwalkan Test Drive EV</span>
                </a>
            </div>
        </div>
    </div>
</div>
