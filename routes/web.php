<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    dispatch(function(){
       return \App\Models\Task::query()->where('priority','high')->latest()->get();
    });
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



// Task Api
Route::post('/task/store',[TaskController::class,'store'])->name('task.store');
Route::patch('/task/update/{task}',[TaskController::class,'update'])->name('task.update');
Route::delete('/task/destroy/{task}',[TaskController::class,'destroy'])->name('task.destroy');
