<x-filament-widgets::widget>
    <style>
        .stats-item { border-right: 1px solid #f3f4f6; }
        .dark .stats-item { border-right: 1px solid #374151; }
        @media (max-width: 768px) {
            .stats-item { border-right: none !important; border-bottom: 1px solid #f3f4f6; width: 50% !important; flex: 0 0 50% !important; }
            .chart-container { flex-direction: column !important; }
            .chart-left, .chart-right { width: 100% !important; max-width: 100% !important; border-right: none !important; }
        }
        @media (min-width: 769px) {
            .chart-left { flex: 0 0 68% !important; width: 68% !important; border-right: 1px solid #f3f4f6 !important; }
            .chart-right { flex: 0 0 32% !important; width: 32% !important; }
        }
    </style>

    <x-filament::section class="!p-0 overflow-hidden shadow-sm">
        @if(auth()->user()?->role === 'developer')
            <div class="flex justify-between items-center p-3 border-b border-gray-100 dark:border-gray-800 bg-amber-50/40 dark:bg-amber-950/10">
                <div class="flex items-center gap-2">
                    <span class="flex h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
                    <span class="text-[11px] font-bold text-amber-800 dark:text-amber-400 tracking-wider uppercase">⚡ Developer Analytics Sandbox</span>
                </div>
                <div class="flex gap-2">
                    <x-filament::button wire:click="populateDummyData" size="xs" color="gray" icon="heroicon-o-arrow-path" class="text-xs">
                        Isi Data Dummy (Kota, Device & Durasi)
                    </x-filament::button>
                    <x-filament::button wire:click="resetToRealData" size="xs" color="danger" icon="heroicon-o-trash" class="text-xs">
                        Reset Data Real
                    </x-filament::button>
                </div>
            </div>
        @endif
        
        <!-- Stats Header (Now with Avg Duration & Peak Hour) -->
        <div class="flex flex-wrap items-center border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-900/50">
            @php
                $statItems = [
                    ['label' => 'Total Visits', 'data' => $stats['visits'], 'icon' => 'heroicon-o-user-group'],
                    ['label' => 'Rata-rata Durasi', 'data' => $stats['duration'], 'icon' => 'heroicon-o-clock'],
                    ['label' => 'Klik WhatsApp', 'data' => $stats['wa'], 'icon' => 'heroicon-o-chat-bubble-left-ellipsis'],
                    ['label' => 'Total Booking', 'data' => $stats['bookings'], 'icon' => 'heroicon-o-calendar-days'],
                    ['label' => 'Conversion Rate', 'data' => $stats['conversion'], 'icon' => 'heroicon-o-chart-bar-square'],
                ];
            @endphp
            
            @foreach($statItems as $index => $item)
                <div class="stats-item flex-1 p-4 min-w-[150px]">
                    <div class="flex items-center justify-between mb-1">
                        <h3 class="text-[10px] font-extrabold text-indigo-600 dark:text-indigo-400 tracking-wider uppercase">{{ $item['label'] }}</h3>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-xl md:text-2xl font-black text-gray-900 dark:text-white">{{ $item['data']['value'] }}</span>
                        @if(isset($item['data']['trend']))
                            <div class="flex items-center text-xs font-bold {{ $item['data']['trend']['color'] }}">
                                @if($item['data']['trend']['dir'] === 'up')
                                    <x-heroicon-o-arrow-trending-up class="w-3 h-3 mr-1" />
                                @else
                                    <x-heroicon-o-arrow-trending-down class="w-3 h-3 mr-1" />
                                @endif
                                {{ $item['data']['trend']['pct'] }}
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Peak Traffic Hour Insight Banner -->
        <div class="px-5 py-2.5 bg-gradient-to-r from-blue-50/80 via-indigo-50/50 to-white dark:from-gray-800 dark:to-gray-900 border-b border-gray-100 dark:border-gray-800 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2 text-xs">
                <span class="p-1 rounded-md bg-blue-600 text-white flex items-center justify-center">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </span>
                <span class="text-gray-600 dark:text-gray-300 font-medium">Jam Paling Ramai Dikunjungi:</span>
                <span class="font-black text-[#002c5f] dark:text-blue-400 text-xs px-2 py-0.5 rounded-full bg-blue-100/70 dark:bg-blue-900/40">
                    {{ $peakHour }}
                </span>
            </div>
            <span class="text-[11px] text-gray-400 font-medium italic">
                *Waktu terbaik untuk follow-up leads & tayang promo
            </span>
        </div>

        <!-- Main Content -->
        <div class="chart-container flex w-full">
            
            <!-- Chart Area -->
            <div class="chart-left p-4 pt-6"
                x-data="{
                    chartData: {{ $chartData }},
                    init() {
                        let chartDom = this.$refs.lineChart;
                        let myChart = echarts.init(chartDom);
                        let option = {
                            tooltip: { trigger: 'axis' },
                            legend: {
                                data: ['Pengunjung', 'Klik WhatsApp', 'Booking'],
                                bottom: 0,
                                textStyle: { fontSize: 11, color: '#6b7280' }
                            },
                            grid: { left: '2%', right: '4%', bottom: '15%', top: '5%', containLabel: true },
                            xAxis: {
                                type: 'category',
                                boundaryGap: false,
                                data: this.chartData.labels,
                                axisLabel: { color: '#9ca3af', fontSize: 10 },
                                axisLine: { show: false },
                                splitLine: { show: true, lineStyle: { color: '#f3f4f6' } }
                            },
                            yAxis: {
                                type: 'value',
                                axisLabel: { color: '#9ca3af', fontSize: 10 },
                                splitLine: { show: true, lineStyle: { color: '#f3f4f6' } }
                            },
                            series: [
                                { name: 'Pengunjung', type: 'line', smooth: true, data: this.chartData.visits, symbol: 'none', itemStyle: { color: '#6366f1' }, areaStyle: { color: 'rgba(99, 102, 241, 0.1)' } },
                                { name: 'Klik WhatsApp', type: 'line', smooth: true, data: this.chartData.waClicks, symbol: 'none', itemStyle: { color: '#10b981' }, areaStyle: { color: 'rgba(16, 185, 129, 0.1)' } },
                                { name: 'Booking', type: 'line', smooth: true, data: this.chartData.bookings, symbol: 'none', itemStyle: { color: '#f59e0b' }, areaStyle: { color: 'rgba(245, 158, 11, 0.1)' } }
                            ]
                        };
                        myChart.setOption(option);
                        window.addEventListener('resize', () => myChart.resize());
                    }
                }"
            >
                <div x-ref="lineChart" style="width: 100%; height: 340px;"></div>
            </div>

            <!-- Sidebar Area: Sources, Cities, Device Brands -->
            <div class="chart-right flex flex-col bg-white dark:bg-gray-900 divide-y divide-gray-100 dark:divide-gray-800">
                <!-- Top Cities (Kota Asal Pengunjung) -->
                <div class="p-4">
                    <div class="flex justify-between items-center mb-3">
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <h2 class="text-xs font-black tracking-wider text-gray-700 dark:text-gray-200 uppercase">Top Kota Asal</h2>
                        </div>
                        <span class="text-[11px] font-bold text-gray-400">Pengunjung</span>
                    </div>
                    @forelse($cities as $c)
                        <div class="relative flex items-center justify-between p-1.5 mb-1 rounded text-xs">
                            <div class="absolute left-0 top-0 bottom-0 bg-emerald-50 dark:bg-emerald-950/30 rounded" style="width: {{ $c->percentage }}%; z-index: 0;"></div>
                            <span class="relative z-10 font-medium text-gray-700 dark:text-gray-300 truncate max-w-[170px]">{{ $c->city }}</span>
                            <span class="relative z-10 font-bold text-gray-900 dark:text-white">{{ $c->total }}</span>
                        </div>
                    @empty
                        <div class="text-xs text-gray-400 italic py-2">Belum ada data kota</div>
                    @endforelse
                </div>

                <!-- Detailed Devices (Merk & Model Perangkat) -->
                <div class="p-4">
                    <div class="flex justify-between items-center mb-3">
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                            <h2 class="text-xs font-black tracking-wider text-gray-700 dark:text-gray-200 uppercase">Perangkat (Devices)</h2>
                        </div>
                        <span class="text-[11px] font-bold text-gray-400">Total</span>
                    </div>
                    @forelse($deviceBrands as $d)
                        <div class="relative flex items-center justify-between p-1.5 mb-1 rounded text-xs">
                            <div class="absolute left-0 top-0 bottom-0 bg-cyan-50 dark:bg-cyan-950/30 rounded" style="width: {{ $d->percentage }}%; z-index: 0;"></div>
                            <span class="relative z-10 font-medium text-gray-700 dark:text-gray-300 truncate max-w-[170px]">{{ $d->device_brand }}</span>
                            <span class="relative z-10 font-bold text-gray-900 dark:text-white">{{ $d->total }}</span>
                        </div>
                    @empty
                        <div class="text-xs text-gray-400 italic py-2">Belum ada data device</div>
                    @endforelse
                </div>

                <!-- Top Sources -->
                <div class="p-4">
                    <div class="flex justify-between items-center mb-3">
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                            <h2 class="text-xs font-black tracking-wider text-gray-700 dark:text-gray-200 uppercase">Sumber Trafik</h2>
                        </div>
                        <span class="text-[11px] font-bold text-gray-400">Pengunjung</span>
                    </div>
                    @foreach($sources as $s)
                        <div class="relative flex items-center justify-between p-1.5 mb-1 rounded text-xs">
                            <div class="absolute left-0 top-0 bottom-0 bg-indigo-50 dark:bg-indigo-950/30 rounded" style="width: {{ $s->percentage }}%; z-index: 0;"></div>
                            <span class="relative z-10 font-medium text-gray-700 dark:text-gray-300">{{ ucfirst($s->source ?: 'Direct') }}</span>
                            <span class="relative z-10 font-bold text-gray-900 dark:text-white">{{ $s->total }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
