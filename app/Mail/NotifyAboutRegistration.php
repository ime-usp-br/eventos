<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Event;

class NotifyAboutRegistration extends Mailable
{
    use Queueable, SerializesModels;

    public $evento;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Event $evento)
    {
        $this->evento = $evento;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.notifyAboutRegistration')
        ->subject("[Sistema de Eventos] Sua inscrição foi realizada com sucesso");
    }
}
