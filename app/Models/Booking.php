<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id', 'visit_date', 'ticket_type', 'quantity',
        'adult_qty', 'child_qty', 'group_qty', 'infant_qty',
        'unit_price', 'total_price', 'status', 'promo_id',
        'discount_amount', 'notes',
    ];

    protected $casts = [
        'visit_date'      => 'date',
        'unit_price'      => 'decimal:2',
        'total_price'     => 'decimal:2',
        'discount_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promo_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public static function ticketPrice(string $type): int
    {
        return match($type) {
            'adult'  => 1500,
            'child'  => 800,
            'group'  => 1200,
            'infant' => 0,
            default  => 1500,
        };
    }

    public function hasBreakdown(): bool
    {
        return (($this->adult_qty ?? 0) + ($this->child_qty ?? 0)
              + ($this->group_qty ?? 0) + ($this->infant_qty ?? 0)) > 0;
    }

    // Number of paid tickets (excluding infants) — used for ticket generation
    public function paidQuantity(): int
    {
        if ($this->hasBreakdown()) {
            return (int)($this->adult_qty ?? 0)
                 + (int)($this->child_qty ?? 0)
                 + (int)($this->group_qty ?? 0);
        }
        return (int)$this->quantity;
    }
}
