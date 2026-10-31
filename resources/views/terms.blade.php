<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Syarat & Ketentuan (Terms of Service) - Hyundai Gowa Surabaya</title>
    <meta name="description" content="Syarat dan ketentuan pembelian mobil baru, pembiayaan kredit, dan layanan dealer Hyundai Gowa HR Muhammad Surabaya.">
    <link rel="canonical" href="{{ url('/terms') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Outfit', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased selection:bg-blue-600 selection:text-white">
    <!-- Header Navigation -->
    <header class="bg-[#002c5f] text-white py-4 shadow-md sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <span class="text-xl font-black tracking-tight">HYUNDAI <span class="text-cyan-400 font-normal">GOWA SURABAYA</span></span>
            </a>
            <a href="{{ url('/') }}" class="text-xs font-bold uppercase tracking-wider text-slate-200 hover:text-white transition flex items-center gap-1.5">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                <span>Kembali ke Beranda</span>
            </a>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 py-12 sm:py-16">
        <div class="bg-white rounded-3xl p-8 sm:p-12 shadow-sm border border-gray-100">
            <div class="border-b border-gray-100 pb-6 mb-8">
                <span class="text-xs font-bold text-blue-600 uppercase tracking-widest bg-blue-50 px-3 py-1 rounded-full">Legal Information</span>
                <h1 class="text-3xl sm:text-4xl font-black text-gray-950 mt-3 tracking-tight">Syarat & Ketentuan Layanan</h1>
                <p class="text-xs text-gray-500 mt-2">Terakhir diperbarui: {{ date('d F Y') }} &bull; Hyundai Gowa Surabaya HR Muhammad</p>
            </div>

            <div class="prose max-w-none text-gray-700 leading-relaxed text-sm space-y-6">
                <h2 class="text-lg font-bold text-gray-950">1. Ketentuan Umum</h2>
                <p>
                    Portal ini dioperasikan untuk memberikan kemudahan informasi mengenai spesifikasi kendaraan, daftar harga OTR Jawa Timur, simulasi perhitungan kredit, layanan tukar tambah, dan pemesanan unit mobil baru Hyundai melalui konsultan resmi kami di Surabaya.
                </p>

                <h2 class="text-lg font-bold text-gray-950 pt-2 border-t border-gray-100">2. Transparansi Harga & Spesifikasi</h2>
                <ul class="list-disc pl-6 space-y-1">
                    <li>Harga yang tertera merupakan harga On The Road (OTR) wilayah Surabaya, Sidoarjo, Gresik, dan sekitarnya (plat nomor L & W) untuk kepemilikan mobil pertama.</li>
                    <li>Harga BBN tidak mengikat dan dapat disesuaikan dengan ketentuan regulasi perpajakan pemerintah daerah yang berlaku.</li>
                    <li>Spesifikasi dan ketersediaan warna unit sewaktu-waktu dapat mengalami pembaruan dari Agen Tunggal Pemegang Merek (PT Hyundai Motors Indonesia).</li>
                </ul>

                <h2 class="text-lg font-bold text-gray-950 pt-2 border-t border-gray-100">3. Simulasi Kredit & Pembiayaan</h2>
                <p>
                    Kalkulator kredit dan estimasi angsuran di situs ini adalah panduan simulasi awal berdasarkan suku bunga acuan perbankan/leasing mitra resmi Hyundai (seperti Maybank Finance, BCA Finance, Mandiri Tunas Finance, dll). Angsuran final dan persetujuan kredit tunduk pada analisa kelayakan dokumen oleh pihak lembaga pembiayaan.
                </p>

                <h2 class="text-lg font-bold text-gray-950 pt-2 border-t border-gray-100">4. Pemesanan Kendaraan (Surat Pesanan Kendaraan / SPK)</h2>
                <p>
                    Pemesanan resmi dilakukan dengan penerbitan Surat Pesanan Kendaraan (SPK) resmi dari PT Gowa Modern Motor (Hyundai Gowa) dan pembayaran tanda jadi hanya disetorkan ke rekening resmi perusahaan dealer, bukan ke rekening perorangan.
                </p>

                <h2 class="text-lg font-bold text-gray-950 pt-2 border-t border-gray-100">5. Layanan Konsultasi & Test Drive</h2>
                <p>
                    Layanan konsultasi dan pengajuan jadwal test drive dapat dilakukan tanpa dipungut biaya apapun (gratis). Unit test drive dapat dihadirkan di showroom Hyundai HR Muhammad maupun dijadwalkan ke alamat domisili calon konsumen di area Surabaya dan sekitarnya.
                </p>
            </div>
        </div>
    </main>

    <footer class="bg-slate-900 text-slate-400 py-8 border-t border-slate-800 text-center text-xs">
        <p>&copy; {{ date('Y') }} Hyundai Gowa HR Muhammad Surabaya. Semua hak dilindungi undang-undang.</p>
    </footer>
</body>
</html>
