<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Route::get('dashboard',[DashboardController::class,'index'])->middleware('auth')->name('dashboard');

// Route::resource('categories',CategoryController::class)->middleware('auth');

Route::middleware('auth')->as('dashboard.')->prefix('dashboard')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
});
