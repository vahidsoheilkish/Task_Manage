<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CompletedTasks implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public mixed $completedTasks;

    /**
     * Create a new event instance.
     */
    public function __construct($completedTasks)
    {
        $this->completedTasks = $completedTasks;
    }

    public function broadcastWith(): array
    {
        return [
            'completed_tasks' => $this->completedTasks
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
            new Channel('completedTasksChannel'),
        ];
    }

}
