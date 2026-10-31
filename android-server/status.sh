#!/bin/bash
# ==============================================================================
# HYUNDAI SALES WEB SERVER - ANDROID VPS STATUS MONITOR
# ==============================================================================

PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"

PHP_RUNNING=false
TUNNEL_RUNNING=false

if pgrep -f "artisan serve" > /dev/null; then
    PHP_RUNNING=true
fi

if pgrep -f "cloudflared" > /dev/null; then
    TUNNEL_RUNNING=true
fi

LOCAL_IP=$(ip -4 addr show wlan0 2>/dev/null | grep -oP '(?<=inet\s)\d+(\.\d+){3}' || hostname -I 2>/dev/null | awk '{print $1}' || echo "127.0.0.1")
TUNNEL_URL=$(grep -o 'https://[-a-zA-Z0-9@:%._\+~#=]\+\.trycloudflare\.com' "$PROJECT_DIR/storage/logs/tunnel.log" 2>/dev/null | tail -n 1 || echo "-")

echo "--------------------------------------------------------"
echo "📊 STATUS VPS ANDROID - HYUNDAI WEB SERVER"
echo "--------------------------------------------------------"
echo "PHP Web Server  : $( [ "$PHP_RUNNING" = true ] && echo '🟢 ONLINE (Port 8000)' || echo '🔴 OFFLINE' )"
echo "Cloudflare Tunnel: $( [ "$TUNNEL_RUNNING" = true ] && echo '🟢 ONLINE' || echo '🔴 OFFLINE' )"
echo "Akses Lokal WiFi: http://$LOCAL_IP:8000"
echo "Akses Publik    : $TUNNEL_URL"
echo "--------------------------------------------------------"
