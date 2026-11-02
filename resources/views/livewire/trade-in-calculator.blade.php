<div class="bg-white dark:bg-[#0c1527] rounded-3xl p-6 sm:p-8 shadow-xl border border-gray-100 dark:border-slate-800 relative overflow-hidden transition-colors">
    <!-- Radiant Accent Glow -->
    <div class="absolute -top-12 -right-12 w-48 h-48 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <span class="text-[10px] font-black text-blue-600 dark:text-cyan-400 uppercase tracking-[0.25em] block mb-1">Trade-In Center</span>
            <h3 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white tracking-tight">Kalkulator Tukar Tambah</h3>
            <p class="text-xs text-slate-600 dark:text-slate-300 font-medium mt-1">Dapatkan taksiran instan mobil lama Anda untuk memotong DP mobil Hyundai baru.</p>
        </div>
        <div class="hidden sm:flex w-12 h-12 rounded-2xl bg-blue-50 dark:bg-slate-800 text-[#002c5f] dark:text-cyan-400 items-center justify-center font-bold text-lg">
            🔄
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Form Inputs -->
        <div class="lg:col-span-7 space-y-4">
            <!-- Brand & Model -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-[11px] font-black text-slate-800 dark:text-slate-200 uppercase tracking-wider block mb-1">Merek Mobil Lama</label>
                    <select wire:model.live="brand" class="w-full text-xs font-bold px-3 py-2.5 rounded-xl border border-gray-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-gray-950 dark:text-white focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                        <option value="Toyota" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">Toyota</option>
                        <option value="Honda" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">Honda</option>
                        <option value="Mitsubishi" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">Mitsubishi</option>
                        <option value="Daihatsu" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">Daihatsu</option>
                        <option value="Suzuki" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">Suzuki</option>
                        <option value="Hyundai" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">Hyundai</option>
                        <option value="Nissan" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">Nissan</option>
                        <option value="Mazda" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">Mazda</option>
                        <option value="Wuling" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">Wuling</option>
                        <option value="Lainnya" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">Merek Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="text-[11px] font-black text-slate-800 dark:text-slate-200 uppercase tracking-wider block mb-1">Model / Tipe Mobil</label>
                    <input type="text" wire:model.lazy="modelName" placeholder="Contoh: Avanza G, Brio RS, Innova" class="w-full text-xs font-bold px-3 py-2.5 rounded-xl border border-gray-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-gray-950 dark:text-white placeholder:text-gray-500 dark:placeholder:text-gray-400 focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                </div>
            </div>

            <!-- Year & Transmission -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-[11px] font-black text-slate-800 dark:text-slate-200 uppercase tracking-wider block mb-1">Tahun Perakitan</label>
                    <select wire:model.live="year" class="w-full text-xs font-bold px-3 py-2.5 rounded-xl border border-gray-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-gray-950 dark:text-white focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                        @for($y = 2025; $y >= 2012; $y--)
                            <option value="{{ $y }}" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="text-[11px] font-black text-slate-800 dark:text-slate-200 uppercase tracking-wider block mb-1">Transmisi</label>
                    <select wire:model.live="transmission" class="w-full text-xs font-bold px-3 py-2.5 rounded-xl border border-gray-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-gray-950 dark:text-white focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                        <option value="Automatic" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">Automatic / CVT</option>
                        <option value="Manual" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">Manual</option>
                    </select>
                </div>
            </div>

            <!-- Mileage & Condition -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-[11px] font-black text-slate-800 dark:text-slate-200 uppercase tracking-wider block mb-1">Jarak Tempuh (KM)</label>
                    <select wire:model.live="mileage" class="w-full text-xs font-bold px-3 py-2.5 rounded-xl border border-gray-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-gray-950 dark:text-white focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                        <option value="<30000" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">&lt; 30.000 KM (Jarang Dipakai)</option>
                        <option value="30000-60000" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">30.000 - 60.000 KM (Standar)</option>
                        <option value="60000-100000" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">60.000 - 100.000 KM</option>
                        <option value=">100000" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">&gt; 100.000 KM</option>
                    </select>
                </div>
                <div>
                    <label class="text-[11px] font-black text-slate-800 dark:text-slate-200 uppercase tracking-wider block mb-1">Kondisi Fisik & Bodi</label>
                    <select wire:model.live="condition" class="w-full text-xs font-bold px-3 py-2.5 rounded-xl border border-gray-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-gray-950 dark:text-white focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                        <option value="excellent" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">Sangat Baik (Cat Orisinil, Bebas Tabrak/Banjir)</option>
                        <option value="good" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">Baik / Terawat Normal</option>
                        <option value="fair" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">Perlu Sedikit Perbaikan Bodi / Mesin</option>
                    </select>
                </div>
            </div>

            <!-- Target Hyundai Car -->
            <div>
                <label class="text-[11px] font-black text-[#002c5f] dark:text-cyan-400 uppercase tracking-wider block mb-1">Pilih Mobil Hyundai Baru Pilihan Anda</label>
                <select wire:model.live="targetCarId" class="w-full text-xs font-bold px-3 py-3 rounded-xl border-2 border-blue-300 dark:border-cyan-500/50 bg-blue-50/70 dark:bg-slate-800 text-blue-950 dark:text-white focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-[#002c5f] focus:outline-none transition">
                    @foreach($cars as $c)
                        <option value="{{ $c->id }}" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">
                            {{ $c->name }} (OTR Mulai Rp {{ number_format($c->price, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Valuation Result Card -->
        <div class="lg:col-span-5 bg-gradient-to-br from-[#002c5f] to-blue-950 text-white rounded-2xl p-6 shadow-xl border border-blue-800/40 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-4 border-b border-white/10">
                    <span class="text-xs font-semibold text-blue-200">Estimasi Taksiran Mobil Lama</span>
                    <span class="text-[10px] uppercase font-bold bg-white/20 px-2 py-0.5 rounded text-white">Inspeksi Gratis</span>
                </div>

                <div class="mt-4 mb-6">
                    <p class="text-xs text-cyan-300 font-bold mb-1">{{ $brand }} {{ $modelName }} ({{ $year }})</p>
                    <div class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                        Rp {{ number_format($estimatedValue, 0, ',', '.') }}
                    </div>
                    <p class="text-[10px] text-blue-200/90 mt-1">*Nilai estimasi pasar acuan, penawaran final setelah cek fisik resmi.</p>
                </div>

                <div class="space-y-2.5 bg-black/30 p-4 rounded-xl border border-white/10 text-xs">
                    <div class="flex justify-between items-center text-blue-200">
                        <span>Harga OTR Unit Baru:</span>
                        <span class="font-bold text-white">Rp {{ number_format($targetCarPrice, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-blue-200">
                        <span>Estimasi DP 20%:</span>
                        <span class="font-bold text-white">Rp {{ number_format($targetCarPrice * 0.20, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-emerald-300 pt-2 border-t border-white/10 font-bold">
                        <span>Perkiraan Sisa DP:</span>
                        <span class="text-sm">
                            @if($netDpEstimate <= 0)
                                <span class="bg-emerald-500/30 text-emerald-200 px-2 py-0.5 rounded text-[11px]">DP Tercover Penuh (DP 0)!</span>
                            @else
                                Rp {{ number_format($netDpEstimate, 0, ',', '.') }}
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <a 
                    href="{{ $this->whatsAppUrl }}" 
                    target="_blank"
                    class="w-full bg-emerald-500 hover:bg-emerald-400 text-white font-black py-3.5 px-4 rounded-xl text-xs uppercase tracking-wider flex items-center justify-center gap-2 transition shadow-lg shadow-emerald-500/30"
                >
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
                    <span>Ajukan Tukar Tambah via WA</span>
                </a>
                <p class="text-[10px] text-center text-blue-200 font-medium mt-2">Bebas biaya taksiran & unit bisa diinspeksi di rumah Anda.</p>
            </div>
        </div>
    </div>
</div>
