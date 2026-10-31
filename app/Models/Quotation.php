<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_number',
        'customer_name',
        'customer_phone',
        'car_id',
        'variant_name',
        'otr_price',
        'discount',
        'dp_percent',
        'dp_amount',
        'tenor_months',
        'monthly_installment',
        'insurance_type',
        'notes',
    ];

    protected $casts = [
        'otr_price' => 'decimal:2',
        'discount' => 'decimal:2',
        'dp_amount' => 'decimal:2',
        'monthly_installment' => 'decimal:2',
        'dp_percent' => 'integer',
        'tenor_months' => 'integer',
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
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
