<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CommissionOrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\CommissionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Commission Order Routes (Requires Authentication)
Route::middleware('auth')->group(function () {
    Route::get('/commissions', [CommissionOrderController::class, 'create'])->name('commissions.create');
    Route::post('/commissions', [CommissionOrderController::class, 'store'])->name('commissions.store');
    Route::get('/commissions/status', [CommissionOrderController::class, 'status'])->name('commissions.status');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Projects CRUD
    Route::resource('projects', ProjectController::class);

    // Skills CRUD
    Route::resource('skills', SkillController::class);

    // Commissions Management
    Route::get('/commissions', [CommissionController::class, 'index'])->name('commissions.index');
    Route::get('/commissions/{commission}', [CommissionController::class, 'show'])->name('commissions.show');
    Route::patch('/commissions/{commission}/status', [CommissionController::class, 'updateStatus'])->name('commissions.update-status');
    Route::post('/commissions/{commission}/assign', [CommissionController::class, 'assign'])->name('commissions.assign');
    Route::delete('/commissions/{commission}', [CommissionController::class, 'destroy'])->name('commissions.destroy');
});
