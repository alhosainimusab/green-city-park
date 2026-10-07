<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    protected $fillable = [
        'name_ar', 'name_en', 'description_ar', 'description_en',
        'category', 'min_age', 'min_height', 'capacity', 'status', 'image',
        'traffic_level', 'wait_time',
    ];

    public function statusLogs()
    {
        return $this->hasMany(RideStatusLog::class);
    }

    public function getNameAttribute(): string
    {
        $lang = app()->getLocale();
        return $this->{"name_{$lang}"} ?? $this->name_ar;
    }

    public function getDescriptionAttribute(): string
    {
        $lang = app()->getLocale();
        return $this->{"description_{$lang}"} ?? $this->description_ar ?? '';
    }
}
