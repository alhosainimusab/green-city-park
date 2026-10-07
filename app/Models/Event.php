<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title_ar', 'title_en', 'description_ar', 'description_en',
        'event_date', 'start_time', 'end_time', 'location_ar', 'location_en',
        'image', 'is_active',
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function getTitleAttribute(): string
    {
        $lang = app()->getLocale();
        return $this->{"title_{$lang}"} ?? $this->title_ar;
    }

    public function getDescriptionAttribute(): string
    {
        $lang = app()->getLocale();
        return $this->{"description_{$lang}"} ?? $this->description_ar ?? '';
    }

    public function getLocationAttribute(): string
    {
        $lang = app()->getLocale();
        return $this->{"location_{$lang}"} ?? $this->location_ar ?? '';
    }
}
