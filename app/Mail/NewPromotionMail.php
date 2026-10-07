<?php

namespace App\Mail;

use App\Models\Promotion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewPromotionMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Promotion $promotion) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: '🎉 Exclusive Offer: ' . $this->promotion->name_en . ' — Use Code ' . $this->promotion->code);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.new-promotion');
    }
}
