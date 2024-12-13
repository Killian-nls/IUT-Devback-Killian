<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WeatherReport extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $weatherData;

    public function __construct($user, $weatherData)
    {
        $this->user = $user;
        $this->weatherData = $weatherData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Weather Report',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'email.weatherReport',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
