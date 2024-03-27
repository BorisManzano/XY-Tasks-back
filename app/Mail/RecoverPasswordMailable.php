<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecoverPasswordMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
 
    public function __construct($token)
    {
        $this->token = $token;
    }

   
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('xy_tasks@gmail.com', 'XY Tasks'),
            subject: 'Restablece tu clave',
        );
    }

    
    public function content(): Content
    {
        return new Content(
            view: 'emails.recoverPassword',
        );
    }


    public function build()
    {
        return $this->subject('Restablecer contraseña')
                    ->view('emails.recoverPassword')
                    ->with([
                        'resetUrl' => 'http://localhost:8080/updatePassword?token=' . $this->token,
                    ]);
    }


    public function attachments(): array
    {
        return [];
    }
}
