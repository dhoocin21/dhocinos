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
        // Consultant
        Consultant::updateOrCreate(
            ['email' => 'luqmannawangk@gmail.com'],
            [
                'name' => 'LUQMAN NAWANG',
                'phone' => '081336046363',
                'address' => 'Jl. Mayjen HR. Muhammad No.35C, Kec. Sukomanunggal, Surabaya.',
                'bio' => 'Sales Konsultan Hyundai Surabaya yang siap membantu Anda mendapatkan mobil impian dengan penawaran terbaik.',
            ]
        );

        // Cars
        $cars = [
            [
                'name' => 'STARGAZER',
                'slug' => 'stargazer',
                'category' => 'MPV',
                'price' => 262300000,
                'description' => 'Bintang Baru Keluarga. MPV yang dirancang khusus untuk kenyamanan dan keamanan berkendara bersama keluarga tercinta.',
                'features' => ['Captain Seat', 'Tire Pressure Monitoring', 'Spacious Cabin', 'Hyundai SmartSense'],
                'image' => 'cars/stargazer.png',
                'hero_image' => 'cars/hero/hero_stargazer.png',
                'images' => ['cars/gallery/stargazer_interior.png'],
                'is_available' => true,
                'variants' => [
                    [
                        'name' => 'Active MT',
                        'price' => 262300000,
                        'transmission' => 'Manual 6-Speed',
                        'engine' => 'Smartstream G1.5 MPI',
                        'key_features' => ['Halogen Headlamps', '15-inch Steel Wheels', '2 Speakers Audio', 'Dual Airbags']
                    ],
                    [
                        'name' => 'Trend IVT',
                        'price' => 280200000,
                        'transmission' => 'IVT (Intelligent Variable)',
                        'engine' => 'Smartstream G1.5 MPI',
                        'key_features' => ['8-inch Display Audio', '16-inch Alloy Wheels', 'Rear View Monitor', 'Hyundai Bluelink']
                    ],
                    [
                        'name' => 'Style IVT',
                        'price' => 305300000,
                        'transmission' => 'IVT (Intelligent Variable)',
                        'engine' => 'Smartstream G1.5 MPI',
                        'key_features' => ['Full LED Headlamps', '4.2-inch Supervision Cluster', '6 Speakers Audio', 'Cruise Control']
                    ],
                    [
                        'name' => 'Prime IVT',
                        'price' => 320900000,
                        'transmission' => 'IVT (Intelligent Variable)',
                        'engine' => 'Smartstream G1.5 MPI',
                        'key_features' => ['Hyundai SmartSense Safety', 'Ambient Mood Lighting', 'Leather Seats', 'Bose Premium Sound System']
                    ]
                ]
            ],
            [
                'name' => 'STARGAZER Cartenz',
                'slug' => 'stargazer-cartenz',
                'category' => 'MPV',
                'price' => 245800000,
                'description' => 'MPV keluarga premium edisi Cartenz dengan kenyamanan kabin maksimal dan fitur konektivitas modern.',
                'features' => ['Captain Seat', 'Hyundai SmartSense', 'Kabin Luas 7-Seater', 'Wireless Charger'],
                'image' => 'cars/stargazer-cartenz.png',
                'hero_image' => 'cars/hero/stargazer_cartenz_official_hero.jpg',
                'images' => [
                    'cars/gallery/stargazer_cartenz_interior.jpg',
                    'cars/gallery/stargazer_cartenz_captain_seat.jpg',
                    'cars/gallery/stargazer_cartenz_table.jpg'
                ],
                'is_available' => true,
                'variants' => [
                    ['name' => 'Trend MT', 'price' => 245800000, 'transmission' => 'Manual 6-Speed', 'engine' => 'Smartstream 1.5L', 'key_features' => ['15-inch Wheels', 'Smartstream 1.5L', 'Dual Airbags']],
                    ['name' => 'Trend IVT', 'price' => 260800000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L', 'key_features' => ['8-inch Display Audio', 'Rear Camera', 'Bluelink']],
                    ['name' => 'Style IVT', 'price' => 275550000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L', 'key_features' => ['LED Headlamps', 'Cruise Control', 'Supervision Cluster']],
                    ['name' => 'Prime HSS IVT', 'price' => 322350000, 'transmission' => 'IVT', 'engine' => 'Smartstream 1.5L', 'key_features' => ['Hyundai SmartSense', 'Captain Seat', 'Bose Audio']]
                ]
            ],
            [
                'name' => 'STARGAZER X',
                'slug' => 'stargazer-x',
                'category' => 'Crossover',
                'price' => 335800000,
                'description' => 'Unleash the X in you. Perpaduan sempurna antara kelegaan MPV keluarga dengan kegagahan karakter SUV.',
                'features' => ['Bold Crossover Design', 'High Ground Clearance 200mm', 'Premium Roof Rails', 'Bose Audio'],
                'image' => 'cars/stargazer-cartenz-x.png',
                'hero_image' => 'cars/hero/stargazer_cartenz_official_hero.jpg',
                'images' => ['cars/gallery/stargazer_cartenz_interior.jpg'],
                'is_available' => true,
                'variants' => [
                    [
                        'name' => 'Style IVT',
                        'price' => 335800000,
                        'transmission' => 'IVT (Intelligent Variable)',
                        'engine' => 'Smartstream G1.5 MPI',
                        'key_features' => ['17-inch Diamond Cut Alloy Wheels', 'Crossover Body Kit', 'Ground Clearance 200mm', '8-inch Audio']
                    ],
                    [
                        'name' => 'Prime IVT',
                        'price' => 346400000,
                        'transmission' => 'IVT (Intelligent Variable)',
                        'engine' => 'Smartstream G1.5 MPI',
                        'key_features' => ['Hyundai SmartSense Safety', 'Bose Premium Sound System', 'Leatherette Seats with Red Stitching', 'Captain Seat Optional']
                    ]
                ]
            ],
            [
                'name' => 'The New CRETA',
                'slug' => 'the-new-creta',
                'category' => 'SUV',
                'price' => 297300000,
                'description' => 'Spotlight in every move. SUV compact yang dinamis dan berjiwa muda, dilengkapi dengan konektivitas tercanggih.',
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
                    [
                        'name' => 'Active MT',
                        'price' => 297300000,
                        'transmission' => 'Manual 6-Speed',
                        'engine' => 'Smartstream G1.5 MPI',
                        'key_features' => ['8-inch Touchscreen', '16-inch Silver Alloy Wheels', 'Dual Airbags', 'Tilt Steering']
                    ],
                    [
                        'name' => 'Trend IVT',
                        'price' => 319300000,
                        'transmission' => 'IVT (Intelligent Variable)',
                        'engine' => 'Smartstream G1.5 MPI',
                        'key_features' => ['Hyundai Bluelink', 'Wireless Smartphone Charger', 'Rear View Monitor', 'Rear USB Charger']
                    ],
                    [
                        'name' => 'Style IVT',
                        'price' => 383800000,
                        'transmission' => 'IVT (Intelligent Variable)',
                        'engine' => 'Smartstream G1.5 MPI',
                        'key_features' => ['LED Headlamps', 'Panoramic Sunroof', 'Bose Sound System (8 Speakers)', 'Ventilated Seats']
                    ],
                    [
                        'name' => 'Prime IVT',
                        'price' => 416800000,
                        'transmission' => 'IVT (Intelligent Variable)',
                        'engine' => 'Smartstream G1.5 MPI',
                        'key_features' => ['Hyundai SmartSense Safety', 'Red Accent Exterior Lines', 'Tire Pressure Monitoring System', '10.25-inch TFT Cluster']
                    ]
                ]
            ],
            [
                'name' => 'CRETA N Line',
                'slug' => 'creta-n-line',
                'category' => 'SUV',
                'price' => 477850000,
                'description' => 'Sensasi motorsport berkarakter agresif dengan performa mesin turbo dan sentuhan sporty khas N Line.',
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
                        'name' => 'N Line IVT',
                        'price' => 477850000,
                        'transmission' => 'Dual Clutch / IVT',
                        'engine' => '1.5 Turbo GDI',
                        'key_features' => ['N Line Dark Chrome Grille', '18-inch Diamond Cut Wheels', 'N Line Badging', 'Twin Tip Exhaust']
                    ],
                    [
                        'name' => 'Turbo DCT',
                        'price' => 525850000,
                        'transmission' => '7-Speed Dual Clutch',
                        'engine' => '1.5 Turbocharged (160 PS)',
                        'key_features' => ['7-Speed DCT Transmission', 'Paddle Shift', 'Sport Suspension', 'Full N Line Leather Seats']
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
                        'name' => 'Signature XRT 4WD',
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
                        'name' => 'Signature HEV',
                        'price' => 1136600000,
                        'transmission' => 'Automatic Hybrid 6-Speed',
                        'engine' => 'Hybrid Turbo (260 PS Kombinasi)',
                        'key_features' => ['Powertrain Turbo Hybrid Bertenaga', 'Dual Sunroof & Captain Seat 2nd Row', 'Curved Glass 12.3-inch Cockpit', 'Full Hyundai SmartSense ADAS']
                    ],
                    [
                        'name' => 'Calligraphy AWD HEV',
                        'price' => 1396500000,
                        'transmission' => 'HTRAC AWD Hybrid 6-Speed',
                        'engine' => 'Hybrid Turbo AWD (260 PS Kombinasi)',
                        'key_features' => ['HTRAC All-Wheel Drive', 'E-Suspension Elektronik Cerdas', 'Nappa Leather Eksklusif Calligraphy', 'Remote Smart Parking Assist (RSPA)']
                    ]
                ]
            ],
            [
                'name' => 'All-New SANTA FE',
                'slug' => 'santa-fe',
                'category' => 'SUV',
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
                        'name' => 'Prime 2.5 GDi',
                        'price' => 740500000,
                        'transmission' => '8-Speed Automatic',
                        'engine' => 'Smartstream G2.5 GDi (194 PS / 246 Nm)',
                        'key_features' => ['Panoramic Curved Display Dual 12.3-inch', 'H-Lights LED Depan & Belakang', 'Power Tailgate', 'Hyundai SmartSense Lengkap']
                    ],
                    [
                        'name' => 'Calligraphy 2.5 GDi',
                        'price' => 830000000,
                        'transmission' => '8-Speed Automatic',
                        'engine' => 'Smartstream G2.5 GDi (194 PS / 246 Nm)',
                        'key_features' => ['Nappa Leather Seats', 'Dual Wireless Phone Charger', 'Bose Premium Audio', 'UV-C Sterilization Tray']
                    ],
                    [
                        'name' => 'Calligraphy 1.6T Hybrid (HEV)',
                        'price' => 919400000,
                        'transmission' => '6-Speed Hybrid Automatic',
                        'engine' => 'Smartstream 1.6T-GDi HEV (235 PS / 367 Nm)',
                        'key_features' => ['Mesin Turbo Hybrid Performa Tinggi', 'Dynamic Torque Vectoring', 'E-Ride Comfort System', 'Relaxation Comfort Seats']
                    ]
                ]
            ],
            [
                'name' => 'STARIA',
                'slug' => 'staria',
                'category' => 'Luxury MPV',
                'price' => 924000000,
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
                        'name' => 'Signature 9-Seater',
                        'price' => 924000000,
                        'transmission' => '8-Speed Automatic',
                        'engine' => 'R 2.2 CRDi Diesel VGT (177 PS / 430 Nm)',
                        'key_features' => ['9 Premium Leather Seats', 'Swiveling Independent Seats (2nd row)', 'Dual Sunroof', 'Smart Power Sliding Door']
                    ],
                    [
                        'name' => 'Signature 7-Seater',
                        'price' => 1060000000,
                        'transmission' => '8-Speed Automatic',
                        'engine' => 'R 2.2 CRDi Diesel VGT (177 PS / 430 Nm)',
                        'key_features' => ['Premium Relaxation Seats (7 seats)', '12 Bose Premium Speakers', 'Surround View Monitor (360 Camera)', 'Full TFT Supervision Cluster']
                    ]
                ]
            ],
            [
                'name' => 'IONIQ 5',
                'slug' => 'ioniq-5',
                'category' => 'EV',
                'price' => 782000000,
                'description' => 'Power your world with the IONIQ 5. Era baru mobil listrik murni yang menggabungkan desain retro-futuristis dengan teknologi V2L revolusioner.',
                'features' => ['V2L Technology', 'Ultra-fast Charging', 'Sustainable Materials', 'Vision Roof'],
                'image' => 'cars/ioniq-5.png',
                'hero_image' => 'cars/hero/hero_ioniq5.png',
                'images' => ['cars/gallery/ioniq5_interior.png'],
                'is_available' => true,
                'variants' => [
                    [
                        'name' => 'Standard Range Prime',
                        'price' => 782000000,
                        'transmission' => 'Single Speed Reduction Gear',
                        'engine' => 'Electric Motor (58 kWh Battery)',
                        'key_features' => ['Range 384 km', 'V2L Outlets', 'Hyundai SmartSense', 'Parametric Pixel LED']
                    ],
                    [
                        'name' => 'Long Range Prime',
                        'price' => 809000000,
                        'transmission' => 'Single Speed Reduction Gear',
                        'engine' => 'Electric Motor (72.6 kWh Battery)',
                        'key_features' => ['Range 481 km', 'V2L Outlets', 'Hyundai SmartSense', '19-inch Alloy Wheels']
                    ],
                    [
                        'name' => 'Long Range Signature',
                        'price' => 895000000,
                        'transmission' => 'Single Speed Reduction Gear',
                        'engine' => 'Electric Motor (72.6 kWh Battery)',
                        'key_features' => ['Range 481 km', 'Vision Roof', 'Bose Premium Audio', 'Premium Relaxation Seats']
                    ]
                ]
            ],
            [
                'name' => 'All-New KONA Electric',
                'slug' => 'kona-electric',
                'category' => 'EV',
                'price' => 570250000,
                'description' => 'EV SUV generasi terbaru yang dirancang langsung sebagai kendaraan listrik, dengan jarak tempuh hingga 600 KM dan baterai lokal.',
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
                        'name' => 'Style Standard Range',
                        'price' => 570250000,
                        'transmission' => 'Single Speed',
                        'engine' => 'Electric 48.4 kWh (Range 448 km)',
                        'key_features' => ['Dual 12.3-inch Panoramic Display', 'Hyundai Bluelink', 'V2L Indoor', 'SmartSense Safety']
                    ],
                    [
                        'name' => 'Prime Long Range',
                        'price' => 639500000,
                        'transmission' => 'Single Speed',
                        'engine' => 'Electric 65.4 kWh (Range 605 km)',
                        'key_features' => ['Jarak Tempuh Hingga 605 KM', '17-inch Aero Wheels', 'Fast Charging 10-80% 43 menit', 'Ambient Lighting']
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
        ];

        foreach ($cars as $car) {
            Car::updateOrCreate(['slug' => $car['slug']], $car);
        }
    }
}
