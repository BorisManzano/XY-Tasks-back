<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;
 
    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('xy_tasks@gmail.com', 'XY Tasks'),
            subject: 'Configura tu cuenta',
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome',
        );
    }

    
    public function build()
    {
        return $this->subject('Configura tu cuenta')
                    ->with([
                        'resetUrl' => 'http://localhost:8080/updatePassword?token=' . $this->token . '&email=' . rawurlencode($this->email),
                    ]);
    }
    


    public function attachments(): array
    {
        return [];
    }

}
