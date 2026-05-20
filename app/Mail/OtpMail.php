<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otpCode;

    public $purpose;

    public function __construct($otpCode, $purpose = 'verifikasi')
    {
        $this->otpCode = $otpCode;
        $this->purpose = $purpose;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Kode OTP Bursa Tenaga Kerja',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.otp',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}