<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'whatsapp',
        'email',
        'promo_id',
        'car_id',
        'car_name',
        'lead_type',
        'purchase_type',
        'status',
        'notes',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'gclid',
        'ip_address',
        'region',
    ];

    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function getCleanWhatsappAttribute(): string
    {
        $phone = preg_replace('/[^0-9]/', '', $this->whatsapp ?? '');
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (!str_starts_with($phone, '62') && !empty($phone)) {
            $phone = '62' . $phone;
        }
        return $phone;
    }
}
