<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReviewRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $token;

    public function __construct(Booking $booking, $token)
    {
        $this->booking = $booking;
        $this->token = $token;
    }

    public function build()
    {
        return $this->subject('Оставьте отзыв о визите в GIDRA')
                    ->view('emails.review-request');
    }
}