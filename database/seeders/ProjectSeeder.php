<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Consultant;
use App\Models\Gallery;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // Consultant: NICO (Official Sales Advisor from flyer)
        $consultant = Consultant::first();
        if (!$consultant) {
            $consultant = new Consultant();
        }
        $consultant->fill([
            'name' => 'NICO',
            'phone' => '081330135013',
            'email' => 'nicohardiansyah@gmail.com',
            'address' => 'Hyundai HR Muhammad, Jl. Mayjen HR. Muhammad No.35C, Sonokwijenan, Kec. Sukomanunggal, Surabaya.',
            'bio' => 'Official Sales Consultant Hyundai Gowa HR Muhammad Surabaya. Melayani pembelian tunai/kredit DP ringan & bunga 0%, test drive unit di showroom atau ke rumah/kantor, dan tukar tambah segala merk mobil.',
        ]);
        $consultant->save();

        // Cleanup obsolete discontinued stargazer-x
        Car::where('slug', 'stargazer-x')->delete();

        // 12 Cars strictly matching official Hyundai Gowa Surabaya Price List flyer
        $cars = [
            [
                'name' => 'STARGAZER Cartenz',
                'slug' => 'stargazer-cartenz',
                'category' => 'MPV',
                'price' => 245800000,
                'description' => 'MPV keluarga terfavorit edisi Cartenz dengan kenyamanan kabin maksimal, fitur konektivitas modern, dan kabin lapang serbaguna.',
                'features' => ['Captain Seat Option', 'Hyundai SmartSense', 'Kabin Luas 7-Seater', 'Wireless Smartphone Charger'],
                'image' => 'cars/stargazer-cartenz.png',
                'hero_image' => 'cars/hero/stargazer_cartenz_official_hero.jpg',
                'images' => [
                    'cars/gallery/stargazer_cartenz_interior.jpg',
                    'cars/gallery/stargazer_cartenz_captain_seat.jpg',
                    'cars/gallery/stargazer_cartenz_table.jpg'
                ],
                'is_available' => true,
                'variants' => [
                    ['name' => 'Trend MT', 'price' => 245800000, 'transmission' => 'Manual 6-Speed', 'engine' => 'Smartstream 1.5L MPI', 'key_features' => ['15-inch Wheels', 'Smartstream 1.5L', 'Dual Airbags', '8-inch Audio']],
                    ['name' => 'Trend IVT', 'price' => 260800000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L MPI', 'key_features' => ['8-inch Display Audio', 'Rear View Monitor', 'Hyundai Bluelink', 'Drive Mode Select']],
                    ['name' => 'Style IVT', 'price' => 275550000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L MPI', 'key_features' => ['LED Headlamps', 'Cruise Control', 'Supervision Cluster', '16-inch Alloy Wheels']],
                    ['name' => 'Smart Non HSS IVT', 'price' => 289350000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L MPI', 'key_features' => ['Kabin Lapang', 'Push Start Button', 'Smart Keyless Entry', 'Rear Disc Brakes']],
                    ['name' => 'Smart HSS IVT', 'price' => 299350000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L MPI', 'key_features' => ['Hyundai SmartSense ADAS', 'Forward Collision-Avoidance', 'Lane Keeping Assist', 'Blind-spot Collision']],
                    ['name' => 'Prime Non HSS IVT', 'price' => 312350000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L MPI', 'key_features' => ['Leather Seats Premium', 'Ambient Mood Lighting', 'BOSE Sound System', 'Captain Seat']],
                    ['name' => 'Prime HSS IVT', 'price' => 322350000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L MPI', 'key_features' => ['Full Hyundai SmartSense', 'Captain Seat', 'Bose Audio 8-Speaker', 'Wireless Charger']]
                ]
            ],
            [
                'name' => 'STARGAZER Cartenz X',
                'slug' => 'stargazer-cartenz-x',
                'category' => 'Crossover',
                'price' => 354400000,
                'description' => 'Unleash the X in you. Perpaduan sempurna antara kelegaan MPV keluarga dengan ketangguhan karakter Crossover SUV bertenaga.',
                'features' => ['Bold Crossover Design', 'High Ground Clearance 200mm', 'Premium Roof Rails', 'BOSE Audio', 'Driver Ventilated Seat'],
                'image' => 'cars/stargazer-cartenz-x.png',
                'hero_image' => 'cars/hero/stargazer_cartenz_official_hero.jpg',
                'images' => ['cars/gallery/stargazer_cartenz_interior.jpg'],
                'is_available' => true,
                'variants' => [
                    [
                        'name' => 'Style IVT',
                        'price' => 354400000,
                        'transmission' => 'IVT (Intelligent Variable)',
                        'engine' => 'Smartstream G1.5 MPI (115 PS / 143.8 Nm)',
                        'key_features' => ['17-inch Diamond Cut Alloy Wheels', 'Crossover Body Kit & Roof Rails', 'High Ground Clearance 200mm', 'LED MFR Headlamps & DRL Horizon', '8-inch Audio Connectivity']
                    ],
                    [
                        'name' => 'Prime Package IVT',
                        'price' => 389400000,
                        'transmission' => 'IVT (Intelligent Variable)',
                        'engine' => 'Smartstream G1.5 MPI (115 PS / 143.8 Nm)',
                        'key_features' => ['Full Hyundai SmartSense Safety', 'BOSE™ Premium 8-Speaker Sound', 'Driver Ventilated Seat & 8-Way Power Seat', 'Leatherette Seats with Red Stitching', 'Captain Seat with Armrest']
                    ]
                ]
            ],
            [
                'name' => 'STARGAZER',
                'slug' => 'stargazer',
                'category' => 'MPV',
                'price' => 260450000,
                'description' => 'Bintang Baru Keluarga Indonesia. MPV modern yang dirancang khusus untuk kenyamanan dan keamanan berkendara bersama keluarga.',
                'features' => ['Captain Seat', 'Tire Pressure Monitoring (TPMS)', 'Spacious Cabin', 'Hyundai SmartSense'],
                'image' => 'cars/stargazer.png',
                'hero_image' => 'cars/hero/hero_stargazer.png',
                'images' => ['cars/gallery/stargazer_interior.png'],
                'is_available' => true,
                'variants' => [
                    ['name' => 'Active+ MT Steel Wheel', 'price' => 260450000, 'transmission' => 'Manual 6-Speed', 'engine' => 'Smartstream 1.5L', 'key_features' => ['15-inch Steel Wheels', 'Dual Airbags', '8-inch Audio', 'Tilt Steering']],
                    ['name' => 'Active+ MT', 'price' => 262950000, 'transmission' => 'Manual 6-Speed', 'engine' => 'Smartstream 1.5L', 'key_features' => ['15-inch Alloy Wheels', 'Halogen Headlamps', '2 Speakers Audio', 'Dual Airbags']],
                    ['name' => 'Active+ IVT Steel Wheel', 'price' => 273800000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L', 'key_features' => ['IVT Smooth Transmission', '15-inch Steel Wheels', 'Rear Camera', 'Bluelink']],
                    ['name' => 'Active+ IVT', 'price' => 276300000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L', 'key_features' => ['8-inch Display Audio', '15-inch Alloy Wheels', 'Rear View Monitor', 'Bluelink']],
                    ['name' => 'Essential MT', 'price' => 275050000, 'transmission' => 'Manual 6-Speed', 'engine' => 'Smartstream 1.5L', 'key_features' => ['Full LED Headlamps', '4.2-inch Supervision Cluster', 'Tire Pressure Monitoring', 'Smart Keyless Entry']],
                    ['name' => 'Essential IVT', 'price' => 286750000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L', 'key_features' => ['IVT Transmission', 'Drive Mode (Eco/Normal/Sport)', 'Cruise Control', 'Smart Keyless Entry']]
                ]
            ],
            [
                'name' => 'IONIQ 9',
                'slug' => 'ioniq-9',
                'category' => 'EV',
                'price' => 1547000000,
                'description' => 'Flagship 3-Row Electric SUV kelas mahakarya dengan ruang lounge aerostetis, baterai 110.3 kWh dan kemewahan tak tertandingi.',
                'features' => ['Flagship 3-Row EV SUV', 'Baterai Raksasa 110.3 kWh', 'Jarak Tempuh 620 KM', 'Universal Island 2.0 & Swivel Seats'],
                'image' => 'cars/ioniq9.png',
                'hero_image' => 'cars/hero/ioniq9_official_hero.jpg',
                'images' => [
                    'cars/gallery/ioniq9_front.jpg',
                    'cars/gallery/ioniq9_interior.jpg',
                    'cars/gallery/ioniq9_rear.jpg'
                ],
                'is_available' => true,
                'variants' => [
                    [
                        'name' => 'Calligraphy AWD 6P Swivel Seat',
                        'price' => 1547000000,
                        'transmission' => 'Dual Motor Electric AWD',
                        'engine' => 'Dual Motor 110.3 kWh (313 PS / 605 Nm)',
                        'key_features' => ['Kursi Baris Ke-2 Swivel Putar 180°', 'Dual Motor HTRAC AWD', 'Range s/d 620 KM', 'Panoramic Curved 12.3-inch', 'V2L Portabel 3.6 kW']
                    ],
                    [
                        'name' => 'Calligraphy AWD 6P Power Seat',
                        'price' => 1557000000,
                        'transmission' => 'Dual Motor Electric AWD',
                        'engine' => 'Dual Motor 110.3 kWh (313 PS / 605 Nm)',
                        'key_features' => ['Relaxation Comfort Seats Baris 1 & 2 dengan Fungsi Pijat', 'Kulit Nappa Eksklusif', 'Dual Sunroof Mood Lounge', 'Bose Spatial Surround Sound']
                    ]
                ]
            ],
            [
                'name' => 'CRETA',
                'slug' => 'the-new-creta',
                'category' => 'SUV',
                'price' => 312650000,
                'description' => 'Spotlight in every move. SUV compact yang dinamis dan berjiwa muda, dilengkapi dengan konektivitas Bluelink tercanggih.',
                'features' => ['Hyundai Bluelink', 'Bose Sound System', 'Ventilated Seats', 'Panoramic Sunroof'],
                'image' => 'cars/creta.png',
                'hero_image' => 'cars/hero/the_new_creta_official_hero.jpg',
                'images' => [
                    'cars/gallery/the_new_creta_bluelink.png',
                    'cars/gallery/the_new_creta_highlight1.png',
                    'cars/gallery/creta_rear.png'
                ],
                'is_available' => true,
                'variants' => [
                    ['name' => 'Active 1.5 MT', 'price' => 312650000, 'transmission' => 'Manual 6-Speed', 'engine' => 'Smartstream G1.5 MPI', 'key_features' => ['8-inch Touchscreen', '16-inch Silver Alloy Wheels', 'Dual Airbags', 'Tilt & Telescopic']],
                    ['name' => 'Trend 1.5 MT', 'price' => 345450000, 'transmission' => 'Manual 6-Speed', 'engine' => 'Smartstream G1.5 MPI', 'key_features' => ['Hyundai Bluelink', 'Wireless Smartphone Charger', 'Rear View Monitor', '17-inch Diamond Cut Wheels']],
                    ['name' => 'Trend 1.5 IVT', 'price' => 366500000, 'transmission' => 'IVT', 'engine' => 'Smartstream G1.5 MPI', 'key_features' => ['IVT Transmission', 'Hyundai Bluelink', 'Electronic Parking Brake', 'Paddle Shift']],
                    ['name' => 'Style 1.5 IVT', 'price' => 412200000, 'transmission' => 'IVT', 'engine' => 'Smartstream G1.5 MPI', 'key_features' => ['Full LED Headlamps', 'BOSE Premium Sound (8 Speakers)', 'Ventilated Front Seats', '10.25-inch TFT Meter Cluster']],
                    ['name' => 'Prime 1.5 IVT 1 Tone', 'price' => 443350000, 'transmission' => 'IVT', 'engine' => 'Smartstream G1.5 MPI', 'key_features' => ['Panoramic Sunroof', 'Full Hyundai SmartSense ADAS', 'Leatherette Two-Tone Seats', 'Air Purifier']],
                    ['name' => 'Alpha', 'price' => 459850000, 'transmission' => 'IVT', 'engine' => 'Smartstream G1.5 MPI', 'key_features' => ['Matte Black Exterior Styling', 'Black Alloy Wheels 17-inch', 'Alpha Exclusive Stitching', 'Full Hyundai SmartSense']]
                ]
            ],
            [
                'name' => 'CRETA N Line',
                'slug' => 'creta-n-line',
                'category' => 'SUV',
                'price' => 477850000,
                'description' => 'Sensasi motorsport berkarakter agresif dengan performa mesin turbo dan sentuhan sporty khas Hyundai N Line.',
                'features' => ['N Line Sport Body Kit', 'Turbo Engine Power', 'Sport Exhaust', 'N Line Steering & Interior'],
                'image' => 'cars/creta-n-line.png',
                'hero_image' => 'cars/hero/the_new_creta_official_hero.jpg',
                'images' => [
                    'cars/gallery/the_new_creta_highlight2.png',
                    'cars/gallery/the_new_creta_highlight3.png'
                ],
                'is_available' => true,
                'variants' => [
                    [
                        'name' => 'N Line',
                        'price' => 477850000,
                        'transmission' => 'Dual Clutch / IVT',
                        'engine' => '1.5 Turbo GDI (160 PS)',
                        'key_features' => ['N Line Dark Chrome Parametric Grille', '18-inch Diamond Cut N Wheels', 'N Line Badging & Red Stitching', 'Sport Tuned Suspension']
                    ],
                    [
                        'name' => 'Turbo',
                        'price' => 525850000,
                        'transmission' => '7-Speed Dual Clutch (DCT)',
                        'engine' => '1.5 Turbocharged (160 PS / 253 Nm)',
                        'key_features' => ['7-Speed DCT Transmission', 'Paddle Shift Motorsport', 'Twin Tip Exhaust', 'Full N Line Leather Seats & Panoramic Sunroof']
                    ]
                ]
            ],
            [
                'name' => 'PALISADE',
                'slug' => 'palisade',
                'category' => 'SUV',
                'price' => 952800000,
                'description' => 'Flagship Luxury SUV 7-seater dengan kabin lapang, kemewahan tingkat tinggi, dan mesin tangguh 2.2L CRDi Diesel.',
                'features' => ['Flagship 7-Seater', 'Captain Seat 2nd Row', 'Dual Sunroof', 'SmartSense ADAS', '2.2L CRDi Diesel'],
                'image' => 'cars/palisade.png',
                'hero_image' => 'cars/hero/palisade_official_hero.jpg',
                'images' => ['cars/hero/palisade_official_hero.jpg'],
                'is_available' => true,
                'variants' => [
                    [
                        'name' => 'Prime',
                        'price' => 952800000,
                        'transmission' => '8-Speed Automatic Shift-By-Wire',
                        'engine' => '2.2L CRDi Diesel VGT (200 PS / 440 Nm)',
                        'key_features' => ['12.3-inch Touchscreen Navigation', 'Captain Seat 2nd Row', 'Dual Zone Climate Control', 'Power Tailgate', 'Hyundai SmartSense']
                    ],
                    [
                        'name' => 'Signature',
                        'price' => 1098700000,
                        'transmission' => '8-Speed Automatic Shift-By-Wire',
                        'engine' => '2.2L CRDi Diesel VGT (200 PS / 440 Nm)',
                        'key_features' => ['Jok Asli Nappa Leather', 'Dual Sunroof Depan & Belakang', 'Ventilated & Heated Seats', 'Surround View Monitor 360°', 'Blind-spot View Monitor']
                    ],
                    [
                        'name' => 'Signature XRT',
                        'price' => 1127600000,
                        'transmission' => '8-Speed Automatic Shift-By-Wire',
                        'engine' => '2.2L CRDi Diesel VGT (200 PS / 440 Nm)',
                        'key_features' => ['XRT Dark Edition Grille & Bumper', '20-inch Dark Alloy Wheels', 'XRT Roof Rails & Side Steps', 'Luxury Nappa Leather Cockpit']
                    ],
                    [
                        'name' => 'Signature 4WD XRT',
                        'price' => 1268500000,
                        'transmission' => '8-Speed Automatic HTRAC AWD',
                        'engine' => '2.2L CRDi Diesel VGT AWD (200 PS / 440 Nm)',
                        'key_features' => ['Sistem 4 Roda HTRAC AWD', 'Multi-Terrain Mode (Snow, Mud, Sand)', 'Paket XRT Dark Edition Lengkap', '20-inch Dark Alloy Wheels']
                    ]
                ]
            ],
            [
                'name' => 'PALISADE HEV',
                'slug' => 'palisade-hev',
                'category' => 'HEV',
                'price' => 1136600000,
                'description' => 'Kemewahan paripurna Flagship Hybrid SUV yang memadukan keperkasaan performa turbo hybrid dengan efisiensi tinggi.',
                'features' => ['Hybrid Turbo Powertrain', 'HTRAC AWD', 'Nappa Leather Calligraphy', 'Dual Curved Display'],
                'image' => 'cars/all-new-palisade-hybrid.png',
                'hero_image' => 'cars/hero/palisade_official_hero.jpg',
                'images' => ['cars/hero/palisade_official_hero.jpg'],
                'is_available' => true,
                'variants' => [
                    [
                        'name' => 'Signature',
                        'price' => 1136600000,
                        'transmission' => 'Automatic Hybrid 6-Speed',
                        'engine' => 'Hybrid Turbo (260 PS Kombinasi)',
                        'key_features' => ['Powertrain Turbo Hybrid Bertenaga', 'Dual Sunroof & Captain Seat 2nd Row', 'Curved Glass 12.3-inch Cockpit', 'Full Hyundai SmartSense ADAS']
                    ],
                    [
                        'name' => 'Calligraphy',
                        'price' => 1309400000,
                        'transmission' => 'Automatic Hybrid 6-Speed',
                        'engine' => 'Hybrid Turbo (260 PS Kombinasi)',
                        'key_features' => ['Nappa Leather Calligraphy', 'Bose Spatial Audio', 'Ergo Motion Seat Baris 1', 'Remote Smart Parking Assist']
                    ],
                    [
                        'name' => 'Calligraphy AWD',
                        'price' => 1396500000,
                        'transmission' => 'HTRAC AWD Hybrid 6-Speed',
                        'engine' => 'Hybrid Turbo AWD (260 PS Kombinasi)',
                        'key_features' => ['HTRAC All-Wheel Drive', 'E-Suspension Elektronik Cerdas', 'Nappa Leather Eksklusif Calligraphy', 'Terrain Mode Hybrid AWD']
                    ],
                    [
                        'name' => 'New MY 27 Signature',
                        'price' => 1138700000,
                        'transmission' => 'Automatic Hybrid 6-Speed',
                        'engine' => 'Hybrid Turbo New Generation (MY27)',
                        'key_features' => ['Model Year 2027 Upgrade', 'Next-Gen Infotainment OS', 'Enhanced SmartSense Level 2.5', 'Digital Center Mirror']
                    ],
                    [
                        'name' => 'New MY 27 Calligraphy',
                        'price' => 1325700000,
                        'transmission' => 'Automatic Hybrid 6-Speed',
                        'engine' => 'Hybrid Turbo New Generation (MY27)',
                        'key_features' => ['Model Year 2027 Calligraphy Trim', 'Ultra-luxurious Quilted Nappa', 'Dual Wireless Fast Charger', 'Highway Driving Assist 2']
                    ],
                    [
                        'name' => 'New MY 27 Calligraphy AWD',
                        'price' => 1412700000,
                        'transmission' => 'HTRAC AWD Hybrid 6-Speed',
                        'engine' => 'Hybrid Turbo AWD New Generation (MY27)',
                        'key_features' => ['Top Flagship Model Year 2027', 'HTRAC AWD Intelligent Traction', 'E-Handling Vectoring Control', 'Head-Up Display 10-inch Full Color']
                    ]
                ]
            ],
            [
                'name' => 'SANTA FE HEV',
                'slug' => 'santa-fe',
                'category' => 'HEV',
                'price' => 740500000,
                'description' => 'Open for More. SUV petualang futuristik berdesain Boxy radikal dengan H-Lights ikonik dan kabin lapang ultra-modern.',
                'features' => ['Desain Boxy Modern', 'H-Shaped Headlights', 'Panoramic Curved Display', 'Turbo Hybrid Powertrain'],
                'image' => 'cars/santa-fe.png',
                'hero_image' => 'cars/hero/all_new_santa_fe_official_hero.jpg',
                'images' => [
                    'cars/gallery/santa_fe_curved_display.png',
                    'cars/gallery/santa_fe_spacious_cabin.png',
                    'cars/gallery/santa_fe_live_bigger.jpg'
                ],
                'is_available' => true,
                'variants' => [
                    [
                        'name' => 'G 2.5 8AT Prime',
                        'price' => 740500000,
                        'transmission' => '8-Speed Automatic',
                        'engine' => 'Smartstream G2.5 GDi (194 PS / 246 Nm)',
                        'key_features' => ['Panoramic Curved Display Dual 12.3-inch', 'H-Lights LED Depan & Belakang', 'Power Tailgate', 'Hyundai SmartSense Lengkap']
                    ],
                    [
                        'name' => 'G 2.5 8AT Calligraphy',
                        'price' => 830000000,
                        'transmission' => '8-Speed Automatic',
                        'engine' => 'Smartstream G2.5 GDi (194 PS / 246 Nm)',
                        'key_features' => ['Nappa Leather Seats', 'Dual Wireless Phone Charger', 'Bose Premium Audio', 'UV-C Sterilization Tray']
                    ],
                    [
                        'name' => 'HEV Prime',
                        'price' => 832100000,
                        'transmission' => '6-Speed Hybrid Automatic',
                        'engine' => 'Smartstream 1.6T-GDi HEV (235 PS / 367 Nm)',
                        'key_features' => ['Mesin Turbo Hybrid Efisien & Bertenaga', 'Dynamic Torque Vectoring', 'E-Ride Comfort System', 'Dual 12.3-inch Curved Screen']
                    ],
                    [
                        'name' => 'HEV Calligraphy',
                        'price' => 919400000,
                        'transmission' => '6-Speed Hybrid Automatic',
                        'engine' => 'Smartstream 1.6T-GDi HEV (235 PS / 367 Nm)',
                        'key_features' => ['Mesin Turbo Hybrid Performa Tinggi', 'Nappa Leather Quilted', 'Relaxation Comfort Seats', 'Bose Spatial Surround Sound']
                    ],
                    [
                        'name' => 'HEV XRT',
                        'price' => 937100000,
                        'transmission' => '6-Speed Hybrid Automatic AWD',
                        'engine' => 'Smartstream 1.6T-GDi HEV AWD (235 PS / 367 Nm)',
                        'key_features' => ['Tampilan XRT Rugged All-Black', 'All-Terrain Wheels & Dark Roof Rack', 'HTRAC AWD Hybrid Traction', 'High Clearance Off-road Package']
                    ]
                ]
            ],
            [
                'name' => 'STARIA',
                'slug' => 'staria',
                'category' => 'Luxury MPV',
                'price' => 966700000,
                'description' => 'Lounge on wheels. Van premium futuristik dengan kabin super lapang dan kemewahan sekelas kabin pesawat kelas bisnis.',
                'features' => ['Futuristic Exterior', 'Lounge-style Cabin', 'Swiveling Independent Chairs', 'Dual Sunroof'],
                'image' => 'cars/staria.png',
                'hero_image' => 'cars/hero/the_new_staria_official_hero.jpg',
                'images' => [
                    'cars/gallery/the_new_staria_vip_seats.jpg',
                    'cars/gallery/the_new_staria_indoor_v2l.jpg',
                    'cars/gallery/the_new_staria_electric_perf.jpg'
                ],
                'is_available' => true,
                'variants' => [
                    [
                        'name' => '9 Seaters Signature',
                        'price' => 966700000,
                        'transmission' => '8-Speed Automatic',
                        'engine' => 'R 2.2 CRDi Diesel VGT (177 PS / 430 Nm)',
                        'key_features' => ['9 Premium Leather Seats', 'Swiveling Independent Seats (Baris ke-2 Putar 180°)', 'Dual Sunroof', 'Smart Power Sliding Door']
                    ],
                    [
                        'name' => '7 Seaters Signature',
                        'price' => 1107500000,
                        'transmission' => '8-Speed Automatic',
                        'engine' => 'R 2.2 CRDi Diesel VGT (177 PS / 430 Nm)',
                        'key_features' => ['Premium Relaxation Seats VIP (7 seats)', '12 Bose Premium Speakers', 'Surround View Monitor (360 Camera)', 'Full TFT Supervision Cluster']
                    ]
                ]
            ],
            [
                'name' => 'IONIQ 5',
                'slug' => 'ioniq-5',
                'category' => 'EV',
                'price' => 813500000,
                'description' => 'Power your world with the IONIQ 5. Era baru mobil listrik murni yang menggabungkan desain retro-futuris dengan teknologi V2L revolusioner.',
                'features' => ['V2L Technology', 'Ultra-fast Charging', 'Sustainable Materials', 'Vision Roof'],
                'image' => 'cars/ioniq-5.png',
                'hero_image' => 'cars/hero/hero_ioniq5.png',
                'images' => ['cars/gallery/ioniq5_interior.png'],
                'is_available' => true,
                'variants' => [
                    [
                        'name' => 'Prime Standard Range',
                        'price' => 813500000,
                        'transmission' => 'Single Speed Reduction Gear',
                        'engine' => 'Electric Motor (58 kWh Battery)',
                        'key_features' => ['Jarak Tempuh 384 KM', 'V2L Portabel', 'Hyundai SmartSense Level 2', 'Parametric Pixel LED']
                    ],
                    [
                        'name' => 'Prime Long Range',
                        'price' => 856500000,
                        'transmission' => 'Single Speed Reduction Gear',
                        'engine' => 'Electric Motor (72.6 kWh Battery)',
                        'key_features' => ['Jarak Tempuh 481 KM', 'V2L Portabel', 'Hyundai SmartSense', '19-inch Aero Alloy Wheels']
                    ],
                    [
                        'name' => 'Signature Standard Range',
                        'price' => 878900000,
                        'transmission' => 'Single Speed Reduction Gear',
                        'engine' => 'Electric Motor (58 kWh Battery)',
                        'key_features' => ['Jarak Tempuh 384 KM', 'Vision Roof Kaca Panorama', 'BOSE Premium Sound', 'Relaxation Seats Baris Depan']
                    ],
                    [
                        'name' => 'Signature Long Range',
                        'price' => 930600000,
                        'transmission' => 'Single Speed Reduction Gear',
                        'engine' => 'Electric Motor (72.6 kWh Battery)',
                        'key_features' => ['Jarak Tempuh 481 KM', 'Vision Roof Kaca Panorama', 'BOSE Premium Audio 8-Speaker', 'Premium Relaxation Comfort Seats']
                    ]
                ]
            ],
            [
                'name' => 'All-New KONA Electric',
                'slug' => 'kona-electric',
                'category' => 'EV',
                'price' => 570250000,
                'description' => 'EV SUV generasi terbaru yang dirancang langsung sebagai kendaraan listrik murni, dengan jarak tempuh hingga 600 KM dan baterai lokal.',
                'features' => ['Baterai Produksi Indonesia', 'Range s/d 600 KM', 'Vehicle-to-Load (V2L)', 'Pixelated Seamless Horizon Lamp'],
                'image' => 'cars/all-new-kona-electric.png',
                'hero_image' => 'cars/hero/hero_kona.png',
                'images' => [
                    'cars/gallery/kona_electric_front.jpg',
                    'cars/gallery/kona_electric_interior.jpg',
                    'cars/gallery/kona_electric_charging.jpg'
                ],
                'is_available' => true,
                'variants' => [
                    [
                        'name' => 'Style',
                        'price' => 570250000,
                        'transmission' => 'Single Speed',
                        'engine' => 'Electric 48.4 kWh (Range 448 km)',
                        'key_features' => ['Dual 12.3-inch Panoramic Display', 'Hyundai Bluelink', 'V2L Indoor', 'SmartSense Safety']
                    ],
                    [
                        'name' => 'Prime Standard Range',
                        'price' => 588500000,
                        'transmission' => 'Single Speed',
                        'engine' => 'Electric 48.4 kWh (Range 448 km)',
                        'key_features' => ['Dual 12.3-inch Display', 'Paddle Regenerative Brake', 'Wireless Charger', 'Smart Cruise Control']
                    ],
                    [
                        'name' => 'Prime Long Range',
                        'price' => 639500000,
                        'transmission' => 'Single Speed',
                        'engine' => 'Electric 65.4 kWh (Range 605 km)',
                        'key_features' => ['Jarak Tempuh Juara Hingga 605 KM', '17-inch Aero Wheels', 'Fast Charging 10-80% 43 menit', 'Ambient Lighting']
                    ],
                    [
                        'name' => 'Signature Standard Range',
                        'price' => 656650000,
                        'transmission' => 'Single Speed',
                        'engine' => 'Electric 48.4 kWh (Range 448 km)',
                        'key_features' => ['Full Hyundai SmartSense ADAS', 'Bose Premium Audio', 'Ventilated Seats', 'Power Tailgate']
                    ],
                    [
                        'name' => 'Signature Long Range',
                        'price' => 673550000,
                        'transmission' => 'Single Speed',
                        'engine' => 'Electric 65.4 kWh (Range 549 km)',
                        'key_features' => ['Full Hyundai SmartSense ADAS Level 2', 'Bose Premium 8-Speaker', 'Ventilated & Heated Seats', 'Power Tailgate']
                    ],
                    [
                        'name' => 'N Line',
                        'price' => 694550000,
                        'transmission' => 'Single Speed',
                        'engine' => 'Electric Performance N Line Package',
                        'key_features' => ['N Line Aggressive Bumper', '19-inch N Line Wheels', 'Sport Bucket Seats', 'Alcantara Details']
                    ]
                ]
            ],
        ];

        foreach ($cars as $car) {
            Car::updateOrCreate(['slug' => $car['slug']], $car);
        }
    }
}
