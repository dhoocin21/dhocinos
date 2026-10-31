<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TradeIn extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_phone',
        'old_car_brand',
        'old_car_model',
        'old_car_year',
        'old_car_transmission',
        'old_car_mileage',
        'expected_price',
        'appraisal_price',
        'interested_car_id',
        'status',
        'notes',
    ];

    protected $casts = [
        'old_car_year' => 'integer',
        'old_car_mileage' => 'integer',
        'expected_price' => 'decimal:2',
        'appraisal_price' => 'decimal:2',
    ];

    public function interestedCar(): BelongsTo
    {
        return $this->belongsTo(Car::class, 'interested_car_id');
    }

    public function getCleanPhoneAttribute(): string
    {
        $phone = preg_replace('/[^0-9]/', '', (string)$this->customer_phone);
        if (str_starts_with($phone, '08')) {
            $phone = '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }
        return $phone;
    }
}
