#!/data/data/com.termux/files/usr/bin/bash
# ==============================================================================
# SCRIPT START SERVER HYUNDAI (PORT 8000 + CLOUDFLARE PUBLIC HTTPS)
# ==============================================================================

echo "=========================================================="
echo "⚡ MENYALAKAN SERVER HYUNDAI GOWA SURABAYA"
echo "=========================================================="

# 1. Pastikan MariaDB berjalan
if ! pgrep -x "mariadbd" > /dev/null && ! pgrep -x "mysqld" > /dev/null; then
    echo "Memulai daemon MariaDB..."
    mysqld_safe --skip-syslog > /dev/null 2>&1 &
    sleep 3
else
    echo "✅ MariaDB Database sudah berjalan."
fi

# 2. Cek database & storage link
mariadb -u root -e "CREATE DATABASE IF NOT EXISTS hyundaisurabayadb;" > /dev/null 2>&1

echo "📁 Menyiapkan folder penyimpanan gambar..."
# Hapus broken symlink / reparse point jika ada
if [ -L "public/storage" ] || [ -f "public/storage" ]; then
    if [ ! -e "public/storage" ] || [ ! -d "public/storage/cars" ]; then
        rm -rf public/storage
    fi
fi

# Pastikan folder penyimpanan gambar terhubung atau disalin
if [ ! -d "public/storage/cars" ]; then
    rm -rf public/storage
    # Coba buat symlink standar Linux
    php artisan storage:link > /dev/null 2>&1
    
    # Jika symlink tidak berhasil (karena storage Android), salin fisik
    if [ ! -d "public/storage/cars" ]; then
        rm -rf public/storage
        mkdir -p public/storage
        cp -rf storage/app/public/* public/storage/ > /dev/null 2>&1
    fi
fi

# Jika public/storage adalah folder fisik biasa (bukan symlink), sinkronkan file terbaru
if [ -d "public/storage" ] && [ ! -L "public/storage" ]; then
    cp -rf storage/app/public/* public/storage/ > /dev/null 2>&1
fi


# 3. Jalankan Cloudflare Tunnel di background untuk Domain Publik Gratis
echo "🌐 Menghubungkan Cloudflare Tunnel (Domain Publik Bebas Akses Tanpa IP Publik)..."
pkill -f "cloudflared tunnel" > /dev/null 2>&1
cloudflared tunnel --url http://127.0.0.1:8000 > ~/cloudflare.log 2>&1 &

sleep 3
echo "Mendapatkan tautan publik Cloudflare..."
CF_URL=$(grep -o 'https://[-a-zA-Z0-9@:%._\+~#=]\+\.trycloudflare\.com' ~/cloudflare.log | head -n 1)

echo "=========================================================="
if [ -n "$CF_URL" ]; then
    echo "🎉 WEBSITE PUBLIK ONLINE (BISA DIAKSES SIAPA SAJA DARI INTERNET):"
    echo "👉 $CF_URL"
    echo ""
    echo "PANEL ADMIN:"
    echo "👉 $CF_URL/admin"
else
    echo "⚠️ Cloudflare tunnel sedang menyambung, periksa log dengan: cat ~/cloudflare.log"
fi
echo "=========================================================="
echo "📶 AKSES LOKAL WI-FI:"
IP_LOCAL=$(ifconfig wlan0 2>/dev/null | awk '/inet / {print $2}')
if [ -n "$IP_LOCAL" ]; then
    echo "👉 http://$IP_LOCAL:8000"
fi
echo "=========================================================="
echo ""
echo "🚀 Memulai Laravel Server di Port 8000..."
php artisan serve --host=0.0.0.0 --port=8000
