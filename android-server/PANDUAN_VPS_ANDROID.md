# 📱 PANDUAN LENGKAP: MENGUBAH HP ANDROID MENJADI VPS & WEBSERVER 24/7
### Project: Promo Hyundai Surabaya (Laravel 12 + MySQL/SQLite + Cloudflare Tunnel)

Dokumen ini menjelaskan cara mengubah smartphone Android Anda menjadi **VPS (Virtual Private Server) mandiri** yang berfungsi penuh untuk meng-hosting website dealer Hyundai Surabaya beserta panel admin, database, dan akses publik internet tanpa biaya bulanan VPS.

---

## 📦 1. Komponen yang Disediakan

1. **Aplikasi Android Siap Pakai (`Hyundai-VPS-Server.apk`)**
   - Berada di root folder: `D:\PROJECT APLIKASI\ProjectSales-main\Hyundai-VPS-Server.apk`
   - Berfungsi sebagai **Pusat Kontrol VPS**, menjaga CPU & WiFi HP tetap aktif 24/7 (*WakeLock & WifiLock*), memantau suhu baterai, penggunaan RAM, alamat IP, serta dilengkapi **In-App Web Viewer** & Terminal Log.
2. **Paket Skrip Otomasi Server (`android-server/`)**
   - `android-server/install.sh`: Otomatis menginstall PHP, Composer, Git, Database, dan Cloudflared.
   - `android-server/start.sh`: Menyalakan webserver di port 8000 + Cloudflare Public HTTPS Tunnel.
   - `android-server/stop.sh`: Mematikan server secara aman.
   - `android-server/status.sh`: Cek status server via terminal.
   - `android-server/termux-boot.sh`: Autostart otomatis saat HP di-reboot.

---

## 🚀 2. Cara Kerja Android Menggantikan VPS

1. **Kenapa HP Android Bisa Menggantikan VPS?**
   - Smartphone Android modern berbasis kernel Linux dengan prosesor Octa-Core dan RAM 4GB - 12GB, yang jauh lebih kuat dibanding VPS Entry-Level (1 vCPU, 1GB RAM).
   - Konsumsi listrik smartphone hanya **5 - 10 Watt**, jauh lebih hemat dibanding menyalakan PC/Laptop server 24 jam.
2. **Solusi Akses Publik (Bypass CGNAT Provider Seluler/WiFi):**
   - Provider HP (Telkomsel, Indosat, XL, dsb.) maupun WiFi rumah umumnya tidak memberikan IP Publik Statis.
   - Sistem ini menggunakan **Cloudflare Tunnel (`cloudflared`)** bawaan yang membuat terowongan HTTPS langsung dari HP ke CDN global Cloudflare.
   - Siapa pun di seluruh dunia bisa mengakses website Anda via URL aman HTTPS resmi (contoh: `https://xyz.trycloudflare.com` atau domain kustom Anda).

---

## 🛠️ 3. Langkah Instalasi di HP Android

### Langkah A: Install Aplikasi Pengontrol VPS (`Hyundai-VPS-Server.apk`)
1. Salin file `Hyundai-VPS-Server.apk` ke HP Android Anda (bisa lewat WhatsApp, Google Drive, atau kabel USB).
2. Install APK tersebut di HP (izinkan instalasi dari sumber tidak dikenal).
3. Buka aplikasi **Hyundai VPS Server**.
4. Izinkan notifikasi dan berikan izin **Abaikan Pengoptimalan Baterai (*Ignore Battery Optimization*)** pada tombol yang tersedia agar sistem Android tidak mematikan server saat HP terkunci.

---

### Langkah B: Menjalankan Engine Web Server di Termux
1. Download dan pasang **Termux** di HP (disarankan unduh dari **F-Droid** atau GitHub Termux resmi, bukan Play Store).
2. Buka Termux, lalu jalankan perintah instalasi otomatis berikut:
   ```bash
   pkg update -y && pkg install -y git php composer mariadb cloudflared nano
   git clone https://github.com/project/hyundai-sales.git hyundai
   cd hyundai
   bash android-server/install.sh
   ```
3. Setelah instalasi selesai, jalankan server dan Cloudflare Tunnel:
   ```bash
   bash android-server/start.sh
   ```
4. Terminal akan menampilkan:
   - **URL Akses Lokal**: `http://192.168.x.x:8000`
   - **URL Akses Publik Global**: `https://[nama-random].trycloudflare.com`

---

## ⚡ 4. Fitur Aplikasi Android "Hyundai VPS Server"

* **Master Status Switch**: Menghidupkan *Keep-Alive Foreground Service* dengan notifikasi persisten agar CPU HP tidak masuk ke mode tidur (*Doze Mode*).
* **Network Card**: Menampilkan IP Lokal HP dan Public Tunnel URL dengan 1 tombol *Salin* dan 1 tombol *Buka Web*.
* **Hardware & Battery Telemetry**:
  * Real-time RAM meter (Penggunaan vs Total RAM).
  * Pemantau Suhu Baterai (°C) — Memberikan peringatan visual merah jika suhu melebihi 42°C untuk keamanan HP.
  * Status pengisian daya baterai.
* **In-App Web Viewer**:
  * Menjelajahi website showroom langsung di dalam aplikasi HP.
  * Tombol navigasi instan ke Web Publik dan Panel Admin (`/admin`).
* **Terminal Logs Tab**:
  * Melihat riwayat ping, request HTTP 200, dan status koneksi webserver.
* **Panduan Interaktif**:
  * Panduan lengkap dengan tombol 1-klik untuk menyalin semua skrip.

---

## 💡 5. Tips HP Android Awet & Tangguh Berjalan 24 Jam

1. **Batasi Pengisian Daya Baterai (Bypass Charging / Protect Battery)**:
   - Aktifkan fitur *Protect Battery* bawaan HP (contoh di Samsung batasi di 80-85%).
   - Jika HP di-root atau menggunakan smart plug, atur agar baterai tidak terus-menerus di 100% untuk mencegah baterai kembung.
2. **Sirkulasi Udara**:
   - Letakkan HP di atas dudukan/stand terbuka. Jika ditempatkan di server rak, gunakan mini kipas USB 5V.
3. **Autostart saat HP Menyala (Termux:Boot)**:
   - Install aplikasi pendamping **Termux:Boot**.
   - Salin file `android-server/termux-boot.sh` ke folder `~/.termux/boot/start.sh`:
     ```bash
     mkdir -p ~/.termux/boot
     cp android-server/termux-boot.sh ~/.termux/boot/start.sh
     chmod +x ~/.termux/boot/start.sh
     ```
   - Dengan ini, bila HP sempat mati kehabisan daya dan kemudian dicolok kembali, server web akan otomatis menyala sendiri tanpa perlu disentuh.
