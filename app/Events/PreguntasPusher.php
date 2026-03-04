<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PreguntasPusher implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pregunta;

    public function __construct($pregunta)
    {
        $this->pregunta = $pregunta;
    }

    public function broadcastOn()
    {
        return new Channel('preguntas-channel');
    }

    public function broadcastAs()
    {
        return 'preguntas.event';
    }
}
