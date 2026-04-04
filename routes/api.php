<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\ProjectApiController;
use App\Http\Controllers\Api\SkillApiController;
use App\Http\Controllers\Api\CommissionApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toIso8601String(),
    ]);
});

Route::get('/projects', [ProjectApiController::class, 'index']);
Route::get('/projects/{id}', [ProjectApiController::class, 'show']);

Route::get('/skills', [SkillApiController::class, 'index']);

Route::post('/commissions', [CommissionApiController::class, 'store']);

// Authentication routes
Route::post('/auth/login', [AuthApiController::class, 'login']);
Route::post('/auth/register', [AuthApiController::class, 'register']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/auth/logout', [AuthApiController::class, 'logout']);
    Route::get('/auth/me', [AuthApiController::class, 'me']);

    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('api.admin.')->group(function () {
        // Projects
        Route::apiResource('projects', ProjectApiController::class)->except(['index', 'show']);
        
        // Skills
        Route::apiResource('skills', SkillApiController::class)->except(['index']);
        
        // Commissions
        Route::get('/commissions', [CommissionApiController::class, 'index']);
        Route::get('/commissions/{id}', [CommissionApiController::class, 'show']);
        Route::patch('/commissions/{id}/status', [CommissionApiController::class, 'updateStatus']);
        Route::post('/commissions/{id}/assign', [CommissionApiController::class, 'assign']);
        Route::delete('/commissions/{id}', [CommissionApiController::class, 'destroy']);
        
        // Statistics
        Route::get('/stats', function (Request $request) {
            return response()->json([
                'projects' => \App\Models\Project::count(),
                'skills' => \App\Models\Skill::count(),
                'commissions' => \App\Models\Commission::count(),
                'pending_commissions' => \App\Models\Commission::where('status', 'pending')->count(),
            ]);
        });
    });
});
