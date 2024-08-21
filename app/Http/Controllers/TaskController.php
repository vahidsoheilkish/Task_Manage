<?php

namespace App\Http\Controllers;

use App\Jobs\CriticalTasks;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use function Symfony\Component\String\b;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * User create new task
     *
     * Input Data : title,description, end (date time), priority
     * @param Request $request
     * @return string
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'title'=>'required',
                'description'=>'required',
                'end'=>'required',
                'priority'=>'required',
            ]);

            Task::query()->create([
                'user_id'=> Auth::id(),
                'title' => $request->title,
                'description' => $request->description,
                'end' => $request->end,
                'priority' => $request->priority,
            ]);
            CriticalTasks::dispatch(Auth::user());
            Session::flash('message','Task created success');
            return back();
        }catch (\Exception $exception){
            Logger($exception->getMessage());
            return $exception->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * User create new task
     *
     * Input Data : title,description, end (date time), priority, status
     * @param Request $request
     * @return string
     */
    public function update(Request $request, Task $task)
    {
        try{
            $request->validate([
                'title_update'=>'required',
                'description_update'=>'required',
                'end_update'=>'required',
                'priority_update'=>'required',
                'status_update'=>'required',
            ]);

            $task->update([
                'user_id'=> Auth::id(),
                'title' => $request->title_update,
                'description' => $request->description_update,
                'end' => $request->end_update,
                'priority' => $request->priority_update,
                'status' => $request->status_update,
            ]);
            if ($request->priority == 'high')
                CriticalTasks::dispatch(Auth::user());

            Session::flash('message','Task updated success');
            return back();
        }catch (\Exception $exception){
            Logger($exception->getMessage());
            return $exception->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        try{
            $task->delete();
            Session::flash('message','Task deleted');
            return back();
        }catch (\Exception $exception){
            Logger($exception->getMessage());
            return $exception->getMessage();
        }
    }
}
