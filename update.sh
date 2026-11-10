#!/bin/bash
echo "=== Memulai Pembaruan Website Hyundai Surabaya ==="
git checkout -- .
git pull origin main

# Pastikan folder livewire-tmp ada
mkdir -p storage/app/livewire-tmp

# Buat symlink storage jika belum ada
if [ ! -e "public/storage" ]; then
    php artisan storage:link || cp -r storage/app/public public/storage
fi

# Bersihkan cache Laravel
php artisan optimize:clear

# Update database seeder
php artisan db:seed --class=ProjectSeeder --force

echo "=== Pembaruan Selesai! Website Siap Digunakan ==="
