<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OfficialPricelistSeeder extends Seeder
{
    public function run(): void
    {
        $pricelist = [
            [
                'name' => 'STARGAZER Cartenz',
                'category' => 'MPV',
                'price' => 245800000,
                'variants' => [
                    ['name' => 'Trend MT', 'price' => 245800000, 'transmission' => 'Manual 6-Speed', 'engine' => 'Smartstream 1.5L'],
                    ['name' => 'Trend IVT', 'price' => 260800000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L'],
                    ['name' => 'Style IVT', 'price' => 275550000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L'],
                    ['name' => 'Smart Non HSS IVT', 'price' => 289350000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L'],
                    ['name' => 'Smart HSS IVT', 'price' => 299350000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L'],
                    ['name' => 'Prime Non HSS IVT', 'price' => 312350000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L'],
                    ['name' => 'Prime HSS IVT', 'price' => 322350000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L'],
                ],
            ],
            [
                'name' => 'STARGAZER Cartenz X',
                'category' => 'MPV',
                'price' => 354400000,
                'variants' => [
                    ['name' => 'Style IVT', 'price' => 354400000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L'],
                    ['name' => 'Prime Package IVT', 'price' => 389400000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L'],
                ],
            ],
            [
                'name' => 'STARGAZER',
                'category' => 'MPV',
                'price' => 260450000,
                'variants' => [
                    ['name' => 'Active+ MT Steel Wheel', 'price' => 260450000, 'transmission' => 'Manual 6-Speed', 'engine' => 'Smartstream 1.5L'],
                    ['name' => 'Active+ MT', 'price' => 262950000, 'transmission' => 'Manual 6-Speed', 'engine' => 'Smartstream 1.5L'],
                    ['name' => 'Active+ IVT Steel Wheel', 'price' => 273800000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L'],
                    ['name' => 'Active+ IVT', 'price' => 276300000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L'],
                    ['name' => 'Essential MT', 'price' => 275050000, 'transmission' => 'Manual 6-Speed', 'engine' => 'Smartstream 1.5L'],
                    ['name' => 'Essential IVT', 'price' => 286750000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L'],
                ],
            ],
            [
                'name' => 'CRETA',
                'category' => 'SUV',
                'price' => 312650000,
                'variants' => [
                    ['name' => 'Active 1.5 MT', 'price' => 312650000, 'transmission' => 'Manual 6-Speed', 'engine' => 'Smartstream 1.5L'],
                    ['name' => 'Trend 1.5 MT', 'price' => 345450000, 'transmission' => 'Manual 6-Speed', 'engine' => 'Smartstream 1.5L'],
                    ['name' => 'Trend 1.5 IVT', 'price' => 366500000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L'],
                    ['name' => 'Style 1.5 IVT', 'price' => 412200000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L'],
                    ['name' => 'Prime 1.5 IVT 1 Tone', 'price' => 443350000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L'],
                    ['name' => 'Alpha', 'price' => 459850000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L'],
                ],
            ],
            [
                'name' => 'CRETA N Line',
                'category' => 'SUV',
                'price' => 477850000,
                'variants' => [
                    ['name' => 'N Line', 'price' => 477850000, 'transmission' => 'Dual Clutch / IVT', 'engine' => 'Turbocharged Engine'],
                    ['name' => 'Turbo', 'price' => 525850000, 'transmission' => 'DCT 7-Speed', 'engine' => '1.5 Turbo GDI'],
                ],
            ],
            [
                'name' => 'PALISADE',
                'category' => 'SUV',
                'price' => 952800000,
                'variants' => [
                    ['name' => 'Prime', 'price' => 952800000, 'transmission' => 'Automatic 8-Speed', 'engine' => '2.2L CRDi Diesel'],
                    ['name' => 'Signature', 'price' => 1098700000, 'transmission' => 'Automatic 8-Speed', 'engine' => '2.2L CRDi Diesel'],
                    ['name' => 'Signature XRT', 'price' => 1127600000, 'transmission' => 'Automatic 8-Speed', 'engine' => '2.2L CRDi Diesel'],
                    ['name' => 'Signature 4WD XRT', 'price' => 1268500000, 'transmission' => 'AWD 8-Speed', 'engine' => '2.2L CRDi Diesel'],
                ],
            ],
            [
                'name' => 'PALISADE HEV',
                'category' => 'HEV',
                'price' => 1136600000,
                'variants' => [
                    ['name' => 'Signature', 'price' => 1136600000, 'transmission' => 'Automatic', 'engine' => 'Hybrid Turbo'],
                    ['name' => 'Calligraphy', 'price' => 1309400000, 'transmission' => 'Automatic', 'engine' => 'Hybrid Turbo'],
                    ['name' => 'Calligraphy AWD', 'price' => 1396500000, 'transmission' => 'AWD', 'engine' => 'Hybrid Turbo'],
                ],
            ],
            [
                'name' => 'SANTA FE HEV',
                'category' => 'HEV',
                'price' => 740500000,
                'variants' => [
                    ['name' => 'G 2.5 6AT Prime', 'price' => 740500000, 'transmission' => 'Automatic 6-Speed', 'engine' => 'Smartstream 2.5L'],
                    ['name' => 'G 2.5 6AT Calligraphy', 'price' => 830000000, 'transmission' => 'Automatic 6-Speed', 'engine' => 'Smartstream 2.5L'],
                    ['name' => 'HEV Prime', 'price' => 832100000, 'transmission' => 'Hybrid Automatic', 'engine' => '1.6T-GDi Hybrid'],
                    ['name' => 'HEV Calligraphy', 'price' => 919400000, 'transmission' => 'Hybrid Automatic', 'engine' => '1.6T-GDi Hybrid'],
                    ['name' => 'HEV XRT', 'price' => 937100000, 'transmission' => 'Hybrid AWD', 'engine' => '1.6T-GDi Hybrid'],
                ],
            ],
            [
                'name' => 'STARIA',
                'category' => 'Luxury MPV',
                'price' => 966700000,
                'variants' => [
                    ['name' => '9 Seaters Signature', 'price' => 966700000, 'transmission' => 'Automatic 8-Speed', 'engine' => '2.2 CRDi Diesel'],
                    ['name' => '7 Seaters Signature', 'price' => 1107500000, 'transmission' => 'Automatic 8-Speed', 'engine' => '2.2 CRDi Diesel'],
                ],
            ],
            [
                'name' => 'IONIQ 5',
                'category' => 'EV',
                'price' => 813500000,
                'variants' => [
                    ['name' => 'Prime Standard Range', 'price' => 813500000, 'transmission' => 'Single Speed', 'engine' => 'Electric 58 kWh (384 km)'],
                    ['name' => 'Prime Long Range', 'price' => 856500000, 'transmission' => 'Single Speed', 'engine' => 'Electric 72.6 kWh (481 km)'],
                    ['name' => 'Signature Standard Range', 'price' => 878900000, 'transmission' => 'Single Speed', 'engine' => 'Electric 58 kWh (384 km)'],
                    ['name' => 'Signature Long Range', 'price' => 930600000, 'transmission' => 'Single Speed', 'engine' => 'Electric 72.6 kWh (481 km)'],
                ],
            ],
            [
                'name' => 'KONA Electric',
                'category' => 'EV',
                'price' => 570250000,
                'variants' => [
                    ['name' => 'Style', 'price' => 570250000, 'transmission' => 'Single Speed', 'engine' => 'Electric 48.4 kWh'],
                    ['name' => 'Prime Standard Range', 'price' => 588500000, 'transmission' => 'Single Speed', 'engine' => 'Electric 48.4 kWh'],
                    ['name' => 'Prime Long Range', 'price' => 639500000, 'transmission' => 'Single Speed', 'engine' => 'Electric 65.4 kWh'],
                    ['name' => 'Signature Standard Range', 'price' => 656650000, 'transmission' => 'Single Speed', 'engine' => 'Electric 48.4 kWh'],
                    ['name' => 'Signature Long Range', 'price' => 673550000, 'transmission' => 'Single Speed', 'engine' => 'Electric 65.4 kWh'],
                    ['name' => 'N Line', 'price' => 694550000, 'transmission' => 'Single Speed', 'engine' => 'Electric N Line Performance'],
                ],
            ],
            [
                'name' => 'IONIQ 9',
                'category' => 'EV',
                'price' => 1547000000,
                'variants' => [
                    ['name' => 'Calligraphy AWD 6P Swivel Seat', 'price' => 1547000000, 'transmission' => 'Dual Motor AWD', 'engine' => 'Electric 110.3 kWh Battery'],
                    ['name' => 'Calligraphy AWD 6P Power Seat', 'price' => 1557000000, 'transmission' => 'Dual Motor AWD', 'engine' => 'Electric 110.3 kWh Battery'],
                ],
            ],
        ];

        foreach ($pricelist as $item) {
            $existing = Car::where('name', 'LIKE', '%' . $item['name'] . '%')
                ->orWhere('name', 'LIKE', '%' . str_replace([' Cartenz', ' X', ' HEV', ' The New ', 'New '], '', $item['name']) . '%')
                ->first();

            if ($existing) {
                $existing->update([
                    'category' => $item['category'],
                    'price' => $item['price'],
                    'variants' => $item['variants'],
                ]);
            } else {
                Car::create([
                    'name' => $item['name'],
                    'slug' => Str::slug($item['name']),
                    'category' => $item['category'],
                    'price' => $item['price'],
                    'description' => "Unit resmi {$item['name']} OTR Surabaya dengan garansi resmi dan penawaran terbaik.",
                    'features' => ['Hyundai SmartSense', 'Wireless Charger', 'Touchscreen Infotainment'],
                    'variants' => $item['variants'],
                    'is_available' => true,
                ]);
            }
        }
    }
}
