<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'price',
        'description',
        'features',
        'variants',
        'image',
        'hero_image',
        'images',
        'flyer',
        'is_available',
    ];

    protected $casts = [
        'features' => 'array',
        'images' => 'array',
        'variants' => 'array',
        'is_available' => 'boolean',
    ];

    public function resolveImageUrl(?string $path): string
    {
        if (empty($path)) {
            return asset('assets/images/hyundai_logo.png');
        }

        // 1. Cek langsung di public/{path}
        if (file_exists(public_path($path))) {
            return asset($path);
        }

        // 2. Cek jika berada di public/cars/
        if (file_exists(public_path('cars/' . basename($path)))) {
            return asset('cars/' . basename($path));
        }

        // 3. Fallback standard storage
        return asset('storage/' . $path);
    }

    public function getImageUrlAttribute(): string
    {
        return $this->resolveImageUrl($this->image);
    }

    public function getHeroImageUrlAttribute(): string
    {
        return $this->hero_image ? $this->resolveImageUrl($this->hero_image) : $this->image_url;
    }

    public function getDetailImagesAttribute(): array
    {
        $raw = (!empty($this->images) && is_array($this->images) && count($this->images) > 0)
            ? $this->images
            : array_values(array_filter([$this->hero_image, $this->image]));

        return array_map(fn ($p) => $this->resolveImageUrl($p), $raw);
    }
}
