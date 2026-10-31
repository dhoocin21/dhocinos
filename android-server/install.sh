#!/bin/bash
# ==============================================================================
# HYUNDAI SALES WEB SERVER - ANDROID VPS AUTOMATED INSTALLER
# ==============================================================================
# Skrip ini mengkonfigurasi Android (Termux) menjadi Web Server VPS berkinerja tinggi.
# ==============================================================================

set -e

echo "🚀 [1/6] Memperbarui paket Termux..."
pkg update -y && pkg upgrade -y

echo "📦 [2/6] Menginstall PHP, SQLite, MariaDB, Composer, Git, dan Cloudflared..."
pkg install -y php php-sqlite php-pdo-mysql composer git curl wget jq

# Install Cloudflared untuk akses publik gratis tanpa port forwarding
if ! command -v cloudflared &> /dev/null; then
    echo "🌐 Menginstall Cloudflared untuk Android..."
    ARCH=$(dpkg --print-architecture)
    if [ "$ARCH" = "aarch64" ]; then
        curl -sLo /data/data/com.termux/files/usr/bin/cloudflared https://github.com/cloudflare/cloudflared/releases/latest/download/cloudflared-linux-arm64
        chmod +x /data/data/com.termux/files/usr/bin/cloudflared
    elif [ "$ARCH" = "arm" ]; then
        curl -sLo /data/data/com.termux/files/usr/bin/cloudflared https://github.com/cloudflare/cloudflared/releases/latest/download/cloudflared-linux-arm
        chmod +x /data/data/com.termux/files/usr/bin/cloudflared
    else
        pkg install -y cloudflared || true
    fi
fi

echo "⚙️ [3/6] Konfigurasi environment Laravel..."
PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$PROJECT_DIR"

if [ ! -f .env ]; then
    echo "Membuat file .env dari .env.example..."
    cp .env.example .env
fi

# Optimasi konfigurasi database untuk Android (Default: SQLite untuk kecepatan & portabilitas)
sed -i 's/DB_CONNECTION=.*/DB_CONNECTION=sqlite/' .env
sed -i 's/DB_HOST=.*/# DB_HOST=127.0.0.1/' .env
sed -i 's/DB_PORT=.*/# DB_PORT=3306/' .env
sed -i 's/DB_DATABASE=.*/DB_DATABASE=\/data\/data\/com.termux\/files\/home\/database.sqlite/' .env

touch /data/data/com.termux/files/home/database.sqlite 2>/dev/null || touch "$PROJECT_DIR/database/database.sqlite"

echo "📥 [4/6] Menjalankan Composer Install..."
composer install --no-dev --optimize-autoloader

echo "🔑 [5/6] Generate Application Key & Link Storage..."
php artisan key:generate --force
php artisan storage:link || true

echo "💾 [6/6] Menjalankan Database Migrations & Seeders..."
php artisan migrate --force --seed || true
php artisan optimize:clear

echo "===================================================================="
echo "✅ INSTALASI VPS ANDROID BERHASIL!"
echo "Untuk menjalankan web server & akses publik, jalankan:"
echo "   bash android-server/start.sh"
echo "===================================================================="
