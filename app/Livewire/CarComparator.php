<?php

namespace App\Livewire;

use App\Models\Car;
use Livewire\Component;

class CarComparator extends Component
{
    public ?int $carId1 = null;
    public ?int $carId2 = null;

    public function mount(): void
    {
        $cars = Car::where('is_available', true)->get();
        if ($cars->count() >= 2) {
            $this->carId1 = $cars[0]->id;
            $this->carId2 = $cars[1]->id;
        } elseif ($cars->count() === 1) {
            $this->carId1 = $cars[0]->id;
            $this->carId2 = $cars[0]->id;
        }
    }

    public function render()
    {
        $allCars = Car::where('is_available', true)->orderBy('name')->get();
        $car1 = $this->carId1 ? Car::find($this->carId1) : null;
        $car2 = $this->carId2 ? Car::find($this->carId2) : null;

        return view('livewire.car-comparator', compact('allCars', 'car1', 'car2'));
    }
}
