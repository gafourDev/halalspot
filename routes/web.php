<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Api\RestaurantController;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

// Restaurant API resource routes
Route::prefix('api')->group(function () {
    Route::apiResource('restaurants', RestaurantController::class);
    Route::get('api/restaurants/nearby', [RestaurantController::class, 'nearby']);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return Inertia::render('admin/dashboard');
    })->name('admin.dashboard');
});

Route::middleware(['auth', 'role:user,owner'])->group(function () {
    Route::get('/user/dashboard', function () {
        return Inertia::render('users/dashboard');
    })->name('user.dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
