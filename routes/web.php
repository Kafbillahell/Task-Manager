<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TemplateController;

Route::get('/home', [TemplateController::class, 'show'])->name('home');
Route::get('/table', [TemplateController::class, 'table'])->name('table');

// Endpoint API Teams dan Projects
Route::apiResource('teams', TeamController::class);
Route::apiResource('projects', ProjectController::class);
