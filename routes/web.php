<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TaskController;

Route::get('/home', [TemplateController::class, 'show'])->name('home');
Route::get('/table', [TemplateController::class, 'table'])->name('table');
Route::get('/form', [TemplateController::class, 'form'])->name('form');

// Endpoint API Teams dan Projects
// Route::apiResource('teams', TeamController::class);
// Route::resource('project', ProjectController::class);

Route::get('project', [ProjectController::class, 'index']);
Route::get('project/add', [ProjectController::class, 'create']);
Route::post('project/add', [ProjectController::class, 'store']);

Route::get('project/{id}/edit', [ProjectController::class, 'edit']);
Route::patch('project/{id}/edit', [ProjectController::class, 'update']);
Route::delete('project/{id}/delete', [ProjectController::class, 'destroy']);

Route::get('task', [TaskController::class, 'index']);
Route::get('task/add', [TaskController::class, 'create']);
Route::post('task/add', [TaskController::class, 'store']);

Route::get('task/{id}/edit', [TaskController::class, 'edit']);
Route::patch('task/{id}/edit', [TaskController::class, 'update']);
Route::delete('task/{id}/delete', [TaskController::class, 'destroy']);

