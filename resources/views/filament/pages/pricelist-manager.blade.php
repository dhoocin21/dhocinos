<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Top Info Header Banner -->
        <div class="relative overflow-hidden p-6 sm:p-8 rounded-3xl shadow-xl" style="background: linear-gradient(135deg, #070d19 0%, #002c5f 60%, #071739 100%) !important; border: 1px solid rgba(59, 130, 246, 0.4) !important; color: #ffffff !important;">
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                <div class="flex items-start sm:items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center shrink-0 shadow-inner" style="background: rgba(37, 99, 235, 0.25) !important; border: 1px solid rgba(96, 165, 250, 0.5) !important; color: #60a5fa !important;">
                        <x-heroicon-o-cloud-arrow-up class="w-8 h-8" style="color: #60a5fa !important;" />
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <h2 class="text-2xl font-black tracking-tight" style="color: #ffffff !important;">
                                Update Pricelist Otomatis
                            </h2>
                            <span class="text-[11px] font-bold uppercase tracking-wider px-3 py-0.5 rounded-full" style="background: rgba(59, 130, 246, 0.3) !important; color: #93c5fd !important; border: 1px solid rgba(96, 165, 250, 0.5) !important;">
                                1-Click AI Sync
                            </span>
                        </div>
                        <p class="text-sm max-w-2xl leading-relaxed" style="color: #e2e8f0 !important;">
                            Cukup satu kali unggah brosur / flyer daftar harga terbaru, sistem AI akan membaca seluruh model mobil, harga OTR, dan tipe varian. Sistem akan menampilkan perbandingan harga untuk <strong style="color: #fde047 !important;" class="underline underline-offset-2">konfirmasi Anda</strong> sebelum diterapkan ke website.
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                    <button 
                        type="button"
                        wire:click="loadOfficialBrochureData"
                        wire:loading.attr="disabled"
                        class="w-full sm:w-auto px-5 py-3 text-xs font-bold rounded-xl transition flex items-center justify-center gap-2 shadow-sm"
                        style="background: #0f172a !important; color: #ffffff !important; border: 1px solid #334155 !important;"
                    >
                        <x-heroicon-m-document-text class="w-4 h-4 text-cyan-400" />
                        <span style="color: #ffffff !important;">Muat Brosur Resmi Gowa (Nico)</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- 1-Click Upload Zone -->
        <div class="bg-white dark:bg-gray-900 border-2 border-dashed border-blue-300 dark:border-blue-900/60 rounded-3xl p-6 sm:p-8 shadow-sm">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800 flex items-center justify-center text-blue-600 shrink-0">
                        <x-heroicon-o-arrow-up-tray class="w-6 h-6" />
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">
                            Unggah Dokumen / Foto Pricelist Terbaru
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                            Mendukung file format <strong>JPG, PNG, WebP, PDF</strong> (Brosur dealer, flyer pameran, tabel daftar harga).
                        </p>
                    </div>
                </div>

                <div class="w-full md:w-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <label class="cursor-pointer">
                        <input 
                            type="file" 
                            wire:model="pricelistFile" 
                            accept="image/*,application/pdf"
                            class="hidden"
                        >
                        <div class="px-5 py-3 rounded-xl border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 text-xs font-bold flex items-center justify-center gap-2 shadow-sm transition">
                            <x-heroicon-m-photo class="w-4 h-4 text-blue-500" />
                            <span>
                                @if($pricelistFile)
                                    File: {{ Str::limit($pricelistFile->getClientOriginalName(), 24) }}
                                @else
                                    Pilih File Brosur...
                                @endif
                            </span>
                        </div>
                    </label>

                    @if($pricelistFile)
                        <button 
                            type="button"
                            wire:click="analyzeUploadedPricelist"
                            wire:loading.attr="disabled"
                            class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-black uppercase tracking-wider flex items-center justify-center gap-2 shadow-lg shadow-blue-600/30 transition"
                        >
                            <x-heroicon-m-sparkles class="w-4 h-4 text-amber-300" wire:loading.class="animate-spin" />
                            <span wire:loading.remove wire:target="analyzeUploadedPricelist">⚡ Analisis dengan AI Vision</span>
                            <span wire:loading wire:target="analyzeUploadedPricelist">AI Sedang Membaca Brosur...</span>
                        </button>
                    @endif
                </div>
            </div>

            @if($pricelistFile)
                <div class="mt-4 pt-4 border-t border-blue-100 dark:border-gray-800 flex items-center justify-between text-xs text-blue-800 dark:text-blue-300">
                    <span class="flex items-center gap-2">
                        <x-heroicon-m-check-circle class="w-4 h-4 text-emerald-500" />
                        <span>File terpilih: <strong>{{ $pricelistFile->getClientOriginalName() }}</strong></span>
                    </span>
                    <span class="text-gray-400">Klik tombol "Analisis dengan AI Vision" untuk memulai</span>
                </div>
            @endif
        </div>

        <!-- Pending Review & Confirmation Section -->
        @if(!empty($pendingAdjustments))
            <div class="bg-amber-500/10 border-2 border-amber-500/30 rounded-3xl p-6 sm:p-8 space-y-6">
                <!-- Action Header -->
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 pb-6 border-b border-amber-500/20">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/20 border border-amber-500/40 flex items-center justify-center text-amber-400 shrink-0 mt-0.5">
                            <x-heroicon-m-exclamation-triangle class="w-6 h-6" />
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-amber-900 dark:text-amber-200">
                                Konfirmasi Penyesuaian Harga ({{ count($pendingAdjustments) }} Unit Terdeteksi)
                            </h3>
                            <p class="text-xs text-amber-800 dark:text-amber-300/80 mt-1">
                                Sumber: <strong>{{ $uploadedFileName }}</strong>. Silakan tinjau perbandingan harga lama vs baru di bawah. 
                                <span class="font-bold underline">Perubahan harga ini BELUM aktif</span> di website hingga Anda menekan tombol <strong>"Konfirmasi & Terapkan"</strong>.
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                        <button 
                            type="button"
                            wire:click="cancelPending"
                            class="w-full sm:w-auto px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 hover:bg-gray-100 text-gray-700 dark:text-gray-300 text-xs font-bold transition shadow-sm"
                        >
                            Batalkan
                        </button>

                        <button 
                            type="button"
                            wire:click="confirmAndApply"
                            wire:confirm="Apakah Anda yakin ingin menerapkan seluruh penyesuaian harga ini ke database dan website?"
                            wire:loading.attr="disabled"
                            class="w-full sm:w-auto px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-black uppercase tracking-wider flex items-center justify-center gap-2 shadow-lg shadow-emerald-600/30 ring-2 ring-emerald-400/30 transition"
                        >
                            <x-heroicon-m-check-badge class="w-4 h-4" />
                            <span wire:loading.remove wire:target="confirmAndApply">Konfirmasi & Terapkan ke Website</span>
                            <span wire:loading wire:target="confirmAndApply">Menyimpan ke Website...</span>
                        </button>
                    </div>
                </div>

                <!-- Comparison Table -->
                <div class="overflow-x-auto rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-sm">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-800/70 border-b border-gray-200 dark:border-gray-800 text-gray-600 dark:text-gray-300 uppercase tracking-wider text-[11px] font-bold">
                                <th class="py-3 px-4">Model Kendaraan</th>
                                <th class="py-3 px-4">Kategori</th>
                                <th class="py-3 px-4 text-right">Harga Saat Ini di Web</th>
                                <th class="py-3 px-4 text-right">Harga Baru Brosur</th>
                                <th class="py-3 px-4 text-center">Selisih</th>
                                <th class="py-3 px-4">Tipe Varian Terdeteksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach($pendingAdjustments as $adj)
                                <tr class="hover:bg-blue-50/40 dark:hover:bg-gray-800/40 transition">
                                    <td class="py-3.5 px-4 font-bold text-gray-900 dark:text-white">
                                        <div class="flex items-center gap-3">
                                            @if(!empty($adj['image']))
                                                <img src="{{ asset('storage/' . $adj['image']) }}" alt="{{ $adj['name'] }}" class="w-12 h-8 object-contain rounded bg-gray-50 dark:bg-gray-800 p-0.5 border border-gray-200 dark:border-gray-700">
                                            @else
                                                <div class="w-12 h-8 rounded bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-400">
                                                    <x-heroicon-o-truck class="w-4 h-4" />
                                                </div>
                                            @endif
                                            <div>
                                                <span>{{ $adj['name'] }}</span>
                                                @if($adj['name'] !== $adj['detected_name'])
                                                    <div class="text-[10px] text-gray-400 font-normal">Terdeteksi: {{ $adj['detected_name'] }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase
                                            @if($adj['category'] === 'EV') bg-cyan-100 text-cyan-800 dark:bg-cyan-950 dark:text-cyan-300
                                            @elseif($adj['category'] === 'HEV') bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300
                                            @elseif($adj['category'] === 'SUV') bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300
                                            @else bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300
                                            @endif
                                        ">
                                            {{ $adj['category'] }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-right font-medium text-gray-500 dark:text-gray-400">
                                        @if($adj['old_price'] > 0)
                                            Rp {{ number_format($adj['old_price'], 0, ',', '.') }}
                                        @else
                                            <span class="italic text-gray-400">- Belum Ada -</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-right font-bold text-gray-900 dark:text-white">
                                        Rp {{ number_format($adj['new_price'], 0, ',', '.') }}
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        @if($adj['status'] === 'new')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-purple-100 text-purple-800 dark:bg-purple-950 dark:text-purple-300">
                                                Unit Baru
                                            </span>
                                        @elseif($adj['status'] === 'up')
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300">
                                                <x-heroicon-m-arrow-trending-up class="w-3 h-3" />
                                                +Rp {{ number_format($adj['diff'], 0, ',', '.') }}
                                            </span>
                                        @elseif($adj['status'] === 'down')
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                                                <x-heroicon-m-arrow-trending-down class="w-3 h-3" />
                                                -Rp {{ number_format(abs($adj['diff']), 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                                Tetap
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <details class="cursor-pointer group">
                                            <summary class="text-[11px] font-bold text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1 list-none">
                                                <span>{{ $adj['variants_count'] }} Tipe Varian</span>
                                                <x-heroicon-m-chevron-down class="w-3.5 h-3.5 transition group-open:rotate-180" />
                                            </summary>
                                            <div class="mt-2 space-y-1 pl-2 border-l-2 border-blue-200 dark:border-blue-900 max-h-40 overflow-y-auto">
                                                @forelse($adj['variants'] as $v)
                                                    <div class="text-[10px] flex items-center justify-between gap-4 py-0.5 text-gray-600 dark:text-gray-300">
                                                        <span>{{ $v['name'] ?? 'Tipe' }}</span>
                                                        <span class="font-semibold text-gray-900 dark:text-white">Rp {{ number_format($v['price'] ?? 0, 0, ',', '.') }}</span>
                                                    </div>
                                                @empty
                                                    <div class="text-[10px] text-gray-400 italic">Tidak ada varian tambahan</div>
                                                @endforelse
                                            </div>
                                        </details>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Bottom Confirmation Trigger -->
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button 
                        type="button"
                        wire:click="cancelPending"
                        class="px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-xs font-bold"
                    >
                        Batalkan
                    </button>
                    <button 
                        type="button"
                        wire:click="confirmAndApply"
                        wire:confirm="Apakah Anda yakin ingin menerapkan seluruh penyesuaian harga ini ke database dan website?"
                        wire:loading.attr="disabled"
                        class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-black uppercase tracking-wider flex items-center gap-2 shadow-lg shadow-emerald-600/30"
                    >
                        <x-heroicon-m-check-badge class="w-4 h-4" />
                        <span>Konfirmasi & Terapkan Perubahan ke Website</span>
                    </button>
                </div>
            </div>
        @endif

        <!-- Active Website Price Status (Current Live Data) -->
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-6 sm:p-8 shadow-sm">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <span>Daftar Harga Unit yang Sedang Aktif di Website</span>
                        <span class="text-xs bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 px-2.5 py-0.5 rounded-full font-bold">Live Status</span>
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Total <strong>{{ count($currentCars) }} unit model</strong> aktif saat ini pada halaman katalog, kalkulator cicilan, dan formulir penawaran.
                    </p>
                </div>

                <a 
                    href="{{ url('/') }}#models" 
                    target="_blank" 
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-100 dark:bg-gray-800 hover:bg-slate-200 dark:hover:bg-gray-700 text-gray-800 dark:text-gray-200 text-xs font-bold transition"
                >
                    <x-heroicon-m-arrow-top-right-on-square class="w-4 h-4 text-blue-500" />
                    <span>Lihat Tampilan di Website</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($currentCars as $car)
                    <div class="p-4 rounded-2xl border border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/40 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            @if(!empty($car['image']))
                                <img src="{{ asset('storage/' . $car['image']) }}" alt="{{ $car['name'] }}" class="w-16 h-10 object-contain rounded bg-white dark:bg-gray-900 p-1 border border-gray-200 dark:border-gray-700">
                            @else
                                <div class="w-16 h-10 rounded bg-white dark:bg-gray-900 flex items-center justify-center text-gray-400 border border-gray-200 dark:border-gray-700">
                                    <x-heroicon-o-truck class="w-5 h-5" />
                                </div>
                            @endif

                            <div>
                                <h4 class="text-sm font-bold text-gray-900 dark:text-white">{{ $car['name'] }}</h4>
                                <span class="text-[10px] text-gray-500 dark:text-gray-400">
                                    {{ count($car['variants'] ?? []) }} Varian &bull; {{ $car['category'] }}
                                </span>
                            </div>
                        </div>

                        <div class="text-right">
                            <div class="text-[10px] text-gray-400 font-medium">Mulai Dari</div>
                            <div class="text-xs font-black text-blue-600 dark:text-blue-400">
                                Rp {{ number_format($car['price'], 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-filament-panels::page>
