<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewTransaction implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $transaction;

    /**
     * Create a new event instance.
     */
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    public function broadcastAs()
    {
        return 'new_entry';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->transaction->participant->id,
            'name' => $this->transaction->participant->name,
            'points' => $this->transaction->points
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('ranking'),
        ];
    }
}
