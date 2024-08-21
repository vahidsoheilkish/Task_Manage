<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UncompletedTasks implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public mixed $uncompletedTasks;

    /**
     * Create a new event instance.
     */
    public function __construct($uncompletedTasks)
    {
        $this->uncompletedTasks = $uncompletedTasks;
    }

    public function broadcastWith(): array
    {
        return [
            'uncompleted_tasks' => $this->uncompletedTasks
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
            new Channel('uncompletedTasksChannel'),
        ];
    }

}
