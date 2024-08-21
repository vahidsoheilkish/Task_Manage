<?php

namespace App\Http\Controllers;

use App\Events\CompletedTasks;
use App\Events\testEvent;
use App\Events\UncompletedTasks;
use App\Jobs\CriticalTasks;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        $completedTask = Cache::remember('completed_tasks',60,function(){
//           return Task::query()->where('status','complete')
//               ->where('status','complete')
//               ->where('end','>=',Carbon::today())
//                ->latest()
//                ->get();
//        });

        $completedTask =  Task::query()
                ->where('status','complete')
                ->where('end','>=',Carbon::today())
                ->latest()
                ->get();

        $uncompletedTask =  Task::query()
            ->where('status','!=','complete')
            ->where('priority','high')
            ->latest()
            ->get();

        event(new CompletedTasks($completedTask));
        event(new UncompletedTasks($uncompletedTask));
        $tasks = Task::query()->where('user_id',Auth::id() )->latest()->get();
        return view('home',compact('tasks'));
    }
}
