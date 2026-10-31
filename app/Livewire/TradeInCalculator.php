<?php

namespace App\Livewire;

use App\Models\Car;
use App\Models\Consultant;
use Livewire\Component;

class TradeInCalculator extends Component
{
    public string $brand = 'Toyota';
    public string $modelName = 'Avanza';
    public int $year = 2020;
    public string $transmission = 'Automatic';
    public string $mileage = '30000-60000';
    public string $condition = 'good'; // excellent, good, fair
    public ?int $targetCarId = null;

    public float $estimatedValue = 0;
    public float $targetCarPrice = 0;
    public float $netDpEstimate = 0;

    public function mount(): void
    {
        $firstCar = Car::where('is_available', true)->first();
        if ($firstCar) {
            $this->targetCarId = $firstCar->id;
            $this->targetCarPrice = (float) $firstCar->price;
        }
        $this->calculate();
    }

    public function updated($propertyName): void
    {
        if ($propertyName === 'targetCarId') {
            $car = Car::find($this->targetCarId);
            if ($car) {
                $this->targetCarPrice = (float) $car->price;
            }
        }
        $this->calculate();
    }

    public function calculate(): void
    {
        // Base valuation model based on year & brand tier
        $basePrices = [
            'Toyota' => 195000000,
            'Honda' => 205000000,
            'Mitsubishi' => 185000000,
            'Daihatsu' => 140000000,
            'Suzuki' => 150000000,
            'Hyundai' => 210000000,
            'Nissan' => 135000000,
            'Mazda' => 220000000,
            'Wuling' => 130000000,
            'Lainnya' => 140000000,
        ];

        $base = $basePrices[$this->brand] ?? 150000000;

        // Depreciation factor based on year (2026 is current year)
        $age = max(1, 2026 - $this->year);
        $depreciation = pow(0.92, $age); // 8% depreciation per year
        $val = $base * $depreciation;

        // Condition multiplier
        if ($this->condition === 'excellent') {
            $val *= 1.08;
        } elseif ($this->condition === 'fair') {
            $val *= 0.88;
        }

        // Mileage multiplier
        if ($this->mileage === '<30000') {
            $val *= 1.05;
        } elseif ($this->mileage === '>100000') {
            $val *= 0.90;
        }

        // Transmission
        if ($this->transmission === 'Automatic') {
            $val *= 1.04;
        }

        // Round to nearest 500,000
        $this->estimatedValue = round($val / 500000) * 500000;

        // Estimate standard 20% DP for target car
        $standardDp = $this->targetCarPrice * 0.20;
        $this->netDpEstimate = max(0, $standardDp - $this->estimatedValue);
    }

    public function getWhatsAppUrlProperty(): string
    {
        $targetCar = Car::find($this->targetCarId);
        $targetName = $targetCar ? $targetCar->name : 'Mobil Hyundai';
        $estValStr = 'Rp ' . number_format($this->estimatedValue, 0, ',', '.');
        $consultant = Consultant::first();
        $phone = $consultant?->formatted_phone ?? '081330135013';

        $text = "Halo Mas Nico (Sales Hyundai),\nSaya tertarik dengan program Tukar Tambah (Trade-In):\n"
              . "• Mobil Lama: {$this->brand} {$this->modelName} ({$this->year}) - {$this->transmission}\n"
              . "• Estimasi Taksiran Web: {$estValStr}\n"
              . "• Ingin Tukar ke Unit: {$targetName}\n"
              . "Mohon info jadwal inspeksi fisik & penawaran terbaiknya. Terima kasih!";

        return "https://api.whatsapp.com/send/?phone={$phone}&text=" . urlencode($text);
    }

    public function render()
    {
        $cars = Car::where('is_available', true)->orderBy('name')->get();
        return view('livewire.trade-in-calculator', compact('cars'));
    }
}
