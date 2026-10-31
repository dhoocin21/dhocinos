<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class UpdateCarSpecificationsSeeder extends Seeder
{
    public function run(): void
    {
        $carsData = [
            'stargazer-cartenz-x' => [
                'features' => [
                    'Shift By Wire (SBW)',
                    'Driver Ventilated Seat & 8-Way Power Seat',
                    'BOSE™ Premium 8-Speaker Audio System',
                    'Paddle Shifter & Cruise Control',
                    'Dedicated X Crossover Cladding & Roof Rails',
                    'Hyundai SmartSense ADAS Lengkap'
                ],
                'variants' => [
                    [
                        'name' => 'Style IVT',
                        'price' => 354400000,
                        'transmission' => 'IVT (Intelligent Variable)',
                        'engine' => 'Smartstream G1.5 MPI (115 PS / 143.8 Nm)',
                        'key_features' => [
                            'Smartstream G1.5 MPI Engine 115 PS',
                            'Roof Rails & Crossover Cladding',
                            'LED MFR Headlamps & DRL Horizon',
                            'Cruise Control & Manual Speed Limit',
                            'Rear Disc Brakes & Electronic Parking Brake (EPB)',
                            '8-inch Touch Audio with Smartphone Connectivity'
                        ]
                    ],
                    [
                        'name' => 'Prime Package IVT',
                        'price' => 389400000,
                        'transmission' => 'IVT (Intelligent Variable)',
                        'engine' => 'Smartstream G1.5 MPI (115 PS / 143.8 Nm)',
                        'key_features' => [
                            'Full Hyundai SmartSense (FCA, LKA, BCA, RCCA, DAW)',
                            'BOSE™ Premium Audio 8-Speaker System',
                            'Driver Ventilated Seat & 8-Way Power Seat',
                            'Captain Seat with Armrest',
                            'Ambient Mood Lighting & Full TFT Digital Cluster',
                            'Wireless Smartphone Charger'
                        ]
                    ]
                ]
            ],
            'stargazer-cartenz' => [
                'features' => [
                    'Captain Seat Option',
                    'Hyundai SmartSense Active Safety',
                    'Tire Pressure Monitoring System (TPMS)',
                    'Kabin Luas 7-Seater dengan Multi-Storage Compartment',
                    'Wireless Smartphone Charger'
                ],
                'variants' => [
                    [
                        'name' => 'Trend MT',
                        'price' => 245800000,
                        'transmission' => 'Manual 6-Speed',
                        'engine' => 'Smartstream G1.5 MPI (115 PS / 143.8 Nm)',
                        'key_features' => [
                            '8-inch Touchscreen Audio',
                            'Rear View Monitor (RVM)',
                            'High-Mount Stop Lamp LED',
                            'Dual Airbags & ABS/EBD'
                        ]
                    ],
                    [
                        'name' => 'Trend IVT',
                        'price' => 260800000,
                        'transmission' => 'IVT (Intelligent Variable)',
                        'engine' => 'Smartstream G1.5 MPI (115 PS / 143.8 Nm)',
                        'key_features' => [
                            'Transmisi IVT Halus & Responsif',
                            'Hill-Start Assist Control (HAC)',
                            'Electronic Stability Control (ESC)',
                            'Rear Parking Sensor'
                        ]
                    ],
                    [
                        'name' => 'Style IVT',
                        'price' => 275550000,
                        'transmission' => 'IVT (Intelligent Variable)',
                        'engine' => 'Smartstream G1.5 MPI (115 PS / 143.8 Nm)',
                        'key_features' => [
                            'LED Multi Focus Reflector Headlamps',
                            'Cruise Control & Manual Speed Limiter',
                            '16-inch Diamond Cut Alloy Wheels',
                            'Tire Pressure Monitoring System (TPMS)'
                        ]
                    ],
                    [
                        'name' => 'Smart Non HSS IVT',
                        'price' => 289350000,
                        'transmission' => 'IVT (Intelligent Variable)',
                        'engine' => 'Smartstream G1.5 MPI (115 PS / 143.8 Nm)',
                        'key_features' => [
                            'Horizontal LED DRL khas Stargazer',
                            'Push Start Button & Smart Key',
                            'Wireless Smartphone Charger',
                            'Kamera Parkir dengan Dynamic Guide'
                        ]
                    ],
                    [
                        'name' => 'Smart HSS IVT',
                        'price' => 299350000,
                        'transmission' => 'IVT (Intelligent Variable)',
                        'engine' => 'Smartstream G1.5 MPI (115 PS / 143.8 Nm)',
                        'key_features' => [
                            'Hyundai SmartSense (FCA, LKA, LFA)',
                            'High Beam Assist (HBA)',
                            'Driver Attention Warning (DAW)',
                            'Rear Cross-Traffic Collision Warning'
                        ]
                    ],
                    [
                        'name' => 'Prime Non HSS IVT',
                        'price' => 312350000,
                        'transmission' => 'IVT (Intelligent Variable)',
                        'engine' => 'Smartstream G1.5 MPI (115 PS / 143.8 Nm)',
                        'key_features' => [
                            'Full Leatherette Seats',
                            'Ambient Mood Lamp Blue',
                            '6 Airbags (Front, Side & Curtain)',
                            'Opsi Captain Seat Baris Kedua'
                        ]
                    ],
                    [
                        'name' => 'Prime HSS IVT',
                        'price' => 322350000,
                        'transmission' => 'IVT (Intelligent Variable)',
                        'engine' => 'Smartstream G1.5 MPI (115 PS / 143.8 Nm)',
                        'key_features' => [
                            'Full Hyundai SmartSense Lengkap (FCA, LKA, LFA, BCA, RCCA)',
                            '6 Airbags Keselamatan Maksimal',
                            'Leather Seat + Captain Seat Ready',
                            'BOSE Sound System Audio Clarity'
                        ]
                    ]
                ]
            ],
            'stargazer' => [
                'features' => [
                    'Smartstream G1.5 MPI Engine',
                    'Kabin Paling Lega di Kelasnya',
                    'Layar TFT Meter Cluster 4.2 Inch',
                    'Fitur Keselamatan Modern & Bluelink'
                ],
                'variants' => [
                    [
                        'name' => 'Active+ MT Steel Wheel',
                        'price' => 260450000,
                        'transmission' => 'Manual 6-Speed',
                        'engine' => 'Smartstream G1.5 MPI (115 PS)',
                        'key_features' => [
                            'Transmisi Manual 6-Percepatan Presisi',
                            '8-inch Touch Audio with Smartphone Sync',
                            'Dual Front Airbags',
                            'Rear AC Blower'
                        ]
                    ],
                    [
                        'name' => 'Active+ MT',
                        'price' => 262950000,
                        'transmission' => 'Manual 6-Speed',
                        'engine' => 'Smartstream G1.5 MPI (115 PS)',
                        'key_features' => [
                            'Alloy Wheel 15-inch Dual Tone',
                            '8-inch Touchscreen Infotainment',
                            'Reverse Parking Camera',
                            'Digital AC Control'
                        ]
                    ],
                    [
                        'name' => 'Active+ IVT Steel Wheel',
                        'price' => 273800000,
                        'transmission' => 'IVT Automatic',
                        'engine' => 'Smartstream G1.5 MPI (115 PS)',
                        'key_features' => [
                            'Transmisi Otomatis IVT Efisien & Halus',
                            'Hill-start Assist Control',
                            'Electronic Stability Control',
                            'Emergency Stop Signal'
                        ]
                    ],
                    [
                        'name' => 'Active+ IVT',
                        'price' => 276300000,
                        'transmission' => 'IVT Automatic',
                        'engine' => 'Smartstream G1.5 MPI (115 PS)',
                        'key_features' => [
                            'Alloy Wheels 15-inch',
                            'Transmisi IVT Intelligent Variable',
                            'Rear View Monitor (RVM)',
                            'Audio Steering Switch'
                        ]
                    ],
                    [
                        'name' => 'Essential MT',
                        'price' => 275050000,
                        'transmission' => 'Manual 6-Speed',
                        'engine' => 'Smartstream G1.5 MPI (115 PS)',
                        'key_features' => [
                            'LED Multi Focus Reflector Headlamps',
                            'Horizon DRL LED Bar',
                            'Smart Key with Push Start',
                            'Tire Pressure Monitoring System (TPMS)'
                        ]
                    ],
                    [
                        'name' => 'Essential IVT',
                        'price' => 286750000,
                        'transmission' => 'IVT Automatic',
                        'engine' => 'Smartstream G1.5 MPI (115 PS)',
                        'key_features' => [
                            'Transmisi Otomatis IVT dengan Drive Mode (Eco, Normal, Sport, Smart)',
                            'LED Headlamps & Horizon DRL',
                            'Cruise Control',
                            'Smart Keyless Entry & Remote Start'
                        ]
                    ]
                ]
            ],
            'santa-fe' => [
                'features' => [
                    'Panoramic Curved Display 12.3-inch Dual Screen',
                    'Mesin Turbo Hybrid Ramah Lingkungan & Bertenaga',
                    'Relaxation Comfort Seats with Calf Support',
                    'Hyundai Bluelink Connected Car Services',
                    'Surround View Monitor (Kamera 360°)',
                    'Hyundai SmartSense Keselamatan Level 2'
                ],
                'variants' => [
                    [
                        'name' => 'G 2.5 6AT Prime',
                        'price' => 740500000,
                        'transmission' => 'Automatic 6-Speed',
                        'engine' => 'Smartstream G2.5 GDI Bensin (194 PS / 246 Nm)',
                        'key_features' => [
                            'Panoramic Curved Display Dual 12.3-inch',
                            'Power Tailgate dengan Smart Access',
                            'Hyundai SmartSense Active Safety',
                            'Wireless Dual Smartphone Charger',
                            'LED Horizon Projection Headlamps'
                        ]
                    ],
                    [
                        'name' => 'G 2.5 6AT Calligraphy',
                        'price' => 830000000,
                        'transmission' => 'Automatic 6-Speed',
                        'engine' => 'Smartstream G2.5 GDI Bensin (194 PS / 246 Nm)',
                        'key_features' => [
                            'Dual Sunroof & Nappa Leather Interior',
                            'Relaxation Comfort Seats Baris 1 & 2',
                            'Surround View Monitor (360° Camera)',
                            'Blind-Spot View Monitor di Cluster',
                            'BOSE Premium Sound 12-Speaker'
                        ]
                    ],
                    [
                        'name' => 'HEV Prime',
                        'price' => 832100000,
                        'transmission' => 'Hybrid 6-Speed Automatic',
                        'engine' => '1.6T-GDi HEV Turbo Hybrid (235 PS / 367 Nm Kombinasi)',
                        'key_features' => [
                            'Turbocharged Hybrid Powertrain 235 PS',
                            'Efisiensi Bahan Bakar Luar Biasa (Hingga 18+ km/L)',
                            'Drive & Terrain Modes (Eco, Sport, Smart)',
                            'Curved Glass Cockpit Display 12.3-inch',
                            'Full Hyundai SmartSense'
                        ]
                    ],
                    [
                        'name' => 'HEV Calligraphy',
                        'price' => 919400000,
                        'transmission' => 'Hybrid 6-Speed Automatic',
                        'engine' => '1.6T-GDi HEV Turbo Hybrid (235 PS / 367 Nm Kombinasi)',
                        'key_features' => [
                            'Kemewahan Calligraphy dengan Material Nappa Leather Asli',
                            'Dual Wireless Fast Charging Pad',
                            'Digital Center Mirror (Kamera Spion Dalam)',
                            'Remote Smart Parking Assist (Maju-Mundur dari Remote)',
                            'Head-Up Display (HUD) Full Color'
                        ]
                    ],
                    [
                        'name' => 'HEV XRT',
                        'price' => 937100000,
                        'transmission' => 'Hybrid AWD 6-Speed Automatic',
                        'engine' => '1.6T-GDi HEV Turbo Hybrid AWD (235 PS)',
                        'key_features' => [
                            'Sistem Penggerak Semua Roda HTRAC All-Wheel Drive',
                            'XRT Exclusive Rugged All-Black Exterior Styling',
                            'All-Terrain Wheels & Raised Ground Clearance',
                            'Roof Crossbars & Expedition Gear Ready',
                            'Dark Chrome Grille & Matte Badging'
                        ]
                    ]
                ]
            ],
            'ioniq-5' => [
                'features' => [
                    'Platform Khusus Mobil Listrik E-GMP',
                    'Ultra-Fast Charging 800V (10% - 80% hanya 18 menit)',
                    'Fitur V2L (Vehicle-to-Load) Listrik Portabel 3.6 kW',
                    'Vision Panoramic Roof Luas Tanpa Pilar Pemisah',
                    'Interior Ramah Lingkungan Berbahan Daur Ulang Premium',
                    'Garansi Baterai 8 Tahun / 160.000 KM'
                ],
                'variants' => [
                    [
                        'name' => 'Prime Standard Range',
                        'price' => 813500000,
                        'transmission' => 'Single Speed Reduction Gear',
                        'engine' => 'Permanent Magnet Synchronous Motor 58 kWh (170 PS / 350 Nm, 384 KM)',
                        'key_features' => [
                            'Jarak Tempuh 384 KM (NEDC)',
                            'Layar Ganda 12.3-inch Full TFT Cockpit',
                            'Vehicle-to-Load (V2L) Indoor Port',
                            'Fast DC Charging & AC Type 2 Port',
                            'Hyundai SmartSense Basic ADAS'
                        ]
                    ],
                    [
                        'name' => 'Prime Long Range',
                        'price' => 856500000,
                        'transmission' => 'Single Speed Reduction Gear',
                        'engine' => 'Permanent Magnet Synchronous Motor 72.6 kWh (217 PS / 350 Nm, 481 KM)',
                        'key_features' => [
                            'Jarak Tempuh Jauh 481 KM (NEDC)',
                            'Akselerasi 0-100 km/h dalam 7.4 Detik',
                            'Baterai Kapasitas Besar 72.6 kWh',
                            'Dual Zone Auto Climate Control',
                            'Smart Power Tailgate'
                        ]
                    ],
                    [
                        'name' => 'Signature Standard Range',
                        'price' => 878900000,
                        'transmission' => 'Single Speed Reduction Gear',
                        'engine' => 'Permanent Magnet Synchronous Motor 58 kWh (170 PS / 350 Nm, 384 KM)',
                        'key_features' => [
                            'Vision Panoramic Glass Roof',
                            'V2L Eksternal Adapter (Colokan Listrik Luar Mobil)',
                            'Premium Relaxation Front Seats with Ottoman',
                            'Surround View Monitor (Kamera 360°)',
                            'Full Hyundai SmartSense (FCA-JT, BVM, PCA, HDA)'
                        ]
                    ],
                    [
                        'name' => 'Signature Long Range',
                        'price' => 930600000,
                        'transmission' => 'Single Speed Reduction Gear',
                        'engine' => 'Permanent Magnet Synchronous Motor 72.6 kWh (217 PS / 350 Nm, 481 KM)',
                        'key_features' => [
                            'Varian Tertinggi Jarak Jauh 481 KM & Fitur Paling Komplit',
                            'Velg Futuristik 20-inch Parametric Pixel',
                            'Bose Premium 8-Speaker Audio System',
                            'Vision Roof & Full Relaxation Comfort Seats',
                            'Vehicle-to-Load (V2L) Indoor & Outdoor 3.6 kW'
                        ]
                    ]
                ]
            ],
            'creta' => [
                'features' => [
                    'Parametric Jewel Hidden DRL yang Ikonik',
                    'Panoramic Sunroof Luas',
                    'Ventilated Seats Kursi Berpendingin Udara',
                    'Bose Premium Audio System',
                    'Hyundai Bluelink (Nyalakan Mesin & AC via Smartphone)',
                    'Hyundai SmartSense Active Safety'
                ],
                'variants' => [
                    [
                        'name' => 'Active 1.5 MT',
                        'price' => 312650000,
                        'transmission' => 'Manual 6-Speed',
                        'engine' => 'Smartstream G1.5 MPI (115 PS / 143.8 Nm)',
                        'key_features' => [
                            'Mesin Bensin 1.5L Irit & Bertenaga',
                            '8-inch Display Audio with Smartphone Connectivity',
                            'Emergency Stop Signal & Hill-Start Assist',
                            'Rear Camera with Dynamic Guide'
                        ]
                    ],
                    [
                        'name' => 'Trend 1.5 MT',
                        'price' => 345450000,
                        'transmission' => 'Manual 6-Speed',
                        'engine' => 'Smartstream G1.5 MPI (115 PS / 143.8 Nm)',
                        'key_features' => [
                            '17-inch Diamond Cut Alloy Wheels',
                            'Full TFT 10.25-inch Digital Meter Cluster',
                            'Hyundai Bluelink Connected Car Service',
                            'Tire Pressure Monitoring System (TPMS)'
                        ]
                    ],
                    [
                        'name' => 'Trend 1.5 IVT',
                        'price' => 366500000,
                        'transmission' => 'IVT Automatic',
                        'engine' => 'Smartstream G1.5 MPI (115 PS / 143.8 Nm)',
                        'key_features' => [
                            'Transmisi Otomatis IVT Halus',
                            'Drive Mode Select (Eco, Comfort, Smart, Sport)',
                            'Traction Mode (Snow, Mud, Sand)',
                            'Paddle Shifter di Balik Kemudi'
                        ]
                    ],
                    [
                        'name' => 'Style 1.5 IVT',
                        'price' => 412200000,
                        'transmission' => 'IVT Automatic',
                        'engine' => 'Smartstream G1.5 MPI (115 PS / 143.8 Nm)',
                        'key_features' => [
                            'LED Multi Focus Reflector Headlamps',
                            'Blind-Spot Collision-Avoidance Assist (BCA)',
                            'Safe Exit Warning (SEW)',
                            'BOSE Premium 8-Speaker Audio System',
                            'Wireless Smartphone Charger'
                        ]
                    ],
                    [
                        'name' => 'Prime 1.5 IVT 1 Tone',
                        'price' => 443350000,
                        'transmission' => 'IVT Automatic',
                        'engine' => 'Smartstream G1.5 MPI (115 PS / 143.8 Nm)',
                        'key_features' => [
                            'Panoramic Sunroof Mewah',
                            'Front Ventilated Seats (Jok Adem)',
                            'Full Hyundai SmartSense (FCA, LKA, LFA, BCA, RCCA)',
                            'Air Purifier dengan Tampilan Digital',
                            'Ambient Mood Lighting'
                        ]
                    ],
                    [
                        'name' => 'Alpha',
                        'price' => 459850000,
                        'transmission' => 'IVT Automatic',
                        'engine' => 'Smartstream G1.5 MPI (115 PS / 143.8 Nm)',
                        'key_features' => [
                            'Edisi Spesial Warna Matte (Midnight Black, Magnetic Silver, Optic White Matte)',
                            'Black Out Grille & Dark Badging',
                            'Interior Monotone Black dengan Jahitan Kontras Merah',
                            'Fitur Lengkap Setara Varian Prime + Sunroof'
                        ]
                    ]
                ]
            ],
            'creta-n-line' => [
                'features' => [
                    'Sporty N Line Bodykit & Parametric Jewel Grille with N Logo',
                    'Mesin 1.5 Turbo GDI Performa Tinggi 160 PS',
                    'Transmisi 7-Speed Dual Clutch (DCT) Responsif',
                    'Sport Interior dengan N Steering Wheel, Leather Seat & Red Stitching',
                    'Twin Exhaust Tip Bernuansa Balap',
                    'Hyundai SmartSense & Panoramic Sunroof'
                ],
                'variants' => [
                    [
                        'name' => 'N Line',
                        'price' => 477850000,
                        'transmission' => '7-Speed Dual Clutch (DCT)',
                        'engine' => '1.5 Turbo GDI (160 PS / 253 Nm)',
                        'key_features' => [
                            'N Line Dedicated Aerodynamic Bumper & Grille',
                            '18-inch N Line Exclusive Alloy Wheels',
                            'Suspensi Lebih Stabil & Handling Presisi',
                            'Panoramic Sunroof & Jok Kulit N Line',
                            'Paddle Shifter & Mode Berkendara Sport'
                        ]
                    ],
                    [
                        'name' => 'Turbo',
                        'price' => 525850000,
                        'transmission' => '7-Speed Dual Clutch (DCT)',
                        'engine' => '1.5 Turbo GDI Performa Maksimal (160 PS / 253 Nm)',
                        'key_features' => [
                            'Fitur Tertinggi dengan Full Hyundai SmartSense ADAS Level 2',
                            'BOSE Sound System 8-Speaker',
                            'Surround 360 Monitor & Blind-Spot Monitor',
                            'Ventilated Sport Seats dengan Pemanas & Pendingin',
                            'Dual Tip Racing Exhaust Sound Tuning'
                        ]
                    ]
                ]
            ],
            'palisade' => [
                'features' => [
                    'Flagship Luxury SUV 7-Seater',
                    'Mesin Tangguh 2.2L CRDi Diesel VGT (200 PS / 440 Nm)',
                    'Shift-By-Wire 8-Speed Automatic Transmission',
                    'Captain Seat Baris Kedua dengan Ventilasi & Pemanas',
                    'Dual Sunroof & Nappa Leather Interior',
                    'Full Hyundai SmartSense Active Safety'
                ],
                'variants' => [
                    [
                        'name' => 'Prime',
                        'price' => 952800000,
                        'transmission' => '8-Speed Automatic Shift-By-Wire',
                        'engine' => '2.2L CRDi Diesel VGT (200 PS / 440 Nm)',
                        'key_features' => [
                            'Layar Infotainment 12.3-inch Touchscreen Navigation',
                            'Captain Seat Baris 2 dengan Ruang Ekstra Luas',
                            'Dual Zone Auto Climate Control & AC Baris Belakang',
                            'Power Tailgate Cerdas',
                            'Hyundai SmartSense (FCA, LKA, LFA, DAW)'
                        ]
                    ],
                    [
                        'name' => 'Signature',
                        'price' => 1098700000,
                        'transmission' => '8-Speed Automatic Shift-By-Wire',
                        'engine' => '2.2L CRDi Diesel VGT (200 PS / 440 Nm)',
                        'key_features' => [
                            'Jok Kulit Mewah Asli Nappa Leather',
                            'Dual Sunroof (Depan & Belakang)',
                            'Ventilated & Heated Seats Baris 1 & 2',
                            'Surround View Monitor (Kamera 360°)',
                            'Blind-spot View Monitor (BVM) di Panel Instrumen',
                            'Wireless Smartphone Charger'
                        ]
                    ],
                    [
                        'name' => 'Signature XRT',
                        'price' => 1127600000,
                        'transmission' => '8-Speed Automatic Shift-By-Wire',
                        'engine' => '2.2L CRDi Diesel VGT (200 PS / 440 Nm)',
                        'key_features' => [
                            'Sentuhan XRT All-Black Dark Exterior Package',
                            'Velg Khusus 20-inch Dark Alloy Wheels',
                            'Dark Front Grille & Rugged Lower Bumper Guard',
                            'Black Roof Rails Berprofil Kokoh',
                            'Emblem & Aksesori Khusus XRT Series'
                        ]
                    ],
                    [
                        'name' => 'Signature 4WD XRT',
                        'price' => 1268500000,
                        'transmission' => '8-Speed Automatic HTRAC AWD',
                        'engine' => '2.2L CRDi Diesel VGT AWD (200 PS / 440 Nm)',
                        'key_features' => [
                            'Sistem Penggerak 4 Roda HTRAC All-Wheel Drive',
                            'Multi-Terrain Mode (Snow, Mud, Sand)',
                            'Paket XRT Dark Edition Lengkap',
                            'Performa Off-Road & On-Road Terbaik',
                            'Kemewahan Maksimal Full Nappa Leather + Sunroof'
                        ]
                    ]
                ]
            ],
            'palisade-hev' => [
                'features' => [
                    'Flagship Hybrid Turbo SUV',
                    'Kombinasi Tenaga Tangguh 260 PS & Efisiensi Bahan Bakar Tinggi',
                    'HTRAC All-Wheel Drive All-Weather Capability',
                    'Interior Nappa Leather Calligraphy Ultra-Mewah',
                    'Suspensi Elektronik Kenyamanan Kelas Atas'
                ],
                'variants' => [
                    [
                        'name' => 'Signature',
                        'price' => 1136600000,
                        'transmission' => 'Automatic Hybrid 6-Speed',
                        'engine' => 'Hybrid Turbo Powertrain (260 PS Kombinasi)',
                        'key_features' => [
                            'Powertrain Turbo Hybrid Bertenaga & Halus',
                            'Dual Sunroof & Captain Seat 2nd Row',
                            'Curved Glass 12.3-inch Cockpit',
                            'Full Hyundai SmartSense ADAS',
                            'Smart Power Tailgate'
                        ]
                    ],
                    [
                        'name' => 'Calligraphy',
                        'price' => 1309400000,
                        'transmission' => 'Automatic Hybrid 6-Speed',
                        'engine' => 'Hybrid Turbo Powertrain (260 PS Kombinasi)',
                        'key_features' => [
                            'Finishing Tertinggi Calligraphy Signature Grille',
                            'Kulit Nappa Quilted Seat dengan Microfiber Headliner',
                            'Ergo-Motion Driver Seat dengan Fungsi Pijat',
                            'Bose/Infinity Surround Audio System',
                            'Digital Rearview Mirror & Remote Smart Parking'
                        ]
                    ],
                    [
                        'name' => 'Calligraphy AWD',
                        'price' => 1396500000,
                        'transmission' => 'Automatic HTRAC AWD Hybrid',
                        'engine' => 'Hybrid Turbo Powertrain AWD (260 PS Kombinasi)',
                        'key_features' => [
                            'Penggerak 4 Roda Cerdas HTRAC AWD',
                            'Terrain Management System',
                            'Kelengkapan Calligraphy Super Mewah Paling Komplit',
                            'Head-Up Display & Dual Pane Soundproof Glass'
                        ]
                    ],
                    [
                        'name' => 'New MY 27 Signature',
                        'price' => 1138700000,
                        'transmission' => 'Automatic Hybrid',
                        'engine' => 'Smart Hybrid 2.5T Powertrain Generasi Baru',
                        'key_features' => [
                            'Pembaruan Model Year Terbaru',
                            'Optimasi Efisiensi Baterai Generasi Ke-4',
                            'Infotainment ccNC Generasi Baru dengan OTA Update',
                            'Hyundai SmartSense Generasi Terbaru'
                        ]
                    ],
                    [
                        'name' => 'New MY 27 Calligraphy',
                        'price' => 1325700000,
                        'transmission' => 'Automatic Hybrid',
                        'engine' => 'Smart Hybrid 2.5T Powertrain Generasi Baru',
                        'key_features' => [
                            'Desain Calligraphy Terbaru dengan Velg Desain Baru',
                            'Ambient Mood Lighting Dynamic 64 Warna',
                            'Relaxation Comfort Seats dengan Pijat Otomatis',
                            'Full Digital Key 2.0 (Buka Pintu Pakai Apple/Samsung Wallet)'
                        ]
                    ],
                    [
                        'name' => 'New MY 27 Calligraphy AWD',
                        'price' => 1412700000,
                        'transmission' => 'Automatic HTRAC AWD Hybrid',
                        'engine' => 'Smart Hybrid 2.5T Powertrain AWD Generasi Baru',
                        'key_features' => [
                            'Varian Tertinggi Palisade Hybrid AWD Generasi Baru',
                            'Sistem AWD Cerdas dengan Torque Vectoring',
                            'Kemewahan Kelas Tertinggi di Segmen Premium SUV'
                        ]
                    ]
                ]
            ],
            'staria' => [
                'features' => [
                    'Desain Pesawat Luar Angkasa Futuristik',
                    'Jendela Panorama Raksasa dengan Visibilitas Terbaik',
                    'Mesin Diesel 2.2 CRDi (177 PS / 430 Nm) Bertenaga',
                    'Pilihan Konfigurasi 7-Seater Luxury atau 9-Seater Fleksibel',
                    'Smart Power Sliding Doors & Smart Power Tailgate',
                    'BOSE Premium Sound System 12-Speaker'
                ],
                'variants' => [
                    [
                        'name' => '9 Seaters Signature',
                        'price' => 966700000,
                        'transmission' => 'Automatic 8-Speed Shift-by-Wire',
                        'engine' => '2.2L CRDi Diesel (177 PS / 430 Nm)',
                        'key_features' => [
                            'Kapasitas 9 Penumpang Luas & Fleksibel',
                            'Kursi Baris Ke-2 Bisa Diputar 180 Derajat (Swiveling Seats)',
                            'Layar Display 10.25-inch TFT Cluster & 8-inch Audio',
                            'Pintu Geser Elektrik Cerdas Tanpa Sentuh',
                            'Full Hyundai SmartSense Active Safety'
                        ]
                    ],
                    [
                        'name' => '7 Seaters Signature',
                        'price' => 1107500000,
                        'transmission' => 'Automatic 8-Speed Shift-by-Wire',
                        'engine' => '2.2L CRDi Diesel (177 PS / 430 Nm)',
                        'key_features' => [
                            'Premium Relaxation Seats Kursi Baris 2 dengan Sandaran Kaki (Ottoman)',
                            'Kursi dengan Fungsi Pemanas & Pendingin Udara (Ventilated)',
                            'Dual Sunroof Luas',
                            'BOSE Premium 12-Speaker Audio System',
                            'Material Jok Kulit Nappa Halus'
                        ]
                    ]
                ]
            ],
            'kona-electric' => [
                'features' => [
                    'Pixelated Seamless Horizon Lamp yang Futuristik',
                    'Jarak Tempuh Hingga 549 KM Sekali Pengisian Daya',
                    'Dual Curved Display 12.3-inch Cockpit',
                    'Fitur V2L (Vehicle-to-Load) Pengisi Daya Alat Elektronik',
                    'Garansi Baterai 8 Tahun / 160.000 KM',
                    'Fitur Hyundai Bluelink & Over-The-Air (OTA) Updates'
                ],
                'variants' => [
                    [
                        'name' => 'Style',
                        'price' => 570250000,
                        'transmission' => 'Single Speed Reduction Gear',
                        'engine' => 'Motor Listrik 48.4 kWh (156 PS, Jarak 448 KM WLTP)',
                        'key_features' => [
                            'Jarak Tempuh 448 KM WLTP Efisien',
                            'Dual Panoramic Display 12.3-inch',
                            'Shift-by-wire Tuas Transmisi di Kolom Kemudi',
                            'Smart Regenerative Braking & i-Pedal'
                        ]
                    ],
                    [
                        'name' => 'Prime Standard Range',
                        'price' => 588500000,
                        'transmission' => 'Single Speed Reduction Gear',
                        'engine' => 'Motor Listrik 48.4 kWh (156 PS, Jarak 448 KM WLTP)',
                        'key_features' => [
                            'LED Headlamps & Seamless Horizon Lamp',
                            'Vehicle-to-Load (V2L) Indoor Outlet',
                            'Smart Power Tailgate',
                            'Hyundai SmartSense Active Safety'
                        ]
                    ],
                    [
                        'name' => 'Prime Long Range',
                        'price' => 639500000,
                        'transmission' => 'Single Speed Reduction Gear',
                        'engine' => 'Motor Listrik 65.4 kWh (217 PS, Jarak 549 KM WLTP)',
                        'key_features' => [
                            'Baterai Kapasitas Besar Jarak Tempuh 549 KM',
                            'Tenaga Lebih Bertenaga 217 PS',
                            'Fast DC Charging Cepat',
                            'Blind-spot Collision-Avoidance Assist'
                        ]
                    ],
                    [
                        'name' => 'Signature Standard Range',
                        'price' => 656650000,
                        'transmission' => 'Single Speed Reduction Gear',
                        'engine' => 'Motor Listrik 48.4 kWh (156 PS, Jarak 448 KM WLTP)',
                        'key_features' => [
                            'Jok Kulit Mewah dengan Ventilasi Udara Dingin',
                            'Surround View Monitor 360°',
                            'Blind-Spot View Monitor di Panel Instrumen',
                            'Sunroof & Ambient Lighting 64 Warna',
                            'BOSE Premium Sound System'
                        ]
                    ],
                    [
                        'name' => 'Signature Long Range',
                        'price' => 673550000,
                        'transmission' => 'Single Speed Reduction Gear',
                        'engine' => 'Motor Listrik 65.4 kWh (217 PS, Jarak 549 KM WLTP)',
                        'key_features' => [
                            'Kombinasi Terbaik: Jarak 549 KM + Kemewahan Paling Komplit',
                            'Sunroof & Jok Kulit Berpendingin (Ventilated)',
                            'BOSE Sound System 8-Speaker',
                            'V2L Indoor & Outdoor Adapter 3.6 kW',
                            'Full Hyundai SmartSense Level 2'
                        ]
                    ],
                    [
                        'name' => 'N Line',
                        'price' => 694550000,
                        'transmission' => 'Single Speed Reduction Gear',
                        'engine' => 'Motor Listrik N Line Performance 65.4 kWh (217 PS)',
                        'key_features' => [
                            'Varian Sporty Pertama Mobil Listrik Kona N Line',
                            '19-inch N Line Exclusive Alloy Wheels',
                            'Jok Alcantara & Kulit dengan Aksen Jahitan Merah',
                            'N Line Sport Bumpers, Side Skirts, & Wing Spoiler',
                            'Pedal Metalik Sport & Setir Khusus N'
                        ]
                    ]
                ]
            ],
            'ioniq-9' => [
                'features' => [
                    'Flagship 3-Row All-Electric SUV dari Hyundai',
                    'Kapasitas Baterai Raksasa 110.3 kWh (Jarak Tempuh Hingga 620 KM)',
                    'Penggerak Dual Motor All-Wheel Drive (AWD) 313 PS',
                    'Universal Island 2.0 Sliding Center Console',
                    'Kursi Swivel 180 Derajat atau Relaxation Massage Seats',
                    'Ultra-Fast Charging 800V'
                ],
                'variants' => [
                    [
                        'name' => 'Calligraphy AWD 6P Swivel Seat',
                        'price' => 1547000000,
                        'transmission' => 'Dual Motor Electric AWD',
                        'engine' => 'Dual Motor Electric 110.3 kWh Battery (313 PS / 605 Nm)',
                        'key_features' => [
                            'Kursi Baris Ke-2 Swivel Dapat Diputar 180 Derajat Menghadap Baris 3',
                            'Dual Motor HTRAC AWD Bertenaga Buas',
                            'Jarak Tempuh Maksimal Hingga 620 KM (WLTP)',
                            'Panoramic Curved Display Dual 12.3-inch',
                            'Universal Island 2.0 Konsol Geser Elektrik',
                            'Fitur V2L Portabel 3.6 kW'
                        ]
                    ],
                    [
                        'name' => 'Calligraphy AWD 6P Power Seat',
                        'price' => 1557000000,
                        'transmission' => 'Dual Motor Electric AWD',
                        'engine' => 'Dual Motor Electric 110.3 kWh Battery (313 PS / 605 Nm)',
                        'key_features' => [
                            'Relaxation Comfort Seats Baris 1 & 2 dengan Dynamic Body Care (Fungsi Pijat)',
                            'Kemewahan Kelas Tertinggi dengan Kulit Nappa Pilihan',
                            'Dual Sunroof dengan Pencahayaan Mood Lounge',
                            'Meridian/Bose Premium Spatial Surround Audio',
                            'Kaca Kedap Suara Acoustic Dual-Pane All Round',
                            'Hyundai SmartSense Otonom Level 2+ Terlengkap'
                        ]
                    ]
                ]
            ]
        ];

        foreach ($carsData as $slug => $data) {
            $car = Car::where('slug', $slug)->first();
            if ($car) {
                $car->update([
                    'features' => $data['features'],
                    'variants' => $data['variants']
                ]);
                $this->command->info("Updated specifications for: {$car->name}");
            }
        }
    }
}
