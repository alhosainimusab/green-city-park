<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Promotion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $visitors = User::where('role', 'visitor')->get();
        $welcome  = Promotion::where('code', 'WELCOME20')->first();
        $family   = Promotion::where('code', 'FAMILY500')->first();
        $summer   = Promotion::where('code', 'SUMMER30')->first();
        $eid      = Promotion::where('code', 'EID2026')->first();
        $staffId  = User::where('role', 'staff')->first()?->id ?? 1;

        $bookingsData = [
            // Confirmed + Verified payment + Tickets
            ['user' => 0, 'type' => 'adult',  'qty' => 2,  'promo' => $welcome,  'date_offset' => -5,  'status' => 'confirmed', 'pay_method' => 'exchange_transfer', 'pay_status' => 'verified'],
            ['user' => 1, 'type' => 'child',  'qty' => 3,  'promo' => null,      'date_offset' => 3,   'status' => 'confirmed', 'pay_method' => 'exchange_transfer', 'pay_status' => 'verified'],
            ['user' => 2, 'type' => 'group',  'qty' => 12, 'promo' => $summer,   'date_offset' => 7,   'status' => 'confirmed', 'pay_method' => 'cash_at_gate',      'pay_status' => 'verified'],
            ['user' => 0, 'type' => 'adult',  'qty' => 4,  'promo' => $family,   'date_offset' => 10,  'status' => 'confirmed', 'pay_method' => 'exchange_transfer', 'pay_status' => 'verified'],
            ['user' => 3, 'type' => 'adult',  'qty' => 1,  'promo' => null,      'date_offset' => -3,  'status' => 'confirmed', 'pay_method' => 'cash_at_gate',      'pay_status' => 'verified'],
            ['user' => 4, 'type' => 'child',  'qty' => 2,  'promo' => $welcome,  'date_offset' => 2,   'status' => 'confirmed', 'pay_method' => 'exchange_transfer', 'pay_status' => 'verified'],
            // Pending + Pending payment
            ['user' => 1, 'type' => 'adult',  'qty' => 2,  'promo' => $eid,      'date_offset' => 5,   'status' => 'pending',   'pay_method' => 'exchange_transfer', 'pay_status' => 'pending'],
            ['user' => 2, 'type' => 'child',  'qty' => 4,  'promo' => null,      'date_offset' => 8,   'status' => 'pending',   'pay_method' => 'cash_at_gate',      'pay_status' => 'pending'],
            ['user' => 5, 'type' => 'group',  'qty' => 15, 'promo' => $summer,   'date_offset' => 14,  'status' => 'pending',   'pay_method' => 'exchange_transfer', 'pay_status' => 'pending'],
            ['user' => 6, 'type' => 'adult',  'qty' => 3,  'promo' => $welcome,  'date_offset' => 6,   'status' => 'pending',   'pay_method' => 'exchange_transfer', 'pay_status' => 'pending'],
            // Rejected
            ['user' => 3, 'type' => 'adult',  'qty' => 2,  'promo' => null,      'date_offset' => 1,   'status' => 'rejected',  'pay_method' => 'exchange_transfer', 'pay_status' => 'rejected'],
            // Cancelled
            ['user' => 4, 'type' => 'child',  'qty' => 1,  'promo' => null,      'date_offset' => 4,   'status' => 'cancelled', 'pay_method' => 'cash_at_gate',      'pay_status' => 'pending'],
            // More confirmed
            ['user' => 5, 'type' => 'adult',  'qty' => 2,  'promo' => $eid,      'date_offset' => 15,  'status' => 'confirmed', 'pay_method' => 'exchange_transfer', 'pay_status' => 'verified'],
            ['user' => 6, 'type' => 'group',  'qty' => 10, 'promo' => $family,   'date_offset' => 20,  'status' => 'confirmed', 'pay_method' => 'cash_at_gate',      'pay_status' => 'verified'],
            ['user' => 0, 'type' => 'adult',  'qty' => 1,  'promo' => null,      'date_offset' => 25,  'status' => 'confirmed', 'pay_method' => 'exchange_transfer', 'pay_status' => 'verified'],
            ['user' => 1, 'type' => 'adult',  'qty' => 3,  'promo' => $summer,   'date_offset' => 30,  'status' => 'confirmed', 'pay_method' => 'exchange_transfer', 'pay_status' => 'verified'],
            ['user' => 2, 'type' => 'child',  'qty' => 2,  'promo' => null,      'date_offset' => 12,  'status' => 'pending',   'pay_method' => 'cash_at_gate',      'pay_status' => 'pending'],
            ['user' => 3, 'type' => 'adult',  'qty' => 2,  'promo' => $welcome,  'date_offset' => 18,  'status' => 'pending',   'pay_method' => 'exchange_transfer', 'pay_status' => 'pending'],
        ];

        foreach ($bookingsData as $i => $data) {
            $visitorKey = $data['user'];
            $visitor = $visitors->values()->get($visitorKey % $visitors->count());
            if (!$visitor) continue;

            $unitPrice = Booking::ticketPrice($data['type']);
            $qty       = $data['qty'];
            $sub       = $unitPrice * $qty;
            $discount  = 0;
            $promoId   = null;

            if ($data['promo']) {
                $promoId  = $data['promo']->id;
                $discount = $data['promo']->calculateDiscount($sub);
            }

            $total    = max(0, $sub - $discount);
            $visitDay = now()->addDays($data['date_offset']);

            $booking = Booking::create([
                'user_id'         => $visitor->id,
                'visit_date'      => $visitDay->toDateString(),
                'ticket_type'     => $data['type'],
                'quantity'        => $qty,
                'unit_price'      => $unitPrice,
                'total_price'     => $total,
                'status'          => $data['status'],
                'promo_id'        => $promoId,
                'discount_amount' => $discount,
                'notes'           => null,
            ]);

            // Payment
            $refNum = 'TRF-' . now()->format('Ymd') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT);
            $payment = Payment::create([
                'booking_id'     => $booking->id,
                'reference_no'   => $data['pay_method'] === 'cash_at_gate' ? null : $refNum,
                'amount'         => $total,
                'payment_method' => $data['pay_method'],
                'status'         => $data['pay_status'],
                'verified_by'    => $data['pay_status'] === 'verified' ? $staffId : null,
            ]);

            // Tickets for confirmed bookings
            if ($data['status'] === 'confirmed') {
                for ($t = 0; $t < min($qty, 5); $t++) {
                    Ticket::create([
                        'booking_id' => $booking->id,
                        'qr_code'    => 'GCEP-' . strtoupper(Str::random(8)),
                        'is_used'    => $data['date_offset'] < 0, // past visits are used
                        'issued_at'  => now()->subDays(rand(1, 3)),
                        'used_at'    => $data['date_offset'] < 0 ? $visitDay : null,
                    ]);
                }
            }
        }
    }
}
