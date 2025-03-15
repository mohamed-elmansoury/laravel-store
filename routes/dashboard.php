<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Route::get('dashboard',[DashboardController::class,'index'])->middleware('auth')->name('dashboard');

// Route::resource('categories',CategoryController::class)->middleware('auth');

Route::middleware('auth')->as('dashboard.')->prefix('dashboard')->group(function () {


    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('categories/trash', [CategoryController::class, 'trash'])->name('categories.trash');

    Route::put('categories/{category}/restore', [CategoryController::class, 'restore'])->name('categories.restore');

    Route::delete('categories/{category}/forceDelete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');

    Route::resource('categories', CategoryController::class);

    Route::resource('products', ProductController::class);
});
