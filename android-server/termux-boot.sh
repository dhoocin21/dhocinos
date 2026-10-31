#!/bin/bash
# ==============================================================================
# HYUNDAI SALES WEB SERVER - AUTOBOOT SCRIPT (TERMUX:BOOT)
# ==============================================================================
# Letakkan skrip ini di ~/.termux/boot/start-hyundai-vps.sh
# Agar saat HP Android reboot / dinyalakan, server otomatis langsung aktif.
# ==============================================================================

termux-wake-lock
sleep 10

if [ -d "$HOME/ProjectSales-main" ]; then
    bash "$HOME/ProjectSales-main/android-server/start.sh"
elif [ -d "$HOME/hyundai" ]; then
    bash "$HOME/hyundai/android-server/start.sh"
fi
