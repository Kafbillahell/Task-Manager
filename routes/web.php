<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TemplateController;

Route::get('/home', [TemplateController::class, 'show'])->name('home');
Route::get('/table', [TemplateController::class, 'table'])->name('table');
