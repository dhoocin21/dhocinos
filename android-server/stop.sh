#!/bin/bash
# ==============================================================================
# HYUNDAI SALES WEB SERVER - ANDROID VPS STOPPER
# ==============================================================================

PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"

echo "🛑 Menghentikan Web Server & Cloudflare Tunnel..."

if [ -f "$PROJECT_DIR/storage/logs/php.pid" ]; then
    kill -9 $(cat "$PROJECT_DIR/storage/logs/php.pid") 2>/dev/null || true
    rm -f "$PROJECT_DIR/storage/logs/php.pid"
fi

if [ -f "$PROJECT_DIR/storage/logs/tunnel.pid" ]; then
    kill -9 $(cat "$PROJECT_DIR/storage/logs/tunnel.pid") 2>/dev/null || true
    rm -f "$PROJECT_DIR/storage/logs/tunnel.pid"
fi

# Fallback kill jika ada proses tertinggal
pkill -f "artisan serve" 2>/dev/null || true
pkill -f "cloudflared" 2>/dev/null || true

echo "✅ Server & Tunnel berhasil dimatikan."
