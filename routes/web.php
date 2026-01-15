<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::post('/update-lead', [DashboardController::class, 'updateLead']);
Route::post('/add-lead', [DashboardController::class, 'addLead']);
