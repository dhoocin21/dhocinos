<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Header Utama --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6 pb-4 border-b border-gray-100 dark:border-white/10">
            <div>
                <div class="flex items-center gap-2">
                    <span class="p-1.5 rounded-lg bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </span>
                    <h2 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">Heatmap Aktivitas Kunjungan</h2>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Peta intensitas kunjungan per jam & rekaman stamp aktivitas platform real-time.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    {{ $totalTodayVisits }} Kunjungan Hari Ini
                </span>
            </div>
        </div>
        
        {{-- 1. ECharts Heatmap Chart --}}
        <div 
            x-data="{
                chartData: {{ $chartData }},
                maxValue: {{ $maxValue }},
                init() {
                    let chartDom = this.$refs.heatmapChart;
                    let myChart = echarts.init(chartDom);
                    
                    const hours = [
                        '12a', '1a', '2a', '3a', '4a', '5a', '6a',
                        '7a', '8a', '9a', '10a', '11a',
                        '12p', '1p', '2p', '3p', '4p', '5p',
                        '6p', '7p', '8p', '9p', '10p', '11p'
                    ];
                    const days = [
                        'Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'
                    ];

                    let option = {
                        tooltip: {
                            position: 'top',
                            formatter: function (params) {
                                return days[params.value[1]] + ' ' + hours[params.value[0]] + '<br/>Total: ' + params.value[2] + ' Pengunjung';
                            }
                        },
                        grid: {
                            height: '70%',
                            top: '5%',
                            left: '2%',
                            right: '2%',
                            containLabel: true
                        },
                        xAxis: {
                            type: 'category',
                            data: hours,
                            axisLabel: {
                                interval: 'auto',
                                fontSize: 10,
                                color: '#9ca3af'
                            },
                            splitArea: {
                                show: true
                            }
                        },
                        yAxis: {
                            type: 'category',
                            data: days,
                            axisLabel: {
                                fontSize: 11,
                                color: '#9ca3af'
                            },
                            splitArea: {
                                show: true
                            }
                        },
                        visualMap: {
                            min: 0,
                            max: this.maxValue,
                            calculable: true,
                            orient: 'horizontal',
                            left: 'center',
                            bottom: '0%',
                            itemWidth: 12,
                            itemHeight: 140,
                            inRange: {
                                color: ['#ebedf0', '#9be9a8', '#40c463', '#30a14e', '#216e39']
                            },
                            textStyle: {
                                color: '#9ca3af'
                            }
                        },
                        series: [{
                            name: 'Kunjungan',
                            type: 'heatmap',
                            data: this.chartData,
                            label: {
                                show: false
                            },
                            emphasis: {
                                itemStyle: {
                                    shadowBlur: 10,
                                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                                }
                            }
                        }]
                    };

                    myChart.setOption(option);
                    window.addEventListener('resize', function() {
                        myChart.resize();
                    });
                }
            }"
            class="mb-8"
        >
            <div x-ref="heatmapChart" class="w-full" style="height: 280px;"></div>
        </div>

        {{-- 2. Ringkasan Platform Hari Ini (Windows, Android, iPhone) --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <span class="p-1 rounded bg-amber-500/10 text-amber-600 dark:text-amber-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </span>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Ringkasan Jam & Lokasi Kunjungan Hari Ini</h3>
                </div>
                <span class="text-xs text-gray-400">Dikelompokkan Berdasarkan OS Perangkat</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Card Windows --}}
                @php $win = $platformHighlights['windows'] ?? null; @endphp
                <div class="relative overflow-hidden rounded-xl border border-blue-200/70 dark:border-blue-900/40 bg-gradient-to-br from-blue-50/50 via-white to-blue-50/20 dark:from-blue-950/20 dark:via-gray-900 dark:to-blue-950/10 p-4 transition-all duration-200 hover:shadow-md">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2.5">
                            <div class="p-2 rounded-lg bg-blue-500/10 text-blue-600 dark:text-blue-400">
                                {{-- Windows Icon --}}
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                    <path d="M0 3.449L9.75 2.1v9.451H0m10.949-9.602L24 0v11.4H10.949M0 12.6h9.75v9.451L0 20.699M10.949 12.6H24V24l-12.949-1.801"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-gray-900 dark:text-white">Windows</h4>
                                <span class="text-[11px] text-gray-500 dark:text-gray-400">Desktop / PC</span>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800 dark:bg-blue-900/60 dark:text-blue-300">
                            {{ $win['count'] ?? 0 }} Sesi
                        </span>
                    </div>

                    {{-- Highlight Statement --}}
                    <div class="p-2.5 rounded-lg bg-white/80 dark:bg-gray-800/80 border border-blue-100 dark:border-blue-900/30 mb-3 shadow-xs">
                        <p class="text-xs font-medium text-gray-800 dark:text-gray-200 leading-relaxed">
                            <span class="font-semibold text-blue-600 dark:text-blue-400">Windows :</span> {{ $win['sentence'] ?? 'Belum ada kunjungan.' }}
                        </p>
                    </div>

                    {{-- Chips Kunjungan --}}
                    @if(!empty($win['items']))
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($win['items'] as $it)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-medium bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200/50 dark:border-blue-800/50">
                                    <svg class="w-3 h-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $it['time'] }}
                                    <span class="opacity-40">•</span>
                                    <span>{{ $it['city'] }}</span>
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Card Android --}}
                @php $android = $platformHighlights['android'] ?? null; @endphp
                <div class="relative overflow-hidden rounded-xl border border-emerald-200/70 dark:border-emerald-900/40 bg-gradient-to-br from-emerald-50/50 via-white to-emerald-50/20 dark:from-emerald-950/20 dark:via-gray-900 dark:to-emerald-950/10 p-4 transition-all duration-200 hover:shadow-md">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2.5">
                            <div class="p-2 rounded-lg bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                                {{-- Android Icon --}}
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                    <path d="M17.523 15.3414c-.5511 0-.9993-.4486-.9993-.9997s.4482-.9993.9993-.9993c.551 0 .9993.4482.9993.9993.0001.5511-.4483.9997-.9993.9997m-11.046 0c-.5511 0-.9993-.4486-.9993-.9997s.4482-.9993.9993-.9993c.5511 0 .9993.4482.9993.9993 0 .5511-.4482.9997-.9993.9997m11.4045-6.02l1.9973-3.4592a.416.416 0 00-.1521-.5676.416.416 0 00-.5676.1521l-2.0223 3.503C15.5902 8.411 13.8533 8.1 12 8.1s-3.5902.311-5.1367.8497L4.841 5.4467a.4161.4161 0 00-.5677-.1521.4157.4157 0 00-.152 5676l1.9972 3.4592C2.6889 11.1867.3432 14.6589 0 18.761h24c-.3432-4.1021-2.6889-7.5743-6.1185-9.4396"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-gray-900 dark:text-white">Android</h4>
                                <span class="text-[11px] text-gray-500 dark:text-gray-400">Mobile / Smartphone</span>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-300">
                            {{ $android['count'] ?? 0 }} Sesi
                        </span>
                    </div>

                    {{-- Highlight Statement --}}
                    <div class="p-2.5 rounded-lg bg-white/80 dark:bg-gray-800/80 border border-emerald-100 dark:border-emerald-900/30 mb-3 shadow-xs">
                        <p class="text-xs font-medium text-gray-800 dark:text-gray-200 leading-relaxed">
                            <span class="font-semibold text-emerald-600 dark:text-emerald-400">Android :</span> {{ $android['sentence'] ?? 'Belum ada kunjungan.' }}
                        </p>
                    </div>

                    {{-- Chips Kunjungan --}}
                    @if(!empty($android['items']))
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($android['items'] as $it)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-medium bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200/50 dark:border-emerald-800/50">
                                    <svg class="w-3 h-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $it['time'] }}
                                    <span class="opacity-40">•</span>
                                    <span>{{ $it['city'] }}</span>
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Card iPhone / iOS --}}
                @php $iphone = $platformHighlights['iphone'] ?? null; @endphp
                <div class="relative overflow-hidden rounded-xl border border-purple-200/70 dark:border-purple-900/40 bg-gradient-to-br from-purple-50/50 via-white to-purple-50/20 dark:from-purple-950/20 dark:via-gray-900 dark:to-purple-950/10 p-4 transition-all duration-200 hover:shadow-md">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2.5">
                            <div class="p-2 rounded-lg bg-purple-500/10 text-purple-600 dark:text-purple-400">
                                {{-- Apple Icon --}}
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                    <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 6.37c.62-.75 1.04-1.8 0.92-2.85-.9.04-1.99.6-2.64 1.35-.57.65-1.07 1.72-.94 2.74 1.01.08 2.04-.49 2.66-1.24z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-gray-900 dark:text-white">iPhone</h4>
                                <span class="text-[11px] text-gray-500 dark:text-gray-400">Apple iOS</span>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-100 text-purple-800 dark:bg-purple-900/60 dark:text-purple-300">
                            {{ $iphone['count'] ?? 0 }} Sesi
                        </span>
                    </div>

                    {{-- Highlight Statement --}}
                    <div class="p-2.5 rounded-lg bg-white/80 dark:bg-gray-800/80 border border-purple-100 dark:border-purple-900/30 mb-3 shadow-xs">
                        <p class="text-xs font-medium text-gray-800 dark:text-gray-200 leading-relaxed">
                            <span class="font-semibold text-purple-600 dark:text-purple-400">iPhone :</span> {{ $iphone['sentence'] ?? 'Belum ada kunjungan.' }}
                        </p>
                    </div>

                    {{-- Chips Kunjungan --}}
                    @if(!empty($iphone['items']))
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($iphone['items'] as $it)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-medium bg-purple-50 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 border border-purple-200/50 dark:border-purple-800/50">
                                    <svg class="w-3 h-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $it['time'] }}
                                    <span class="opacity-40">•</span>
                                    <span>{{ $it['city'] }}</span>
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- 3. Stamp Detail Kunjungan (Tabel Stamp Terkini) --}}
        <div 
            x-data="{
                filterPlatform: 'all',
                searchQuery: '',
                stamps: {{ json_encode($recentStamps) }},
                get filteredStamps() {
                    return this.stamps.filter(item => {
                        let matchPlatform = this.filterPlatform === 'all' || item.platform_type === this.filterPlatform;
                        let query = this.searchQuery.toLowerCase();
                        let matchQuery = !query || 
                            item.city.toLowerCase().includes(query) || 
                            item.region.toLowerCase().includes(query) || 
                            item.ip_address.toLowerCase().includes(query) || 
                            item.car_name.toLowerCase().includes(query) || 
                            item.device_brand.toLowerCase().includes(query);
                        return matchPlatform && matchQuery;
                    });
                }
            }"
            class="pt-4 border-t border-gray-100 dark:border-white/10"
        >
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="p-1 rounded bg-indigo-500/10 text-indigo-600 dark:text-indigo-400">
                            {{-- Stamp / Audit Icon --}}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </span>
                        <h3 class="text-sm font-bold uppercase tracking-wider text-gray-800 dark:text-white">Stamp Detail Kunjungan</h3>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
                            Log Riwayat Real-Time
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Catatan stempel waktu, IP address publik/lokal, kota & provinsi, perangkat, dan unit kendaraan yang dikunjungi.</p>
                </div>

                {{-- Filter & Search Controls --}}
                <div class="flex flex-wrap items-center gap-2">
                    {{-- Platform Tabs --}}
                    <div class="inline-flex rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-0.5 text-xs">
                        <button 
                            type="button"
                            @click="filterPlatform = 'all'" 
                            :class="filterPlatform === 'all' ? 'bg-white dark:bg-gray-700 shadow-xs font-bold text-gray-900 dark:text-white' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400'"
                            class="px-2.5 py-1 rounded-md transition-colors"
                        >
                            Semua
                        </button>
                        <button 
                            type="button"
                            @click="filterPlatform = 'windows'" 
                            :class="filterPlatform === 'windows' ? 'bg-blue-600 text-white font-bold shadow-xs' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400'"
                            class="px-2.5 py-1 rounded-md transition-colors"
                        >
                            Windows
                        </button>
                        <button 
                            type="button"
                            @click="filterPlatform = 'android'" 
                            :class="filterPlatform === 'android' ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400'"
                            class="px-2.5 py-1 rounded-md transition-colors"
                        >
                            Android
                        </button>
                        <button 
                            type="button"
                            @click="filterPlatform = 'iphone'" 
                            :class="filterPlatform === 'iphone' ? 'bg-purple-600 text-white font-bold shadow-xs' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400'"
                            class="px-2.5 py-1 rounded-md transition-colors"
                        >
                            iPhone
                        </button>
                    </div>

                    {{-- Search Input --}}
                    <div class="relative">
                        <input 
                            type="text" 
                            x-model="searchQuery" 
                            placeholder="Cari IP / Kota / Mobil..." 
                            class="w-44 text-xs rounded-lg border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white pl-7 pr-2.5 py-1 focus:ring-1 focus:ring-amber-500 focus:border-amber-500"
                        >
                        <svg class="w-3.5 h-3.5 text-gray-400 absolute left-2 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Stamp Table / List --}}
            <div class="overflow-x-auto rounded-xl border border-gray-200/80 dark:border-white/10 shadow-xs">
                <table class="w-full text-left text-xs">
                    <thead class="bg-gray-50 dark:bg-gray-800/80 text-gray-500 dark:text-gray-400 uppercase text-[10px] tracking-wider border-b border-gray-200/70 dark:border-white/10">
                        <tr>
                            <th class="px-3.5 py-2.5 font-bold">Waktu Stamp</th>
                            <th class="px-3.5 py-2.5 font-bold">Perangkat & OS</th>
                            <th class="px-3.5 py-2.5 font-bold">Alamat IP</th>
                            <th class="px-3.5 py-2.5 font-bold">Lokasi Pengunjung</th>
                            <th class="px-3.5 py-2.5 font-bold">Halaman / Mobil Dilihat</th>
                            <th class="px-3.5 py-2.5 font-bold">Sumber & Durasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/5 bg-white dark:bg-gray-900/50">
                        <template x-for="item in filteredStamps" :key="item.id">
                            <tr class="hover:bg-gray-50/70 dark:hover:bg-white/5 transition-colors">
                                {{-- Waktu Stamp --}}
                                <td class="px-3.5 py-2.5 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="px-2 py-1 rounded bg-amber-50 dark:bg-amber-950/40 border border-amber-200/60 dark:border-amber-800/50 text-amber-900 dark:text-amber-200 font-mono font-bold text-[11px] shadow-2xs">
                                            <span x-text="item.time"></span>
                                        </div>
                                        <span class="text-[10px] text-gray-400" x-text="item.date_label"></span>
                                    </div>
                                </td>

                                {{-- Perangkat & OS --}}
                                <td class="px-3.5 py-2.5 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        {{-- Windows Badge --}}
                                        <template x-if="item.platform_type === 'windows'">
                                            <span class="p-1 rounded bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400">
                                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M0 3.449L9.75 2.1v9.451H0m10.949-9.602L24 0v11.4H10.949M0 12.6h9.75v9.451L0 20.699M10.949 12.6H24V24l-12.949-1.801"/></svg>
                                            </span>
                                        </template>
                                        {{-- Android Badge --}}
                                        <template x-if="item.platform_type === 'android'">
                                            <span class="p-1 rounded bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400">
                                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M17.523 15.3414c-.5511 0-.9993-.4486-.9993-.9997s.4482-.9993.9993-.9993c.551 0 .9993.4482.9993.9993.0001.5511-.4483.9997-.9993.9997m-11.046 0c-.5511 0-.9993-.4486-.9993-.9997s.4482-.9993.9993-.9993c.5511 0 .9993.4482.9993.9993 0 .5511-.4482.9997-.9993.9997m11.4045-6.02l1.9973-3.4592a.416.416 0 00-.1521-.5676.416.416 0 00-.5676.1521l-2.0223 3.503C15.5902 8.411 13.8533 8.1 12 8.1s-3.5902.311-5.1367.8497L4.841 5.4467a.4161.4161 0 00-.5677-.1521.4157.4157 0 00-.152 5676l1.9972 3.4592C2.6889 11.1867.3432 14.6589 0 18.761h24c-.3432-4.1021-2.6889-7.5743-6.1185-9.4396"/></svg>
                                            </span>
                                        </template>
                                        {{-- Apple / iPhone Badge --}}
                                        <template x-if="item.platform_type === 'iphone'">
                                            <span class="p-1 rounded bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400">
                                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 6.37c.62-.75 1.04-1.8 0.92-2.85-.9.04-1.99.6-2.64 1.35-.57.65-1.07 1.72-.94 2.74 1.01.08 2.04-.49 2.66-1.24z"/></svg>
                                            </span>
                                        </template>
                                        {{-- Fallback --}}
                                        <template x-if="item.platform_type === 'other'">
                                            <span class="p-1 rounded bg-gray-100 dark:bg-gray-800 text-gray-500">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                            </span>
                                        </template>

                                        <div>
                                            <div class="font-bold text-gray-900 dark:text-white" x-text="item.os_platform"></div>
                                            <div class="text-[10px] text-gray-400">
                                                <span x-text="item.device_brand"></span> • <span x-text="item.browser_name"></span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Alamat IP --}}
                                <td class="px-3.5 py-2.5 whitespace-nowrap">
                                    <span class="font-mono text-[11px] font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800/80 px-2 py-0.5 rounded border border-gray-200/50 dark:border-gray-700/50">
                                        <span x-text="item.ip_address"></span>
                                    </span>
                                </td>

                                {{-- Lokasi Pengunjung --}}
                                <td class="px-3.5 py-2.5 whitespace-nowrap">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-rose-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                        </svg>
                                        <div>
                                            <span class="font-semibold text-gray-900 dark:text-white" x-text="item.city"></span>,
                                            <span class="text-gray-500 dark:text-gray-400 text-[11px]" x-text="item.region"></span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Halaman / Mobil --}}
                                <td class="px-3.5 py-2.5 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-medium bg-amber-50 dark:bg-amber-950/40 text-amber-800 dark:text-amber-300 border border-amber-200/50 dark:border-amber-800/40">
                                        <svg class="w-3 h-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                        <span x-text="item.car_name"></span>
                                    </span>
                                </td>

                                {{-- Sumber & Durasi --}}
                                <td class="px-3.5 py-2.5 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300" x-text="item.source"></span>
                                        <span class="text-gray-400 text-[10px] font-mono flex items-center gap-0.5">
                                            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span x-text="item.duration_text"></span>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        </template>

                        {{-- Empty State --}}
                        <tr x-show="filteredStamps.length === 0">
                            <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center gap-1">
                                    <svg class="w-6 h-6 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <p class="text-xs">Tidak ada data stamp kunjungan yang sesuai dengan filter.</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
