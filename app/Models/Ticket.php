<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'booking_id', 'qr_code', 'is_used', 'issued_at', 'used_at',
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'issued_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
