<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamController;

// API route untuk projects
Route::apiResource('projects', ProjectController::class);

// API route untuk teams
Route::apiResource('teams', TeamController::class);
