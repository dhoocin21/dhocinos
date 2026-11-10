<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'photo',
        'address',
        'bio',
        'instagram',
        'facebook',
        'tiktok',
        'maps_embed',
    ];

    public function getFormattedPhoneAttribute()
    {
        $phone = $this->phone;
        // Remove any non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // If it starts with 0, replace with 62
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }
        
        return $phone;
    }

    public function getPhotoUrlAttribute()
    {
        if (file_exists(public_path('consultants/nico-hardiansyah-official.jpg'))) {
            return asset('consultants/nico-hardiansyah-official.jpg');
        }

        if (!empty($this->photo)) {
            if (file_exists(public_path($this->photo))) {
                return asset($this->photo);
            }
            if (file_exists(storage_path('app/public/' . $this->photo))) {
                return asset('storage/' . $this->photo);
            }
        }

        return asset('consultants/nico-hardiansyah-official.jpg');
    }
}
