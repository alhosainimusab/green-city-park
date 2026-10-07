<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RideStatusLog extends Model
{
    protected $fillable = [
        'ride_id', 'updated_by', 'old_status', 'new_status', 'reason',
    ];

    public function ride()
    {
        return $this->belongsTo(Ride::class);
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
