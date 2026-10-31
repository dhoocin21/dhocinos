#!/bin/bash
# ==============================================================================
# HYUNDAI SALES WEB SERVER - ANDROID VPS LAUNCHER
# ==============================================================================

PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$PROJECT_DIR"

echo "🚗 Menyalakan Web Server Hyundai di Android..."

# 1. Hentikan instance lama jika ada
bash "$PROJECT_DIR/android-server/stop.sh" 2>/dev/null || true

# 2. Ambil IP Lokal Android
LOCAL_IP=$(ip -4 addr show wlan0 2>/dev/null | grep -oP '(?<=inet\s)\d+(\.\d+){3}' || hostname -I 2>/dev/null | awk '{print $1}' || echo "127.0.0.1")

# 3. Jalankan PHP Built-in Server dengan optimasi worker
echo "⚡ Menjalankan PHP Server di 0.0.0.0:8000..."
PHP_CLI_SERVER_WORKERS=4 nohup php artisan serve --host=0.0.0.0 --port=8000 > "$PROJECT_DIR/storage/logs/php_server.log" 2>&1 &
echo $! > "$PROJECT_DIR/storage/logs/php.pid"

# 4. Jalankan Cloudflare Tunnel untuk akses publik global
echo "🌐 Mengaktifkan Cloudflare Public Tunnel (HTTPS)..."
nohup cloudflared tunnel --url http://127.0.0.1:8000 > "$PROJECT_DIR/storage/logs/tunnel.log" 2>&1 &
echo $! > "$PROJECT_DIR/storage/logs/tunnel.pid"

# Tunggu sejenak hingga tunnel aktif
sleep 4

TUNNEL_URL=$(grep -o 'https://[-a-zA-Z0-9@:%._\+~#=]\+\.trycloudflare\.com' "$PROJECT_DIR/storage/logs/tunnel.log" | tail -n 1 || echo "")

echo "===================================================================="
echo "🎉 HYUNDAI ANDROID VPS BERHASIL DIAKTIFKAN!"
echo "===================================================================="
echo "📍 Akses Jaringan Lokal (WiFi/Hotspot):"
echo "   http://$LOCAL_IP:8000"
echo ""
if [ -n "$TUNNEL_URL" ]; then
    echo "🌍 Akses Publik Global (Bisa dibuka dari mana saja):"
    echo "   $TUNNEL_URL"
    echo "   (SSL / HTTPS Resmi Cloudflare Aktif)"
else
    echo "🌍 Memproses Public Tunnel... Cek status dengan: bash android-server/status.sh"
fi
echo "===================================================================="
echo "Untuk membuka panel monitoring di HP, buka aplikasi 'Hyundai VPS Server'."
echo "Untuk mematikan server, jalankan: bash android-server/stop.sh"
echo "===================================================================="
