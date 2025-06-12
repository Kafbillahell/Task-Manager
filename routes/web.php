<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamController;

Route::get('/home', [TemplateController::class, 'show'])->name('home');
Route::get('/table', [TemplateController::class, 'table'])->name('table');
Route::get('/form', [TemplateController::class, 'form'])->name('form');
// Endpoint API Teams dan Projects
Route::apiResource('teams', TeamController::class);
Route::apiResource('projects', ProjectController::class);

