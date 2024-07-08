<?php

use App\Http\Controllers\Admin\GuestController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/dashboard', fn () => Inertia::render('Dashboard'))->name('dashboard');

Route::resource('guests', GuestController::class);
