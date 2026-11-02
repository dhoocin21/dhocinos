<div class="bg-white dark:bg-[#0c1527] rounded-3xl p-6 sm:p-10 shadow-xl border border-gray-100 dark:border-slate-800 transition-colors">
    <div class="text-center max-w-2xl mx-auto mb-8">
        <span class="text-[10px] font-black text-blue-600 dark:text-cyan-400 uppercase tracking-[0.25em] block mb-1">Direct Comparison</span>
        <h3 class="text-2xl sm:text-3xl font-black text-gray-900 dark:text-white tracking-tight">Komparasi Mobil Berdampingan</h3>
        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 font-medium mt-2">Bandingkan spesifikasi, harga OTR, dan fitur 2 unit Hyundai pilihan Anda untuk menemukan mobil yang paling sesuai kebutuhan.</p>
    </div>

    <!-- Car Selector Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Car 1 Selector -->
        <div class="bg-blue-50/70 dark:bg-slate-900/80 p-4 rounded-2xl border border-blue-200/80 dark:border-slate-700">
            <label class="text-xs font-black text-blue-900 dark:text-cyan-400 uppercase tracking-wider block mb-2">Pilih Mobil 1</label>
            <select wire:model.live="carId1" class="w-full text-xs font-bold px-3 py-2.5 rounded-xl border border-blue-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-950 dark:text-white focus:ring-2 focus:ring-[#002c5f] focus:outline-none">
                @foreach($allCars as $c)
                    <option value="{{ $c->id }}" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">{{ $c->name }} ({{ $c->category }})</option>
                @endforeach
            </select>
        </div>

        <!-- Car 2 Selector -->
        <div class="bg-slate-100/70 dark:bg-slate-900/80 p-4 rounded-2xl border border-slate-200 dark:border-slate-700">
            <label class="text-xs font-black text-slate-800 dark:text-slate-200 uppercase tracking-wider block mb-2">Pilih Mobil 2</label>
            <select wire:model.live="carId2" class="w-full text-xs font-bold px-3 py-2.5 rounded-xl border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-950 dark:text-white focus:ring-2 focus:ring-[#002c5f] focus:outline-none">
                @foreach($allCars as $c)
                    <option value="{{ $c->id }}" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">{{ $c->name }} ({{ $c->category }})</option>
                @endforeach
            </select>
        </div>
    </div>

    @if($car1 && $car2)
        <!-- Comparison Matrix Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="border-b-2 border-gray-200 dark:border-slate-700">
                        <th class="py-4 px-3 w-1/4 text-slate-800 dark:text-slate-200 font-black uppercase tracking-wider text-xs">Parameter</th>
                        <th class="py-4 px-4 w-[37.5%] text-[#002c5f] dark:text-cyan-400 font-black text-base sm:text-lg">{{ $car1->name }}</th>
                        <th class="py-4 px-4 w-[37.5%] text-gray-900 dark:text-white font-black text-base sm:text-lg">{{ $car2->name }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-800">
                    <!-- Image Row -->
                    <tr>
                        <td class="py-4 px-3 text-slate-800 dark:text-slate-300 font-bold text-xs">Visual Unit</td>
                        <td class="py-4 px-4">
                            @if($car1->image)
                                <img src="{{ asset('storage/' . $car1->image) }}" alt="{{ $car1->name }}" class="h-24 sm:h-32 object-contain drop-shadow-md">
                            @endif
                        </td>
                        <td class="py-4 px-4">
                            @if($car2->image)
                                <img src="{{ asset('storage/' . $car2->image) }}" alt="{{ $car2->name }}" class="h-24 sm:h-32 object-contain drop-shadow-md">
                            @endif
                        </td>
                    </tr>

                    <!-- Category Row -->
                    <tr>
                        <td class="py-3 px-3 text-slate-800 dark:text-slate-300 font-bold text-xs">Segmen</td>
                        <td class="py-3 px-4">
                            <span class="inline-block px-2.5 py-1 rounded text-xs font-bold uppercase
                                @if($car1->category === 'EV') bg-cyan-100 text-cyan-800 dark:bg-cyan-950 dark:text-cyan-300
                                @elseif($car1->category === 'HEV') bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300
                                @else bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300 @endif
                            ">
                                {{ $car1->category }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-block px-2.5 py-1 rounded text-xs font-bold uppercase
                                @if($car2->category === 'EV') bg-cyan-100 text-cyan-800 dark:bg-cyan-950 dark:text-cyan-300
                                @elseif($car2->category === 'HEV') bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300
                                @else bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300 @endif
                            ">
                                {{ $car2->category }}
                            </span>
                        </td>
                    </tr>

                    <!-- Price Row -->
                    <tr>
                        <td class="py-3 px-3 text-slate-800 dark:text-slate-300 font-bold text-xs">Harga OTR Mulai</td>
                        <td class="py-3 px-4 font-black text-[#002c5f] dark:text-cyan-400 text-base">
                            Rp {{ number_format($car1->price, 0, ',', '.') }}
                        </td>
                        <td class="py-3 px-4 font-black text-gray-900 dark:text-white text-base">
                            Rp {{ number_format($car2->price, 0, ',', '.') }}
                        </td>
                    </tr>

                    <!-- Monthly Est -->
                    <tr>
                        <td class="py-3 px-3 text-slate-800 dark:text-slate-300 font-bold text-xs">Estimasi Cicilan (DP 20%, 5 Thn)</td>
                        <td class="py-3 px-4 font-bold text-emerald-700 dark:text-emerald-400">
                            ~Rp {{ number_format(($car1->price * 0.80 * 1.25) / 60, 0, ',', '.') }}/bln
                        </td>
                        <td class="py-3 px-4 font-bold text-emerald-700 dark:text-emerald-400">
                            ~Rp {{ number_format(($car2->price * 0.80 * 1.25) / 60, 0, ',', '.') }}/bln
                        </td>
                    </tr>

                    <!-- Variants Row -->
                    <tr>
                        <td class="py-3 px-3 text-slate-800 dark:text-slate-300 font-bold text-xs">Pilihan Tipe Varian</td>
                        <td class="py-3 px-4">
                            @if(!empty($car1->variants) && is_array($car1->variants))
                                <div class="space-y-1">
                                    @foreach($car1->variants as $v)
                                        <div class="text-xs text-gray-800 dark:text-slate-200">
                                            <span class="font-bold">• {{ $v['name'] }}</span>: 
                                            <span class="text-slate-600 dark:text-slate-400 font-semibold">Rp {{ number_format($v['price'] ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-xs text-slate-500 dark:text-slate-400">Standar OTR</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            @if(!empty($car2->variants) && is_array($car2->variants))
                                <div class="space-y-1">
                                    @foreach($car2->variants as $v)
                                        <div class="text-xs text-gray-800 dark:text-slate-200">
                                            <span class="font-bold">• {{ $v['name'] }}</span>: 
                                            <span class="text-slate-600 dark:text-slate-400 font-semibold">Rp {{ number_format($v['price'] ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-xs text-slate-500 dark:text-slate-400">Standar OTR</span>
                            @endif
                        </td>
                    </tr>

                    <!-- Actions -->
                    <tr>
                        <td class="py-4 px-3 text-slate-800 dark:text-slate-300 font-bold text-xs">Aksi</td>
                        <td class="py-4 px-4">
                            <a href="{{ route('car.show', $car1->slug) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#002c5f] hover:bg-blue-900 text-white text-xs font-bold rounded-xl transition shadow-sm">
                                <span>Spesifikasi Lengkap</span>
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        </td>
                        <td class="py-4 px-4">
                            <a href="{{ route('car.show', $car2->slug) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-900 hover:bg-black text-white text-xs font-bold rounded-xl transition shadow-sm">
                                <span>Spesifikasi Lengkap</span>
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
</div>
