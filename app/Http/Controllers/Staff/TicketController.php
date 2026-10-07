<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function scanForm()
    {
        return view('staff.tickets.scan');
    }

    public function scan(Request $request)
    {
        $request->validate(['qr_code' => 'required|string']);

        $ticket = Ticket::where('qr_code', $request->qr_code)
            ->with('booking.user')
            ->first();

        if (!$ticket) {
            return back()->with('scan_result', [
                'success' => false,
                'message' => __('messages.ticket_not_found'),
            ]);
        }

        if ($ticket->is_used) {
            return back()->with('scan_result', [
                'success' => false,
                'ticket' => $ticket,
                'message' => __('messages.ticket_already_used'),
            ]);
        }

        if ($ticket->booking->status !== 'confirmed') {
            return back()->with('scan_result', [
                'success' => false,
                'ticket' => $ticket,
                'message' => __('messages.booking_not_confirmed'),
            ]);
        }

        $ticket->update([
            'is_used' => true,
            'used_at' => now(),
        ]);

        return back()->with('scan_result', [
            'success' => true,
            'ticket' => $ticket,
            'message' => __('messages.ticket_scanned_success'),
        ]);
    }
}
