<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationAdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $last_name;
    public $first_name;
    public $email;
    public $room_type;
    public $plan_title;
    public $reservation_date;
    public $price;

    /**
     * Create a new message instance.
     */
    public function __construct($inputs, $plan, $slot)
    {
        $this->last_name = $inputs['last_name'];
        $this->first_name = $inputs['first_name'];
        $this->email = $inputs['email'];
        $this->room_type = $slot->room->type;
        $this->plan_title = $plan->title;
        $this->reservation_date = $slot->date;
        $this->price = number_format($slot->price + $plan->price);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '新しい予約を受け付けました。',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'reservation.admin_notification',
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
