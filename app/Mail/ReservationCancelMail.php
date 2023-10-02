<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationCancelMail extends Mailable
{
    use Queueable, SerializesModels;

    public $last_name;
    public $first_name;
    public $room_type;
    public $plan_title;
    public $reservation_date;
    public $price;

    /**
     * Create a new message instance.
     */
    public function __construct($reservation)
    {
        $this->last_name = $reservation->last_name;
        $this->first_name = $reservation->first_name;
        $this->room_type = $reservation->reservation_slot->room->type;
        $this->plan_title = $reservation->plan->title;
        $this->reservation_date = $reservation->reservation_slot->date;
        $this->price = number_format($reservation->reservation_slot->price + $reservation->plan->price);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '予約をキャンセルしました。',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'admin.reservations.cancel_mail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
