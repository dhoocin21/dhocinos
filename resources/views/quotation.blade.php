<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Penawaran Resmi - {{ $car->name }} (Hyundai Gowa Surabaya)</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Outfit', sans-serif; }
        @media print {
            @page {
                size: A4 portrait;
                margin: 10mm 12mm 10mm 12mm;
            }
            body {
                background: white !important;
                color: black !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .print-shadow-none {
                box-shadow: none !important;
                border: 1px solid #e5e7eb !important;
            }
        }
    </style>
</head>
<body class="bg-slate-100 text-gray-900 min-h-screen py-8 px-4 sm:px-6">

    <!-- Top Action Bar (Screen Only) -->
    <div class="max-w-4xl mx-auto mb-6 flex flex-wrap items-center justify-between gap-4 no-print">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-600 hover:text-[#002c5f] transition">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m15 18-6-6 6-6"/></svg>
            <span>Kembali ke Showroom</span>
        </a>

        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-5 py-2.5 bg-[#002c5f] hover:bg-blue-900 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition flex items-center gap-2 shadow-lg shadow-blue-900/20">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2M6 9V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v5"/><rect width="12" height="8" x="6" y="14" rx="1" ry="1"/></svg>
                <span>Cetak / Simpan PDF</span>
            </button>

            @if($consultant)
                <a href="{{ route('track.wa', ['text' => "Halo Mas Nico, saya sudah melihat Surat Penawaran Resmi unit {$car->name} (OTR Rp " . number_format($car->price, 0, ',', '.') . "). Mohon info ketersediaan unit dan diskon terbaiknya."]) }}" target="_blank" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition flex items-center gap-2 shadow-lg shadow-emerald-600/20">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
                    <span>Kirim ke WhatsApp</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Official A4 Quotation Sheet Container -->
    <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-xl border border-gray-200 p-8 sm:p-12 print-shadow-none">
        <!-- Letterhead Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between pb-6 border-b-2 border-[#002c5f] gap-6">
            <div>
                <div class="flex items-center gap-3">
                    <span class="text-2xl font-black text-[#002c5f] tracking-widest uppercase">HYUNDAI</span>
                    <span class="text-xs bg-blue-100 text-blue-900 font-bold px-2 py-0.5 rounded tracking-wider uppercase">Gowa Surabaya</span>
                </div>
                <p class="text-[11px] text-gray-500 font-medium mt-1">
                    Dealer Resmi Hyundai HR Muhammad Surabaya<br>
                    Jl. Mayjen HR. Muhammad No.35C, Sukomanunggal, Surabaya, Jawa Timur
                </p>
            </div>

            <div class="text-left sm:text-right">
                <span class="text-[10px] font-black uppercase tracking-widest text-blue-600 block mb-1">Official Quotation</span>
                <div class="text-xs font-mono font-bold text-gray-900">
                    NO: QUO/HYU/{{ date('Ymd') }}/{{ str_pad($car->id, 4, '0', STR_PAD_LEFT) }}
                </div>
                <div class="text-[10px] text-gray-500 mt-0.5">
                    Tanggal: {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}
                </div>
            </div>
        </div>

        <!-- Vehicle Details Banner -->
        <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50/30 p-6 rounded-2xl border border-blue-100 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="space-y-1 text-center md:text-left">
                <span class="text-[10px] font-black uppercase tracking-widest text-blue-600">Unit Kendaraan</span>
                <h2 class="text-2xl sm:text-3xl font-black text-[#002c5f] uppercase">{{ $car->name }}</h2>
                <p class="text-xs text-gray-600 font-semibold">
                    Kategori: <span class="uppercase font-bold text-gray-900">{{ $car->category }}</span> | OTR Surabaya & Jatim
                </p>
                <div class="text-xl sm:text-2xl font-black text-gray-900 pt-2">
                    Rp {{ number_format($car->price, 0, ',', '.') }}
                </div>
            </div>

            @if($car->image)
                <div class="w-48 h-28 flex items-center justify-center">
                    <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" class="max-h-full max-w-full object-contain drop-shadow-md">
                </div>
            @endif
        </div>

        <!-- Financing Schedule Breakdown Table -->
        <div class="mt-8">
            <h3 class="text-xs font-black uppercase tracking-widest text-[#002c5f] mb-3">Rincian Simulasi Pembiayaan Kredit</h3>
            <table class="w-full text-xs text-left border border-gray-200 rounded-xl overflow-hidden">
                <tbody class="divide-y divide-gray-100">
                    <tr class="bg-gray-50/80">
                        <td class="py-3 px-4 font-bold text-gray-600 w-1/2">Harga OTR (On The Road)</td>
                        <td class="py-3 px-4 font-bold text-gray-900 text-right">Rp {{ number_format($car->price, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-4 font-bold text-gray-600">Uang Muka (DP {{ $dpPercent }}%)</td>
                        <td class="py-3 px-4 font-bold text-blue-700 text-right">Rp {{ number_format($dpAmount, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="bg-gray-50/80">
                        <td class="py-3 px-4 font-bold text-gray-600">Pokok Hutang Pembiayaan</td>
                        <td class="py-3 px-4 font-bold text-gray-900 text-right">Rp {{ number_format(max(0, $car->price - $dpAmount), 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-4 font-bold text-gray-600">Jangka Waktu Pembiayaan (Tenor)</td>
                        <td class="py-3 px-4 font-bold text-gray-900 text-right">{{ $tenor }} Bulan ({{ round($tenor / 12, 1) }} Tahun)</td>
                    </tr>
                    <tr class="bg-gray-50/80">
                        <td class="py-3 px-4 font-bold text-gray-600">Jenis Perlindungan Asuransi</td>
                        <td class="py-3 px-4 font-bold text-gray-900 uppercase text-right">{{ str_replace('_', ' ', $insuranceType) }}</td>
                    </tr>
                    <tr class="bg-blue-600 text-white">
                        <td class="py-4 px-4 font-black uppercase tracking-wider text-sm">Estimasi Angsuran / Bulan</td>
                        <td class="py-4 px-4 font-black text-right text-base sm:text-lg">Rp {{ number_format($installment, 0, ',', '.') }} /bln</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Terms & Notes -->
        <div class="mt-8 text-[10px] text-gray-500 leading-relaxed border-t border-gray-100 pt-4">
            <h4 class="font-bold uppercase tracking-wider text-gray-700 mb-1">Syarat & Ketentuan:</h4>
            <ol class="list-decimal pl-4 space-y-0.5">
                <li>Harga On The Road (OTR) sewaktu-waktu dapat berubah mengikuti ketentuan BBNKB wilayah Jawa Timur.</li>
                <li>Simulasi pembiayaan kredit ini bersifat indikatif acuan. Penawaran bunga & diskon resmi berlaku saat SPK (Surat Pemesanan Kendaraan).</li>
                <li>Sudah termasuk garansi resmi mesin, garansi baterai EV 8 tahun / 160.000 KM (khusus kendaraan listrik), dan servis berkala gratis.</li>
            </ol>
        </div>

        <!-- Sales Signature & Verification Block -->
        <div class="mt-8 pt-6 border-t-2 border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="text-center sm:text-left">
                <span class="text-[9px] font-black uppercase tracking-widest text-blue-600 block mb-1">Sales Consultant Resmi</span>
                <div class="text-base font-black text-[#002c5f] uppercase">{{ $consultant->name ?? 'NICO HARDIANSYAH' }}</div>
                <div class="text-xs text-gray-600 font-semibold mt-0.5">Telp/WA: {{ $consultant->phone ?? '0813-3013-5013' }}</div>
                <div class="text-[10px] text-gray-400 mt-0.5">{{ $consultant->address ?? 'Hyundai HR Muhammad Surabaya' }}</div>
            </div>

            <div class="text-center sm:text-right border-t sm:border-t-0 sm:border-l border-gray-200 pt-4 sm:pt-0 sm:pl-8">
                <div class="w-24 h-12 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center text-[10px] text-gray-400 font-bold uppercase mx-auto sm:ml-auto">
                    Verified Seal
                </div>
                <p class="text-[9px] text-gray-400 font-mono mt-1">GOWA AUTOMOTIVE SURABAYA</p>
            </div>
        </div>
    </div>

</body>
</html>
