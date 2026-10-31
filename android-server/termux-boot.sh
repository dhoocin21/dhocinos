#!/bin/bash
# ==============================================================================
# HYUNDAI SALES WEB SERVER - AUTOBOOT SCRIPT (TERMUX:BOOT)
# ==============================================================================
# Letakkan skrip ini di ~/.termux/boot/start-hyundai-vps.sh
# Agar saat HP Android reboot / dinyalakan, server otomatis langsung aktif.
# ==============================================================================

termux-wake-lock
sleep 10

PROJECT_DIR="/data/data/com.termux/files/home/hyundai"
if [ -d "$PROJECT_DIR" ]; then
    bash "$PROJECT_DIR/android-server/start.sh"
fi
