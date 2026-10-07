<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'code', 'name_ar', 'name_en', 'description_ar', 'description_en',
        'discount_type', 'discount_value', 'valid_from', 'valid_until',
        'max_uses', 'used_count', 'is_active',
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
        'discount_value' => 'decimal:2',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'promo_id');
    }

    public function getNameAttribute(): string
    {
        $lang = app()->getLocale();
        return $this->{"name_{$lang}"} ?? $this->name_ar;
    }

    public function isValid(): bool
    {
        $today = now()->toDateString();
        if (!$this->is_active) return false;
        if ($today < $this->valid_from->toDateString()) return false;
        if ($today > $this->valid_until->toDateString()) return false;
        if ($this->max_uses && $this->used_count >= $this->max_uses) return false;
        return true;
    }

    public function calculateDiscount(float $amount): float
    {
        if ($this->discount_type === 'percentage') {
            return round($amount * $this->discount_value / 100, 2);
        }
        return min((float) $this->discount_value, $amount);
    }
}
