<?php

namespace App\Events;

use App\Models\Slugable;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateSlugEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    public $table;
    public $key;
    public $section;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data,$table,$key,$section)
    {
        $this->data=$data;
        $this->table=$table;
        $this->key=$key;
        $this->section=$section;



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
