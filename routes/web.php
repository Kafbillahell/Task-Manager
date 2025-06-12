<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TaskController;

Route::get('/home', [TemplateController::class, 'show'])->name('home');
Route::get('/table', [TemplateController::class, 'table'])->name('table');
Route::get('/form', [TemplateController::class, 'form'])->name('form');

// Endpoint API Teams dan Projects
Route::apiResource('teams', TeamController::class);
Route::apiResource('projects', ProjectController::class);
Route::get('tasks', [TaskController::class, 'showBoard']);
Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');