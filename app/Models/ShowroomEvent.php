<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowroomEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'event_date',
        'start_time',
        'end_time',
        'location',
        'description',
        'promo_highlights',
        'banner_image',
        'is_active',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'promo_highlights' => 'array',
        'is_active' => 'boolean',
    ];
}
