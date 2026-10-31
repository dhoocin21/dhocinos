#!/data/data/com.termux/files/usr/bin/bash
# ==============================================================================
# SCRIPT SETUP OTOMATIS: WEBSERVER HYUNDAI DI ANDROID (PENGGANTI VPS)
# ==============================================================================

echo "=========================================================="
echo "🚀 MEMULAI INSTALASI WEBSERVER HYUNDAI DI ANDROID"
echo "=========================================================="

# 1. Update Termux Packages
echo "[1/6] Mengupdate paket sistem Termux..."
pkg update -y && pkg upgrade -y

# 2. Install PHP, MariaDB, Composer, Cloudflared
echo "[2/6] Menginstall PHP 8.2+, MariaDB (MySQL), Composer, dan Cloudflared..."
pkg install -y php php-fpm mariadb composer git cloudflared termux-tools jq curl

# 3. Setup MariaDB
echo "[3/6] Mengonfigurasi MariaDB Database..."
if [ ! -d "/data/data/com.termux/files/usr/var/lib/mysql" ]; then
    mariadb-install-db
fi

# Jalankan MariaDB daemon
echo "Menjalankan database MariaDB..."
mysqld_safe --skip-syslog > /dev/null 2>&1 &
sleep 3

# Buat database jika belum ada
mariadb -u root -e "CREATE DATABASE IF NOT EXISTS hyundaisurabayadb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 4. Berikan izin penyimpanan jika diperlukan
echo "[4/6] Mengatur izin penyimpanan termux..."
termux-setup-storage

echo "=========================================================="
echo "✅ INSTALASI PAKET SELESAI!"
echo "=========================================================="
echo ""
echo "Langkah selanjutnya:"
echo "1. Salin folder 'ProjectSales-main' ke HP Anda (misal ke folder downloads atau direktori termux)."
echo "2. Masuk ke folder project, contoh: cd ~/ProjectSales-main"
echo "3. Jalankan server: bash run_server.sh"
echo "=========================================================="
