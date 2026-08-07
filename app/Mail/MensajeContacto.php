<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MensajeContacto extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $destinatario,
        public string $nombre,
        public string $email,
        public ?string $telefono,
        public string $mensaje,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            to: [$this->destinatario],
            replyTo: [$this->email],
            subject: 'Mensaje de contacto de ' . $this->nombre,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contacto',
            with: [
                'nombre' => $this->nombre,
                'email' => $this->email,
                'telefono' => $this->telefono,
                'mensaje' => $this->mensaje,
            ],
        );
    }
}
