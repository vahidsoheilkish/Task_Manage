<?php

namespace App\Jobs;

use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class CriticalTasks implements ShouldQueue
{
    use Queueable;
    private mixed $critical_tasks;
    private mixed $user;

    /**
     * Create a new job instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->critical_tasks = Cache::remember('critical_tasks', 60, function () {
            return Task::query()
//                ->where('user_id',$this->user_id)
                ->where('priority','high')
                ->latest()->get();
        });
    }
}
