<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Consultant;

class EvSavingsCalculator extends Component
{
    public string $selectedModel = 'ioniq5';
    public int $dailyDistance = 50; // km per hari
    public string $fuelType = 'pertamax';
    public int $petrolEfficiency = 10; // 1:10 km per liter
    public string $chargingType = 'home_discount';

    public array $evModels = [
        'ioniq5' => [
            'name' => 'Hyundai IONIQ 5',
            'tagline' => 'The Iconic Retro-Futuristic Crossover EV',
            'efficiency' => 6.5, // km per kWh
            'range' => 'Up to 481 KM',
            'badge' => 'Paling Populer',
        ],
        'kona_ev' => [
            'name' => 'All New KONA Electric',
            'tagline' => 'Smart Urban All-Electric Compact SUV',
            'efficiency' => 7.2, // km per kWh
            'range' => 'Up to 602 KM (Terjauh)',
            'badge' => 'Jarak Tempuh Juara',
        ],
        'ioniq6' => [
            'name' => 'Hyundai IONIQ 6',
            'tagline' => 'Electrified Streamliner Ultra-Aerodynamic',
            'efficiency' => 7.6, // km per kWh
            'range' => 'Up to 519 KM',
            'badge' => 'Flagship Luxury',
        ],
    ];

    public array $fuelPrices = [
        'pertalite' => [
            'label' => 'Pertalite (RON 90)',
            'price' => 10000,
        ],
        'pertamax' => [
            'label' => 'Pertamax (RON 92)',
            'price' => 12950,
        ],
        'pertamax_turbo' => [
            'label' => 'Pertamax Turbo (RON 98)',
            'price' => 14400,
        ],
        'solar' => [
            'label' => 'Dexlite / Diesel',
            'price' => 13700,
        ],
    ];

    public array $chargingRates = [
        'home_discount' => [
            'label' => 'Home Charging (Diskon 30% PLN Jam 22.00-05.00)',
            'rate' => 1187,
        ],
        'home_regular' => [
            'label' => 'Home Charging Reguler PLN (1.699 / kWh)',
            'rate' => 1699,
        ],
        'spklu' => [
            'label' => 'SPKLU Fast Charging Publik (2.466 / kWh)',
            'rate' => 2466,
        ],
    ];

    public function render()
    {
        $monthlyKm = $this->dailyDistance * 30;
        $yearlyKm = $this->dailyDistance * 365;

        // Petrol calculations
        $fuelPrice = $this->fuelPrices[$this->fuelType]['price'] ?? 12950;
        $monthlyLiters = $monthlyKm / max(1, $this->petrolEfficiency);
        $monthlyFuelCost = $monthlyLiters * $fuelPrice;
        $yearlyFuelCost = $monthlyFuelCost * 12;

        // EV calculations
        $evEfficiency = $this->evModels[$this->selectedModel]['efficiency'] ?? 6.5;
        $chargingRate = $this->chargingRates[$this->chargingType]['rate'] ?? 1187;
        $monthlyKwh = $monthlyKm / $evEfficiency;
        $monthlyEvCost = $monthlyKwh * $chargingRate;
        $yearlyEvCost = $monthlyEvCost * 12;

        // Savings
        $monthlySavings = max(0, $monthlyFuelCost - $monthlyEvCost);
        $yearlySavings = max(0, $yearlyFuelCost - $yearlyEvCost);
        $fiveYearSavings = $yearlySavings * 5;

        // Percentage saved
        $savingsPercentage = $monthlyFuelCost > 0 ? round(($monthlySavings / $monthlyFuelCost) * 100) : 0;

        // Environmental Impact (Avg petrol produces ~2.3 kg CO2 per liter burned)
        $yearlyCo2SavedKg = round(($monthlyLiters * 12) * 2.31);
        $equivalentTrees = round($yearlyCo2SavedKg / 22); // 1 mature tree absorbs ~22kg CO2/year

        $consultant = Consultant::first();

        return view('livewire.ev-savings-calculator', [
            'monthlyKm' => $monthlyKm,
            'monthlyFuelCost' => $monthlyFuelCost,
            'monthlyEvCost' => $monthlyEvCost,
            'monthlySavings' => $monthlySavings,
            'yearlySavings' => $yearlySavings,
            'fiveYearSavings' => $fiveYearSavings,
            'savingsPercentage' => $savingsPercentage,
            'yearlyCo2SavedKg' => $yearlyCo2SavedKg,
            'equivalentTrees' => $equivalentTrees,
            'consultant' => $consultant,
        ]);
    }
}
