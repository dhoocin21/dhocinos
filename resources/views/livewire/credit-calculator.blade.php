<div class="bg-white dark:bg-[#0c1527] rounded-[2.5rem] p-8 md:p-10 shadow-2xl shadow-gray-200/50 dark:shadow-black/50 border border-gray-100 dark:border-slate-800/80 h-full flex flex-col justify-between transition-colors">
    <div class="space-y-6">
        <!-- Car Selector -->
        <div class="space-y-2">
            <label class="text-xs font-black text-slate-800 dark:text-slate-200 uppercase tracking-widest px-1">Pilih Unit Kendaraan</label>
            <select wire:model.live="selectedCarId" class="w-full bg-slate-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-2xl p-4 text-sm font-bold text-gray-950 dark:text-white focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-500 transition-all shadow-sm">
                @foreach($cars as $car)
                    <option value="{{ $car->id }}" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">{{ $car->name }} - Rp {{ number_format($car->price, 0, ',', '.') }}</option>
                @endforeach
            </select>
        </div>

        <!-- DP Slider -->
        <div class="space-y-4 bg-blue-50/70 dark:bg-slate-900/80 p-6 rounded-3xl border border-blue-200/60 dark:border-slate-700/80">
            <div class="flex justify-between items-center">
                <label class="text-xs font-black text-blue-900 dark:text-cyan-400 uppercase tracking-widest">Uang Muka (DP)</label>
                <span class="text-xs font-black text-blue-900 dark:text-white bg-white dark:bg-slate-800 px-3 py-1 rounded-xl border border-blue-200 dark:border-slate-700 shadow-sm">{{ $dpPercent }}%</span>
            </div>
            <div class="text-2xl font-black text-blue-950 dark:text-white tracking-tight">
                Rp {{ number_format($dpAmount, 0, ',', '.') }}
            </div>
            <input type="range" wire:model.live="dpPercent" min="20" max="80" step="5" 
                   class="w-full h-2 bg-blue-200 dark:bg-slate-700 rounded-lg appearance-none cursor-pointer accent-blue-600">
            <div class="flex justify-between text-[10px] font-black text-blue-800 dark:text-cyan-400 uppercase tracking-wider">
                <span>Min 20%</span>
                <span>Max 80%</span>
            </div>
        </div>

        <!-- Tenor & Insurance -->
        <div class="grid grid-cols-2 gap-5">
            <div class="space-y-2">
                <label class="text-xs font-black text-slate-800 dark:text-slate-200 uppercase tracking-widest px-1">Tenor</label>
                <select wire:model.live="tenor" class="w-full bg-slate-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-2xl p-4 text-xs font-bold text-gray-950 dark:text-white focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-500 transition-all shadow-sm">
                    <option value="12" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">12 Bln</option>
                    <option value="24" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">24 Bln</option>
                    <option value="36" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">36 Bln</option>
                    <option value="48" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">48 Bln</option>
                    <option value="60" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">60 Bln</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-xs font-black text-slate-800 dark:text-slate-200 uppercase tracking-widest px-1">Asuransi</label>
                <select wire:model.live="insuranceType" class="w-full bg-slate-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-2xl p-4 text-xs font-bold text-gray-950 dark:text-white focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-500 transition-all shadow-sm">
                    <option value="all_risk" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">All Risk</option>
                    <option value="kombinasi" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">Kombinasi</option>
                    <option value="tlo" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">TLO</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Result & Button Section -->
    <div class="mt-8 space-y-4">
        <div class="bg-[#002c5f] dark:bg-blue-950 rounded-3xl p-6 text-center text-white shadow-xl shadow-blue-900/20 border border-blue-800/40 relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-blue-200 dark:text-cyan-300 text-[10px] font-black uppercase tracking-[0.2em] mb-1">Estimasi Angsuran</p>
                <h4 class="text-3xl font-black italic">Rp {{ number_format($monthlyInstallment, 0, ',', '.') }}<span class="text-xs not-italic text-blue-200 ml-1">/BLN</span></h4>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/5 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <a href="{{ route('quotation', ['car_id' => $selectedCarId, 'dp_percent' => $dpPercent, 'tenor' => $tenor, 'insurance' => $insuranceType, 'dp_amount' => $dpAmount]) }}" 
               target="_blank"
               class="bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-gray-900 dark:text-white py-3.5 px-4 rounded-2xl font-bold text-xs uppercase tracking-wider transition-all flex items-center justify-center gap-2 border border-gray-300 dark:border-slate-700">
                <svg class="w-4 h-4 text-[#002c5f] dark:text-cyan-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2M6 9V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v5"/><rect width="12" height="8" x="6" y="14" rx="1" ry="1"/></svg>
                <span>Unduh PDF</span>
            </a>

            <a href="https://wa.me/{{ \App\Models\Consultant::first()?->formatted_phone ?? '6281330135013' }}?text={{ urlencode("Halo Mas Nico, saya ingin konsultasi simulasi kredit unit *{$carName}*.\n\nDetail simulasi:\n- OTR: Rp " . number_format($otr, 0, ',', '.') . "\n- DP: Rp " . number_format($dpAmount, 0, ',', '.') . " ({$dpPercent}%)\n- Tenor: {$tenor} Bulan\n- Angsuran: Rp " . number_format($monthlyInstallment, 0, ',', '.') . "/bln\n- Asuransi: " . strtoupper($insuranceType) . "\n\nBisa dibantu diskon & promo terbaiknya?") }}" 
               target="_blank"
               class="bg-[#002c5f] hover:bg-blue-900 text-white py-3.5 px-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all flex items-center justify-center gap-2 shadow-md">
                <span>Konsultasi WA</span>
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</div>
