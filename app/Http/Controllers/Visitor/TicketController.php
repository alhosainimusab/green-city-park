<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Ticket;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::whereHas('booking', function ($q) {
            $q->where('user_id', auth()->id())->where('status', 'confirmed');
        })->with('booking')->latest()->paginate(10);

        return view('visitor.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        if ($ticket->booking->user_id !== auth()->id()) {
            abort(403);
        }

        $qrSvg = QrCode::size(200)->generate($ticket->qr_code);

        return view('visitor.tickets.show', compact('ticket', 'qrSvg'));
    }
}
