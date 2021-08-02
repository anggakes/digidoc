<?php

namespace App\Events;

use App\Models\Document;
use App\Models\DocumentAction;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Notif
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $docAct;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DocumentAction $docAct)
    {
        //
        $this->docAct = $docAct;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
