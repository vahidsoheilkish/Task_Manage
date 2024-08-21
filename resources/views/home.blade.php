@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
                @include('errors')
                @if(\Illuminate\Support\Facades\Session::exists('message'))
                    <span class="alert alert-success">
                        {{\Illuminate\Support\Facades\Session::get('message')}}
                    </span>
                @endif
                <div class="m-2">
                    <button class="btn btn-outline-success" data-toggle="modal"
                            data-target="#newTask"
                    >New Task</button>
                </div>
                <div class="tasks">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>End time</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Setting</th>
                            </tr>
                            @foreach($tasks as $task)
                                <tr>
                                    <td>{{$task->title}}</td>
                                    <td>{{$task->description}}</td>
                                    <td>{{$task->end}}</td>
                                    <td>
                                        @switch($task->priority)
                                            @case('high')
                                                <span class="alert alert-danger p-1">High</span>
                                            @break
                                            @case('middle')
                                                <span class="alert alert-warning p-1">Middle</span>
                                            @break
                                            @case('low')
                                                <span class="alert alert-success p-1">Low</span>
                                            @break
                                        @endswitch
                                    </td>
                                    <td>
                                        @switch($task->status)
                                            @case('progress')
                                                <span class="alert alert-info p-1">Progress</span>
                                            @break
                                            @case('suspend')
                                                <span class="alert alert-warning p-1">Suspend</span>
                                            @break
                                            @case('complete')
                                                <span class="alert alert-success p-1">Complete</span>
                                            @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <button onclick="fill_update_form(this)" data-toggle="modal"
                                                data-target="#updateTask"
                                                data-update="{{$task}}"
                                                class="btn btn-sm btn-info">Edit</button>
                                        <form action="{{route('task.destroy', $task->id)}}" method="post" class="destroyForm d-inline">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- New Task --}}
<div class="modal fade" id="newTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('task.store')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="end">End Time</label>
                        <input type="datetime-local" name="end" id="end" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="priority">End Time</label>
                        <select name="priority" id="priority" class="form-control">
                            <option value="high">High</option>
                            <option value="middle">Middle</option>
                            <option value="low">Low</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success" type="submit">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- Edit Task --}}
<div class="modal fade" id="updateTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" class="editForm" method="post">
                    @csrf
                    {{ method_field('PATCH') }}
                    <div class="form-group">
                        <label for="title_update">Title</label>
                        <input type="text" name="title_update" id="title_update" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="description_update">Description</label>
                        <textarea name="description_update" id="description_update" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="end_update">End Time</label>
                        <input type="datetime-local" name="end_update" id="end_update" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="priority_update" class="alert alert-warning p-1">Priority</label>
                        <select name="priority_update" id="priority_update" class="form-control">
                            <option value="high">High</option>
                            <option value="middle">Middle</option>
                            <option value="low">Low</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status_update" class="alert alert-danger p-1">Status</label>
                        <select name="status_update" id="status_update" class="form-control">
                            <option value="progress">Progress</option>
                            <option value="suspend">Suspend</option>
                            <option value="complete">Complete</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
    <script>
        function fill_update_form(e){
            let data = JSON.parse( $(e).attr('data-update') )
            console.log("data", data)
            $('.editForm').attr('action','/task/update/'+data.id)
            $("#title_update").val(data.title)
            $("#description_update").val(data.description)
            $("#end_update").val(data.end)
            $("#priority_update").val(data.priority)
            $("#status_update").val(data.status)
        }

        $(".destroyForm").submit(function (e){
            e.preventDefault();
            let sure = confirm("Are you sure to delete?")
            if(sure){
                e.currentTarget.submit();
            }
        })
    </script>
@endsection
