<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Event;

class NotifyModeratorAboutEvent extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $moderador, $evento, $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $moderador, Event $evento, $link)
    {
        $this->moderador = $moderador;
        $this->evento = $evento;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.notifyModeratorAboutEvent')
                    ->subject("[Sistema de Eventos] Um novo evento aguarda validação.");
    }
}
