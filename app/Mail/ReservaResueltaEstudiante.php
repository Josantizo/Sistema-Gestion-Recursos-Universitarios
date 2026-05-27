<?php

namespace App\Mail;

use App\Models\Reserva;
use App\Models\Usuario;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservaResueltaEstudiante extends Mailable
{
    use Queueable, SerializesModels;

    public $reserva;
    public $docente;

    /**
     * Create a new message instance.
     */
    public function __construct(Reserva $reserva, Usuario $docente)
    {
        $this->reserva = $reserva;
        $this->docente = $docente;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $estado = ucfirst($this->reserva->estado);
        return new Envelope(
            subject: "Solicitud de Reserva {$estado}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reserva-resuelta',
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
